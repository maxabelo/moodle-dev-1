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


// moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");


// https://docs.moodle.org/dev/lib/formslib.php_Form_Definition#definition.28.29
class edit extends moodleform {

	// Add elements to form.
	public function definition() {
		// A reference to the form is stored in $this->form.
		// A common convention is to store it in a variable, such as `$mform`.
		$mform = $this->_form;

		// Add elements to your form.		- Inputs del form
		$mform->addElement('text', 'messagetext', get_string('message_label', 'local_message'));
		// Set type of element.
		$mform->setType('messagetext', PARAM_NOTAGS);
		// Default value.
		$mform->setDefault('messagetext', get_string('enter_message', 'local_message'));

		// // select input
		$choices = array();
		$choices['1'] = \core\output\notification::NOTIFY_WARNING;
		$choices['0'] = \core\output\notification::NOTIFY_SUCCESS;
		$choices['2'] = \core\output\notification::NOTIFY_ERROR;
		$choices['3'] = \core\output\notification::NOTIFY_INFO;
		$mform->addElement('select', 'messagetype', get_string('message_type', 'local_message'), $choices);
		$mform->setDefault('messagetype', 3);

		// submit
		$this->add_action_buttons();
	}

	// Custom validation should be added here.
	function validation($data, $files) {
		return [];
	}
}
