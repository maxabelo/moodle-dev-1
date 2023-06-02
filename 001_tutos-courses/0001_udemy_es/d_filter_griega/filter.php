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

class filter_mitologiagriega extends moodle_text_filter {
/* leer global param de toda la vida
	public function filter($text, array $options = array()) {
			global $CFG;

			// en el settings establecemos la word q queremos cambiar, se guarda en db, lo recuperamos y aqui le metemos la logica
			$word = $CFG->filter_mitologiagriega_word;

			// Return the modified text: c/v q encuentres el param lo reemplaza
			return str_replace($word, '<b>Mitología Griega</b>', $text);
	} */

	// local param - tiener ciertos bugs. NOOO leer de db, xq x c/word haria 1 consulta a db para verificar en donde hacer el cambio en el front
	public function filter($text, array $options = array()) {
			global $CFG;

			// loguear algo en moodle
			// print_object($this);

			if (isset($this->localconfig['word'])) {
				$word = $this->localconfig['word'];
			} else {
					$word = $CFG->filter_mitologiagriega_word;
			}

			return str_replace($word, '<b>Mitología Griega</b>', $text);
	}
}
