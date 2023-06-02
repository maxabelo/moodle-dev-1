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

/**
 * Settings for the HTML block
 *
 * @copyright 2023 Adrian <adrian@example.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   local_quitahome
 */

// https://moodledev.io/docs/apis/subsystems/admin#settings-file-example
defined('MOODLE_INTERNAL') || die();

// Asegurarse de q las configs para este sitio esten establecidas, xq en estos local plugin no es 1 estandar
if ($hassiteconfig) {
	// crear la nueva pagina de configuracion
	$settings = new admin_settingpage( 
			'local_quitahome', 
			get_string('removehome', 'local_quitahome') 
	);

	// Crear la opción en admin
	$ADMIN->add( 'localplugins', $settings );
	// Agregar un campo de configuración a la configuración de esta página
	$settings->add(
		new admin_setting_configcheckbox(
			'local_quitahome_removehome', 
			get_string('removehome', 'local_quitahome'),
			get_string('removehome_desc', 'local_quitahome'), 
			0)
	);
}

