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
 * Luuniensuki - Imperial Vietnamese Heritage Theme.
 *
 * @package    theme_luuniensuki
 * @copyright  2025 Lưu Niên Sử Kí Project
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is the component name of the plugin - it always starts with 'theme_'
// for themes and should be the same as the name of the folder.
$plugin->component = 'theme_luuniensuki';

// This is the version of the plugin.
$plugin->version = 2025121001;

// This is the named version.
$plugin->release = '0.0.1-alpha';

// This is an alpha release.
$plugin->maturity = MATURITY_ALPHA;

// This is the version of Moodle this plugin requires.
$plugin->requires = 2025092600;

// This is a list of plugins, this plugin depends on (and their versions).
$plugin->dependencies = [
    'theme_boost' => 2025100600,
];
