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

/**
 * Gestión de la interfaz de configuración de Datacurso.
 *
 * @module     aiprovider_datacurso/settings
 * @copyright  2025 Wilber Narvaez
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import jQuery from 'jquery';

export const init = () => {
    const container = document.querySelector('#datacurso-settings-container');
    if (!container) {
        return;
    }

    // Manejar el cambio de estado de los checkboxes de habilitación.
    jQuery(container).on('change', '.enable-checker', (e) => {
        const checkbox = jQuery(e.currentTarget);
        const cardBody = checkbox.closest('.card-body');
        const dependentFields = cardBody.find('.dependent-fields');

        if (checkbox.is(':checked')) {
            dependentFields.removeClass('d-none').hide().slideDown('fast');
        } else {
            dependentFields.slideUp('fast', () => {
                dependentFields.addClass('d-none');
            });
        }
    });
};
