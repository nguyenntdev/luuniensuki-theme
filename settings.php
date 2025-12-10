<?php
// This file is part of Ranking block for Moodle - http://moodle.org/
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
 * Theme Moove block settings file
 *
 * @package    theme_luuniensuki
 * @copyright  2017 Willian Mano http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {
    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingluuniensuki', get_string('configtitle', 'theme_luuniensuki'));

    /*
    * ----------------------
    * General settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_luuniensuki_general', get_string('generalsettings', 'theme_luuniensuki'));

    // Logo file setting.
    $name = 'theme_luuniensuki/logo';
    $title = get_string('logo', 'theme_luuniensuki');
    $description = get_string('logodesc', 'theme_luuniensuki');
    $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
    $page->add($setting);

    // Favicon setting.
    $name = 'theme_luuniensuki/favicon';
    $title = get_string('favicon', 'theme_luuniensuki');
    $description = get_string('favicondesc', 'theme_luuniensuki');
    $opts = ['accepted_types' => ['.ico'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0, $opts);
    $page->add($setting);

    // Preset.
    $name = 'theme_luuniensuki/preset';
    $title = get_string('preset', 'theme_luuniensuki');
    $description = get_string('preset_desc', 'theme_luuniensuki');
    $default = 'default.scss';

    $context = \core\context\system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_luuniensuki', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_luuniensuki/presetfiles';
    $title = get_string('presetfiles', 'theme_luuniensuki');
    $description = get_string('presetfiles_desc', 'theme_luuniensuki');

    $setting = new admin_setting_configstoredfile(
        $name,
        $title,
        $description,
        'preset',
        0,
        ['maxfiles' => 10, 'accepted_types' => ['.scss']]
    );
    $page->add($setting);

    // Theme preset selection (Classic vs Imperial).
    $name = 'theme_luuniensuki/themepreset';
    $title = get_string('themepreset', 'theme_luuniensuki');
    $description = get_string('themepreset_desc', 'theme_luuniensuki');
    $default = 'classic';
    $choices = [
        'classic' => get_string('themepreset_classic', 'theme_luuniensuki'),
        'imperial' => get_string('themepreset_imperial', 'theme_luuniensuki')
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Login page background image.
    $name = 'theme_luuniensuki/loginbgimg';
    $title = get_string('loginbgimg', 'theme_luuniensuki');
    $description = get_string('loginbgimg_desc', 'theme_luuniensuki');
    $opts = ['accepted_types' => ['.png', '.jpg', '.svg']];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbgimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $brand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_luuniensuki/brandcolor';
    $title = get_string('brandcolor', 'theme_luuniensuki');
    $description = get_string('brandcolor_desc', 'theme_luuniensuki');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#C4A35A');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-header-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_luuniensuki/secondarymenucolor';
    $title = get_string('secondarymenucolor', 'theme_luuniensuki');
    $description = get_string('secondarymenucolor_desc', 'theme_luuniensuki');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#C4A35A');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $fontsarr = [
        'Moodle' => 'Moodle Font',
        'Roboto' => 'Roboto',
        'Poppins' => 'Poppins',
        'Montserrat' => 'Montserrat',
        'Open Sans' => 'Open Sans',
        'Lato' => 'Lato',
        'Raleway' => 'Raleway',
        'Inter' => 'Inter',
        'Nunito' => 'Nunito',
        'Encode Sans' => 'Encode Sans',
        'Work Sans' => 'Work Sans',
        'Oxygen' => 'Oxygen',
        'Manrope' => 'Manrope',
        'Sora' => 'Sora',
        'Epilogue' => 'Epilogue',
        'Playfair Display' => 'Playfair Display (Serif)',
        'Be Vietnam Pro' => 'Be Vietnam Pro (Vietnamese)',
    ];

    $name = 'theme_luuniensuki/fontsite';
    $title = get_string('fontsite', 'theme_luuniensuki');
    $description = get_string('fontsite_desc', 'theme_luuniensuki');
    $setting = new admin_setting_configselect($name, $title, $description, 'Roboto', $fontsarr);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_luuniensuki/enablecourseindex';
    $title = get_string('enablecourseindex', 'theme_luuniensuki');
    $description = get_string('enablecourseindex_desc', 'theme_luuniensuki');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $name = 'theme_luuniensuki/enableclassicbreadcrumb';
    $title = get_string('enableclassicbreadcrumb', 'theme_luuniensuki');
    $description = get_string('enableclassicbreadcrumb_desc', 'theme_luuniensuki');
    $default = 0;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    /*
    * ----------------------
    * Advanced settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_luuniensuki_advanced', get_string('advancedsettings', 'theme_luuniensuki'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode(
        'theme_luuniensuki/scsspre',
        get_string('rawscsspre', 'theme_luuniensuki'),
        get_string('rawscsspre_desc', 'theme_luuniensuki'),
        '',
        PARAM_RAW
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode(
        'theme_luuniensuki/scss',
        get_string('rawscss', 'theme_luuniensuki'),
        get_string('rawscss_desc', 'theme_luuniensuki'),
        '',
        PARAM_RAW
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Google analytics block.
    $name = 'theme_luuniensuki/googleanalytics';
    $title = get_string('googleanalytics', 'theme_luuniensuki');
    $description = get_string('googleanalyticsdesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // H5P custom CSS.
    $setting = new admin_setting_configtextarea(
        'theme_luuniensuki/hvpcss',
        get_string('hvpcss', 'theme_luuniensuki'),
        get_string('hvpcss_desc', 'theme_luuniensuki'),
        ''
    );
    $page->add($setting);

    $settings->add($page);

    /*
    * -----------------------
    * Frontpage settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_luuniensuki_frontpage', get_string('frontpagesettings', 'theme_luuniensuki'));

    // Disable teachers from cards.
    $name = 'theme_luuniensuki/disableteacherspic';
    $title = get_string('disableteacherspic', 'theme_luuniensuki');
    $description = get_string('disableteacherspicdesc', 'theme_luuniensuki');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Slideshow.
    $name = 'theme_luuniensuki/slidercount';
    $title = get_string('slidercount', 'theme_luuniensuki');
    $description = get_string('slidercountdesc', 'theme_luuniensuki');
    $default = 0;
    $options = [];
    for ($i = 0; $i < 13; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $slidercount = get_config('theme_luuniensuki', 'slidercount');

    if (!$slidercount) {
        $slidercount = $default;
    }

    if ($slidercount) {
        for ($sliderindex = 1; $sliderindex <= $slidercount; $sliderindex++) {
            $fileid = 'sliderimage' . $sliderindex;
            $name = 'theme_luuniensuki/sliderimage' . $sliderindex;
            $title = get_string('sliderimage', 'theme_luuniensuki');
            $description = get_string('sliderimagedesc', 'theme_luuniensuki');
            $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
            $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
            $page->add($setting);

            $name = 'theme_luuniensuki/slidertitle' . $sliderindex;
            $title = get_string('slidertitle', 'theme_luuniensuki');
            $description = get_string('slidertitledesc', 'theme_luuniensuki');
            $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
            $page->add($setting);

            $name = 'theme_luuniensuki/slidercap' . $sliderindex;
            $title = get_string('slidercaption', 'theme_luuniensuki');
            $description = get_string('slidercaptiondesc', 'theme_luuniensuki');
            $default = '';
            $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
            $page->add($setting);
        }
    }

    $setting = new admin_setting_heading('slidercountseparator', '', '<hr>');
    $page->add($setting);

    $name = 'theme_luuniensuki/displaymarketingbox';
    $title = get_string('displaymarketingboxes', 'theme_luuniensuki');
    $description = get_string('displaymarketingboxesdesc', 'theme_luuniensuki');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $displaymarketingbox = get_config('theme_luuniensuki', 'displaymarketingbox');

    if ($displaymarketingbox) {
        // Marketingheading.
        $name = 'theme_luuniensuki/marketingheading';
        $title = get_string('marketingsectionheading', 'theme_luuniensuki');
        $default = 'Awesome App Features';
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $page->add($setting);

        // Marketingcontent.
        $name = 'theme_luuniensuki/marketingcontent';
        $title = get_string('marketingsectioncontent', 'theme_luuniensuki');
        $default = 'Luuniensuki is an Imperial Vietnamese Heritage-themed Moodle template based on Boost with elegant design.';
        $setting = new admin_setting_confightmleditor($name, $title, '', $default);
        $page->add($setting);

        for ($i = 1; $i < 5; $i++) {
            $filearea = "marketing{$i}icon";
            $name = "theme_luuniensuki/$filearea";
            $title = get_string('marketingicon', 'theme_luuniensuki', $i . '');
            $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg']];
            $setting = new admin_setting_configstoredfile($name, $title, '', $filearea, 0, $opts);
            $page->add($setting);

            $name = "theme_luuniensuki/marketing{$i}heading";
            $title = get_string('marketingheading', 'theme_luuniensuki', $i . '');
            $default = 'Lorem';
            $setting = new admin_setting_configtext($name, $title, '', $default);
            $page->add($setting);

            $name = "theme_luuniensuki/marketing{$i}content";
            $title = get_string('marketingcontent', 'theme_luuniensuki', $i . '');
            $default = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.';
            $setting = new admin_setting_confightmleditor($name, $title, '', $default);
            $page->add($setting);
        }

        $setting = new admin_setting_heading('displaymarketingboxseparator', '', '<hr>');
        $page->add($setting);
    }

    // Enable or disable Numbers sections settings.
    $name = 'theme_luuniensuki/numbersfrontpage';
    $title = get_string('numbersfrontpage', 'theme_luuniensuki');
    $description = get_string('numbersfrontpagedesc', 'theme_luuniensuki');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $numbersfrontpage = get_config('theme_luuniensuki', 'numbersfrontpage');

    if ($numbersfrontpage) {
        $name = 'theme_luuniensuki/numbersfrontpagecontent';
        $title = get_string('numbersfrontpagecontent', 'theme_luuniensuki');
        $description = get_string('numbersfrontpagecontentdesc', 'theme_luuniensuki');
        $default = get_string('numbersfrontpagecontentdefault', 'theme_luuniensuki');
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $page->add($setting);
    }

    // Enable FAQ.
    $name = 'theme_luuniensuki/faqcount';
    $title = get_string('faqcount', 'theme_luuniensuki');
    $description = get_string('faqcountdesc', 'theme_luuniensuki');
    $default = 0;
    $options = [];
    for ($i = 0; $i < 11; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $page->add($setting);

    $faqcount = get_config('theme_luuniensuki', 'faqcount');

    if ($faqcount > 0) {
        for ($i = 1; $i <= $faqcount; $i++) {
            $name = "theme_luuniensuki/faqquestion{$i}";
            $title = get_string('faqquestion', 'theme_luuniensuki', $i . '');
            $setting = new admin_setting_configtext($name, $title, '', '');
            $page->add($setting);

            $name = "theme_luuniensuki/faqanswer{$i}";
            $title = get_string('faqanswer', 'theme_luuniensuki', $i . '');
            $setting = new admin_setting_confightmleditor($name, $title, '', '');
            $page->add($setting);
        }

        $setting = new admin_setting_heading('faqseparator', '', '<hr>');
        $page->add($setting);
    }

    $settings->add($page);

    /*
    * --------------------
    * Footer settings tab
    * --------------------
    */
    $page = new admin_settingpage('theme_luuniensuki_footer', get_string('footersettings', 'theme_luuniensuki'));

    // Website.
    $name = 'theme_luuniensuki/website';
    $title = get_string('website', 'theme_luuniensuki');
    $description = get_string('websitedesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Mobile.
    $name = 'theme_luuniensuki/mobile';
    $title = get_string('mobile', 'theme_luuniensuki');
    $description = get_string('mobiledesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Mail.
    $name = 'theme_luuniensuki/mail';
    $title = get_string('mail', 'theme_luuniensuki');
    $description = get_string('maildesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // TikTok url setting.
    $name = 'theme_luuniensuki/tiktok';
    $title = get_string('tiktok', 'theme_luuniensuki');
    $description = get_string('tiktokdesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Facebook url setting.
    $name = 'theme_luuniensuki/facebook';
    $title = get_string('facebook', 'theme_luuniensuki');
    $description = get_string('facebookdesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Twitter url setting.
    $name = 'theme_luuniensuki/twitter';
    $title = get_string('twitter', 'theme_luuniensuki');
    $description = get_string('twitterdesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Linkdin url setting.
    $name = 'theme_luuniensuki/linkedin';
    $title = get_string('linkedin', 'theme_luuniensuki');
    $description = get_string('linkedindesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Youtube url setting.
    $name = 'theme_luuniensuki/youtube';
    $title = get_string('youtube', 'theme_luuniensuki');
    $description = get_string('youtubedesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Instagram url setting.
    $name = 'theme_luuniensuki/instagram';
    $title = get_string('instagram', 'theme_luuniensuki');
    $description = get_string('instagramdesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Pinterest url setting.
    $name = 'theme_luuniensuki/pinterest';
    $title = get_string('pinterest', 'theme_luuniensuki');
    $description = get_string('pinterestdesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Whatsapp url setting.
    $name = 'theme_luuniensuki/whatsapp';
    $title = get_string('whatsapp', 'theme_luuniensuki');
    $description = get_string('whatsappdesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Telegram url setting.
    $name = 'theme_luuniensuki/telegram';
    $title = get_string('telegram', 'theme_luuniensuki');
    $description = get_string('telegramdesc', 'theme_luuniensuki');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    $settings->add($page);

    /*
    * --------------------
    * Footer settings tab
    * --------------------
    */
    $page = new admin_settingpage('theme_luuniensuki_darkmode', get_string('darkmodesettings', 'theme_luuniensuki'));

    // Enable dark mode footer.
    $name = 'theme_luuniensuki/enabledarkmode';
    $title = get_string('darkmode_enable', 'theme_luuniensuki');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, '', $default, $choices);
    $page->add($setting);

    // Logo file setting.
    $name = 'theme_luuniensuki/logodark';
    $title = get_string('logodark', 'theme_luuniensuki');
    $description = get_string('logodarkdesc', 'theme_luuniensuki');
    $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logodark', 0, $opts);
    $page->add($setting);

    $settings->add($page);
}
