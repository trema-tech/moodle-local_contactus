<?php

/**
 * Admin settings for component 'contactus'.
 *
 * @copyright           Trema Tech
 * @author              @rmady & @trevorfurtado
 * @package             local_contactus
 * @license             http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if ($hassiteconfig) {
    $settings = new admin_settingpage('contactus', get_string('pluginname', 'local_contactus'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_configcheckbox('enablecontactus',
        get_string('enablecontactus', 'local_contactus'),
        get_string('enablecontactus_desc', 'local_contactus'), 1));
    $settings->add(new admin_setting_configtext('senderemail',
        get_string('senderemail', 'local_contactus'),
        get_string('senderemail_desc', 'local_contactus'), '', PARAM_EMAIL));
    $settings->add(new admin_setting_configcheckbox('enablesubject',
        get_string('enablesubject', 'local_contactus'),
        get_string('enablesubject_desc', 'local_contactus'), 0));
    $settings->add(new admin_setting_configtextarea('subjectlist',
        get_string('subjectlist', 'local_contactus'),
        get_string('subjectlist_desc', 'local_contactus'), '', PARAM_TEXT));
    $settings->add(new admin_setting_configcheckbox('enableresponsemessage',
        get_string('enableresponsemessage', 'local_contactus'),
        get_string('enableresponsemessage_desc', 'local_contactus'), 1));
    $settings->add(new admin_setting_configtextarea('responsemessage',
        get_string('responsemessage', 'local_contactus'),
        get_string('responsemessage_desc', 'local_contactus'),
        get_string('responsemessage_default', 'local_contactus'), PARAM_TEXT));
}
