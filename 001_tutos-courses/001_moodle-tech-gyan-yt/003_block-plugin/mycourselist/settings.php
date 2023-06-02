<?php
// This file is part of Moodle - https://moodle.org/
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
 * Adds admin settings for the plugin.
 *
 * @package     block_mycourselist
 * @category    admin
 * @copyright 2023, Adrian Changalombo <adrian@email.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// // Los Block, Theme, Filter (propios de moodle) YA tienen configurado el    $settings   y el admin tree, lo cual NO pasa en los     local_pligins
// https://moodledev.io/docs/apis/subsystems/admin#settings-file-example

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('block_mycourselist', new lang_string('pluginname', 'block_mycourselist'));

    if ($ADMIN->fulltree) {
        // TODO: Define actual plugin settings page and add it to the tree
    }
}
