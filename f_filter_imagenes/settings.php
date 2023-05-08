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
 * Version metadata for the filter_imagenes plugin.
 *
 * @package   filter_imagenes
 * @copyright 2023 Adrian <adrian@example.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
	$settings->add(new admin_setting_configcheckbox(
		'filter_imagenes_centauro',
		get_string('centauro', 'filter_imagenes'),
		get_string('centauro_desc', 'filter_imagenes'),
		0
	));

	$settings->add(new admin_setting_configcheckbox(
		'filter_imagenes_fenix',
		get_string('fenix', 'filter_imagenes'),
		get_string('fenix_desc', 'filter_imagenes'),
		0
	));

	$settings->add(new admin_setting_configcheckbox(
		'filter_imagenes_gargola',
		get_string('gargola', 'filter_imagenes'),
		get_string('gargola_desc', 'filter_imagenes'),
		0
	));

	$settings->add(new admin_setting_configcheckbox(
		'filter_imagenes_pegaso',
		get_string('pegaso', 'filter_imagenes'),
		get_string('pegaso_desc', 'filter_imagenes'),
		0
	));
}

