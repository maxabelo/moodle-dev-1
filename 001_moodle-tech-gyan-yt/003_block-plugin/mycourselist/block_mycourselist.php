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
 * Block definition class for the block_mycourselist plugin.
 *
 * @package   block_mycourselist
 * @copyright 2023, Adrian Changalombo <adrian@email.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


// https://moodledev.io/docs/apis/plugintypes/blocks#block_pluginnamephp
class block_mycourselist extends block_base
{
    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init()
    {
        $this->title = get_string('pluginname', 'block_mycourselist');
    }

    /**
     * Gets the block contents.
     *
     * @return string The block HTML.
     */
    public function get_content()
    {
        global $DB, $CFG, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = [];
        $this->content->icons = [];
        $this->content->footer = 'Footer';

        if (!empty($this->config->text)) {
            $this->content->text = 'Hello World';
        } else {
            // // query
            $sql = "SELECT * FROM mdl_course WHERE id != ?";
            $courses = $DB->get_records_sql($sql, [1]);
            // $courses = get_courses();

            $table = "<table class=\"mycourselist-table\"><tbody>";
            $table .= "<tr>
                <th>" . get_string('srn', 'block_mycourselist') . "</th>
                <th>" . get_string('course_name', 'block_mycourselist') . "</th>
                <th>" . get_string('course_id', 'block_mycourselist') . "</th>
            </tr>";

            $counter = 1;

            foreach ($courses as $course) {
                $table .= "<tr>
                    <td>" . $counter++ . "</td>
                    <td>" . $course->fullname . "</td>
                    <td>" . $course->idnumber . "</td>
                </tr>";
            }

            $table .= "</table></tbody>";

            $text .= $table;

            $this->content->text = $text;
        }

        return $this->content;
    }

    /**
     * Defines in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats()
    {
        return [
            'admin' => false,
            'site-index' => true,
            'course-view' => true,
            'mod' => false,
            'my' => true,
        ];
    }
}
