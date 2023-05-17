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
 * @category   phpunit
 */

use local_message\manager;

global $CFG;
require_once($CFG->dirroot . '/local/message/lib.php');

defined('MOODLE_INTERNAL') || die();

class local_message_manager_test extends advanced_testcase
{
    /**
     * Test that we can create a message.
     */
    public function test_create_message()
    {
        $this->resetAfterTest();
        $this->setUser(2); // mdl_user

        $manager = new manager();
        $textMessage = 'Test message';

        // get messages
        $messages = $manager->get_messages(2);
        $this->assertEmpty($messages);

        $type = \core\output\notification::NOTIFY_SUCCESS;
        $result = $manager->create_message($textMessage, $type);
        $this->assertTrue($result);

        // persisted in db
        $messages = $manager->get_messages(2);
        $this->assertNotEmpty($messages);
        $this->assertCount(1, $messages);
        $message = array_pop($messages);

        $this->assertEquals($textMessage, $message->messagetext);
        $this->assertEquals($type, $message->messagetype);
    }

    /**
     * Test that we get the correct messages.
     */
    public function test_get_messages()
    {
        global $DB;

        $this->resetAfterTest();
        $this->setUser(2); // mdl_user

        $manager = new manager();

        $type = \core\output\notification::NOTIFY_SUCCESS;
        $manager->create_message('Test message1', $type);
        $manager->create_message('Test message2', $type);
        $manager->create_message('Test message3', $type);

        $messages = $DB->get_records('local_message');

        foreach ($messages as $id => $message) {
            $manager->mark_message_read($id, 1);
        }

        // admin user
        $messagesAdmin = $manager->get_messages(2);
        $this->assertCount(3, $messagesAdmin);

        foreach ($messages as $id => $message) {
            $manager->mark_message_read($id, 2);
        }

        // messages already read
        $messagesAdmin = $manager->get_messages(2);
        $this->assertCount(0, $messagesAdmin);
    }
}
