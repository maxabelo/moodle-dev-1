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
 * @package   local_message
 * @copyright 2023, Adrian Changalombo <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_message\form;
use moodleform;

// moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {
    // Add elements to form.
    public function definition() {
        $mform = $this->_form;

        // // add elements to your form.
        // id, messagetext, messagetype tal cual in DB para q se llenen en auto
        $mform->addElement('hidden', 'id'); // to edit in mvc
        $mform->setType('id', PARAM_INT);

		$mform->addElement('text', 'messagetext', get_string('message_label', 'local_message'));
        // set type of element.
		$mform->setType('messagetext', PARAM_NOTAGS);
        // default value.
		$mform->setDefault('messagetext', get_string('enter_message', 'local_message'));
        
		// select input
        $choices = array();
        $choices['0'] = \core\output\notification::NOTIFY_WARNING;
        $choices['1'] = \core\output\notification::NOTIFY_SUCCESS;
        $choices['2'] = \core\output\notification::NOTIFY_ERROR;
        $choices['3'] = \core\output\notification::NOTIFY_INFO;
        $mform->addElement('select', 'messagetype', get_string('message_type', 'local_message'), $choices);
        $mform->setDefault('messagetype', '3');

		// submit opts
        $this->add_action_buttons();
    }

    // Custom validation should be added here.
    function validation($data, $files) {
        return [];
    }
}
