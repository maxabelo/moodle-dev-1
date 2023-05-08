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
 * Archivo de funciones auxiliares lib.php
 *
 * @package   local_decalogo
 * @copyright 2021 su nombre
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// output hook: https://docs.moodle.org/dev/Output_callbacks#before_footer
function local_message_before_footer() {
	// agregar notificaciones de NO redirect: https://docs.moodle.org/dev/Notifications#Notifications
	// \core\notification::success('Some error message');

	global $DB, $USER;
	// $messages = $DB->get_records('local_message');  // traer normalmente los records

	// // sql para traer solo si NO han sido vistos (ids en la otra tabla)
	// contruimos la query - left: traer aunq No hayan otros records en la otra table
	$sql = 'SELECT lm.id, lm.messagetext, lm.messagetype FROM {local_message} lm 
					LEFT JOIN {local_message_read} lmr ON lm.id = lmr.messageid
					WHERE lmr.userid <> :userid OR lmr.userid IS NULL';
	$params = [
		'userid' => $USER->id
	];
	$messages = $DB->get_records_sql($sql, $params);


	foreach ($messages as $message) {
		$type = \core\output\notification::NOTIFY_INFO;

		if ($message->messagetype === '1') {
			$type = \core\output\notification::NOTIFY_WARNING;
		}
		if ($message->messagetype === '0') {
			$type = \core\output\notification::NOTIFY_SUCCESS;
		}
		if ($message->messagetype === '2') {
			$type = \core\output\notification::NOTIFY_ERROR;
		}
		if ($message->messagetype === '3') {
			$type = \core\output\notification::NOTIFY_INFO;
		}

		\core\notification::add($message->messagetext, $type);
	
		
		// insert data into our db table - debemos crear la  row  entera como obj
		$readrecord = new stdClass();
		$readrecord->messageid = $message->id;
		$readrecord->userid = $USER->id;		// get userId from global variable, nos lo provee moodle
		$readrecord->timeread = time();

		$DB->insert_record('local_message_read', $readrecord);
	}
}