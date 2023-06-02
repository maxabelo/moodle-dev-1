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
 * Cadenas de idioma 'en'
 *
 * @package   local_bilingue
 * @copyright 2023 Adrian <adrian@example.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
// https://moodledev.io/docs/apis/subsystems/admin#settings-file-example
defined('MOODLE_INTERNAL') || die();


// Asegurarse de q las configs para este sitio esten establecidas, xq en estos local plugin no es 1 estandar
if ($hassiteconfig) {
	// crear la nueva pagina de configuracion
	$settings = new admin_settingpage( 
			'local_bilingue', 
			get_string('settingbilingual', 'local_bilingue') 
	);

	// Crear la opción en admin - Es en donde va a aparecer el acceso a este setting
	$ADMIN->add( 'localplugins', $settings );

	// Agregar un campo de configuración a la configuración de esta página
	$settings->add(
		new admin_setting_configcheckbox(
			'local_bilingue_enabled', 
			get_string('enabledbilingual', 'local_bilingue'),
			get_string('enabledbilingual_desc', 'local_bilingue'), 
			0)
	);

	// // tomamos el arr de Language Packs instalados en moodle
	// https://docs.moodle.org/dev/String_API
	$languages = get_string_manager()->get_list_of_translations(); 
	$currentlang = current_language();

	// // Procedemos a crear los  selects
	$settings->add(
		new admin_setting_configselect(
			'local_bilingue/primarylanguage', 
			get_string('primarylang', 'local_bilingue'), 
			get_string('primarylang_desc', 'local_bilingue'), 
			$currentlang, 
			$languages
		)
	);

	$settings->add(
		new admin_setting_configselect(
			'local_bilingue/secondarylanguage',   
			get_string('secondarylang', 'local_bilingue'), 
			get_string('secondarylang_desc', 'local_bilingue'), 
			$currentlang, 
			$languages
		)
	); 
}

