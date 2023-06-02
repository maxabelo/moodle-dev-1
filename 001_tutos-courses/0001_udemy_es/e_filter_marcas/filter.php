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
 * Version metadata for the filter_marcas plugin.
 *
 * @package   filter_marcas
 * @copyright 2023 Adrian <adrian@example.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// https://docs.moodle.org/dev/Filters

defined('MOODLE_INTERNAL') || die();

class filter_marcas extends moodle_text_filter {

	public function filter($text, array $options = array()) {
		global $CFG;
		
		if (!empty($CFG->filter_marcas_ok)) {
			$okpicurl = new moodle_url('/pix/t/check.png');	// acceder a 1 archivo de moodle con la url
			$ok = html_writer::tag('img', '',			// build html como recomienda moodle - otra es mustache
				array('src' => $okpicurl, 'alt' => 'ok'));

			$text = str_replace('@ok@', $ok, $text);
		}

		if (!empty($CFG->filter_marcas_cross)) {
			$crosspicurl = new moodle_url('/pix/t/delete.png');
			$cross = html_writer::tag('img', '', 
							array('src' => $crosspicurl, 'alt' => 'cross'));

			$text = str_replace('@cross@', $cross, $text);
		}

		if (!empty($CFG->filter_marcas_award)) {
			$awardpicurl = new moodle_url('/pix/t/award.png');
			$award = html_writer::tag('img', '', 
							array('src' => $awardpicurl, 'alt' => 'award'));

			$text = str_replace('@award@', $award, $text);
		}
		
		return $text;
	}
}
