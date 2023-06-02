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
 * Version metadata for the filter_mitologiagriega plugin.
 *
 * @package   filter_mitologiagriega
 * @copyright 2023 Adrian <adrian@example.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// al ser 1 filter es un plugin propio de moodle, x ente tiene configurado el treeadmin, settings y demas. A != del local
if ($ADMIN->fulltree) {

	// filter, block, theme generan en auto los settings asi q lo usamos directamente - mitologia es la palabra x efaul q se va a buscar
	$settings->add(new admin_setting_configtext(
			'filter_mitologiagriega_word',
			get_string('word', 'filter_mitologiagriega'),
			get_string('word_desc', 'filter_mitologiagriega'), 'mitología', PARAM_NOTAGS
		)
	);

}
