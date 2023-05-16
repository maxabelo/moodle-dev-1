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
 * Version details
 *
 * @package    local_message
 * @copyright  2023 Adrian
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


// asegura 1 moodle esta configurado y nos Habilita los Objetos Globales, como es  page debemos habilitarlo
require_once(__DIR__ . '/../../config.php');

global $DB; // x el config no hace falta la ref a page y output

// require_login();
// $context = context_system::instance();

// https://docs.moodle.org/dev/Page_API#.24PAGE_The_Moodle_page_global
$PAGE->set_url(new moodle_url('/local/message/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('manage_messages', 'local_message'));

$messages = $DB->get_records('local_message');


// // // Establecer el Output del HTML con el   Moodle Core Output
echo $OUTPUT->header();		// desplega el header


// // Display 1 Template de   Mustache
// context son variables q pasamos al template
$templatecontext = (object) [
	'messages' => array_values($messages),  // modifica los index del arr para q los coja bien mustache
	'editurl' => new moodle_url('/local/message/edit.php')
];
echo $OUTPUT->render_from_template('local_message/manage', $templatecontext);


echo $OUTPUT->footer();

