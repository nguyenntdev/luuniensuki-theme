<?php
// Regenerate CSS for luuniensuki theme
define('CLI_SCRIPT', true);
require_once('/var/www/html/config.php');
require_once($CFG->libdir.'/clilib.php');
require_once($CFG->libdir.'/outputlib.php');

// Load the theme
$theme = theme_config::load('luuniensuki');

// Get CSS content
$css = $theme->get_css_content();

// Write to file
$cssfile = '/var/www/html/theme/luuniensuki/style/moodle.css';
file_put_contents($cssfile, $css);

echo "CSS regenerated successfully!\n";
echo "File: $cssfile\n";
echo "Size: " . filesize($cssfile) . " bytes\n";

