<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace aiprovider_datacurso\admin;

defined('MOODLE_INTERNAL') || die();

class setting_custom_gui extends \admin_setting {
    public function __construct() {
        // Nombre interno, título en la UI, descripción y valor por defecto.
        parent::__construct('aiprovider_datacurso/tenant_settings', 
            get_string('pluginname', 'aiprovider_datacurso'), '', '');
    }

    // Moodle requiere estos métodos aunque no los usemos de forma estándar.
    public function get_setting() { return true; }
    public function write_setting($data) { return ''; }

    public function output_html($data, $query = '') {
        global $OUTPUT, $PAGE;


        $services = \aiprovider_datacurso\provider::get_services();
        \core_collator::asort_array_of_arrays_by_key($services, 'name');

        $preparedservices = [];
        foreach ($services as $service) {
            $sid = $service['id'];
            
            $enabled = get_config('aiprovider_datacurso', "ratelimit_{$sid}_enable");
            $limit = get_config('aiprovider_datacurso', "ratelimit_{$sid}_limit") ?: 10;
            $window = get_config('aiprovider_datacurso', "ratelimit_{$sid}_window");

            $preparedservices[] = [
                'id' => $sid,
                'name' => format_string($service['name']),
                'enabled' => $enabled,
                'limit' => $limit,
                'window' => $window
            ];
        }

        $context = [
            'licensekey' => get_config('aiprovider_datacurso', 'licensekey'),
            'services' => $preparedservices,
            'sesskey' => sesskey(),
        ];

        return $OUTPUT->render_from_template('aiprovider_datacurso/setting_tenant', $context);
    }
}
