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
 * Adds admin settings for the plugin.
 * 
 * @package   local_message
 * @copyright 2023, Adrian Changalombo <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//  https://moodledev.io/docs/apis/subsystems/admin#settings-file-example
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) { // needs this condition or there is error on login page
	// create the category that agroup those links
	$ADMIN->add('localplugins', new admin_category('local_message_category', get_string('pluginname', 'local_message')));

	// create de plugin settings page
	$settings = new admin_settingpage('local_message', get_string('pluginname', 'local_message'));
	$ADMIN->add('local_message_category', $settings);
	$settings->add(
		new admin_setting_configcheckbox('local_message/enabled',
			get_string('setting_enable', 'local_message'),
			get_string('setting_enable_desc', 'local_message'),
			'1'
		)
	);
	
	$ADMIN->add(
		'local_message_category',
		new admin_externalpage('local_message_manage', get_string('manage', 'local_message'),
		$CFG->wwwroot . '/local/message/manage.php')
	);

}