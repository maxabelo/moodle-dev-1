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

// https://docs.moodle.org/dev/Filters

defined('MOODLE_INTERNAL') || die();

class filter_imagenes extends moodle_text_filter {

	public function filter($text, array $options = array()) {
		global $CFG;
		
		if (!empty($CFG->filter_imagenes_centauro)) {
			$picurl = new moodle_url('/filter/imagenes/pix/centauro.jpg'); // acceder a 1 archivo de moodle con la url
			$pic = html_writer::tag('img', '', 	// build html como recomienda moodle - otra es mustache
							array('src' => $picurl, 'alt' => 'Centauro'));
			$text = str_replace('@centauro@', $pic, $text);
		}

		if (!empty($CFG->filter_imagenes_fenix)) {
			$picurl = new moodle_url('/filter/imagenes/pix/fenix.jpg');
			$pic = html_writer::tag('img', '', 
							array('src' => $picurl, 'alt' => 'Ave Fénix'));
			$text = str_replace('@fenix@', $pic, $text);
		}

		if (!empty($CFG->filter_imagenes_gargola)) {
			$picurl = new moodle_url('/filter/imagenes/pix/gargola.png');
			$pic = html_writer::tag('img', '', 
							array('src' => $picurl, 'alt' => 'La gárgola'));
			$text = str_replace('@gargola@', $pic, $text);
		}

		if (!empty($CFG->filter_imagenes_pegaso)) {
			$picurl = new moodle_url('/filter/imagenes/pix/pegaso.jpg');
			$pic = html_writer::tag('img', '', 
							array('src' => $picurl, 'alt' => 'El pegaso'));
			$text = str_replace('@pegaso@', $pic, $text);
		}
		
		return $text;
	}
}
