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

namespace local_message;

use dml_exception;
use stdClass;

defined('MOODLE_INTERNAL') || die();

class manager
{

    /** Insert the form data into our database table.
     * @param string $message_text
     * @param string $message_type
     * @return bool true if successful
     */
    public function create_message(string $message_text, string $message_type): bool
    {
        global $DB;

        $record_to_insert = new stdClass();
        $record_to_insert->messagetext = $message_text;
        $record_to_insert->messagetype = $message_type;

        try {
            return $DB->insert_record('local_message', $record_to_insert, false);
        } catch (dml_exception $e) {
            return false;
        }
    }

    /** Gets all messages that have not been read by this user
     * @param int $userid the user that we are getting messages for
     * @return array of messages
     */
    public function get_messages($id): array
    {
        global $DB;

        $sql = "SELECT lm.id, lm.messagetext, lm.messagetype 
            FROM {local_message} lm 
            LEFT OUTER JOIN {local_message_read} lmr ON lm.id = lmr.messageid AND lmr.userid = :userid 
            WHERE lmr.userid IS NULL";

        $params = [
            'userid' => $id,
        ];

        $messages = $DB->get_records_sql($sql, $params);

        return $messages;
    }

    /** Mark that a message was read by this user.
     * @param int $message_id the message to mark as read
     * @param int $userid the user that we are marking message read
     * @return bool true if successful
     */
    public function mark_message_read($messageid, $userid): bool
    {
        global $DB;

        // build obj to insert in db
        $read_record = new stdClass();
        $read_record->messageid = $messageid;
        $read_record->userid = $userid;
        $read_record->timeread = time();

        try {
            // false to avoid returning the id
            return $DB->insert_record('local_message_read', $read_record, false);
        } catch (dml_exception $e) {
            return false;
        }
    }

    /** Get a single message from its id.
     * @param int $messageid the message we're trying to get.
     * @return object|false message data or false if not found.
     */
    public function get_message(int $messageid)
    {
        global $DB;
        return $DB->get_record('local_message', ['id' => $messageid]);
    }


    /** Update details for a single message.
     * @param int $messageid the message we're trying to get.
     * @param string $message_text the new text for the message.
     * @param string $message_type the new type for the message.
     * @return bool message data or false if not found.
     */
    public function update_message(int $messageid, string $message_text, string $message_type): bool
    {
        global $DB;

        $object = new stdClass();
        $object->id = $messageid;
        $object->messagetext = $message_text;
        $object->messagetype = $message_type;

        return $DB->update_record('local_message', $object);
    }

    /** Delete a message and all the read history.
     * @param $messageid
     * @return bool
     * @throws \dml_transaction_exception
     * @throws dml_exception
     */
    public function delete_message($messageid): bool
    {
        global $DB;

        // tansactions
        $transaction = $DB->start_delegated_transaction();

        $deleted_message = $DB->delete_records('local_message', ['id' => $messageid]);
        $deleted_read = $DB->delete_records('local_message_read', ['id' => $messageid]);

        if ($deleted_message && $deleted_read) {
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}
