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


require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/edit.php');

global $DB;  // w with db

$PAGE->set_url(new moodle_url('/local/message/edit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Edit');


// // // We want to display OUR form
// $mdorm = new tool_licencemanager\form\edit_license();	// moodle ford
// Instantiate the myform form from within the plugin.
// $mform = new \local_message\form\edit();
$mform = new edit();




// Form processing and displaying is done here.
if ($mform->is_cancelled()) {
	// go back to manage page - Nunca tener 1  echo $OUTPUT  antes de 1 redirect
	redirect($CFG->wwwroot . '/local/message/manage.php', get_string('cancelled_form', 'local_message'));
} else if ($fromform = $mform->get_data()) {
 	// When the form is submitted, and the data is successfully validated, the   `get_data()`  fn will return the data posted in the form.

 	// insert data into our db table - debemos crear la  row  entera como obj
	$recordtoinsert = new stdClass();
	$recordtoinsert->messagetext = $fromform->messagetext;
	$recordtoinsert->messagetype = $fromform->messagetype;

	$DB->insert_record('local_message', $recordtoinsert);

	redirect($CFG->wwwroot . '/local/message/manage.php', get_string('message_created', 'local_message')
			. $fromform->messagetext
	);
}



echo $OUTPUT->header();		// desplega el header


$mform->display();

echo $OUTPUT->footer();

