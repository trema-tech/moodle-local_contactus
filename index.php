<?php

/**
 * Component 'contactus'.
 *
 * @copyright           Trema Tech
 * @author              @rmady & @trevorfurtado
 * @package             local_contactus
 * @license             http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$pageurl = new moodle_url('/local/contactus/index.php');

$PAGE->set_url($pageurl);
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('pluginname', 'local_contactus'));
$PAGE->set_heading(get_string('pluginname', 'local_contactus'));

//breadcrumb
$breadcrumb = $PAGE->navigation;
$thingnode = $breadcrumb->add(get_string('pluginname', 'local_contactus'), '/local/contactus/index.php');
$thingnode->make_active();

// enablecontactus
if(!$CFG->enablecontactus) {
    redirect("/", get_string('enablecontactus_error', 'local_contactus'), '', 'NOTIFY_ERROR');
}

// enablesubject
$subjects = '';
$enablesubject = $CFG->enablesubject;
if ($enablesubject) {
    $subjects = array();
    $temp = array_map('trim', explode("\n", $CFG->subjectlist));
    foreach ($temp as $subject) {
        $subjects[] = array("item" => $subject);
    }
}

if (isguestuser()) {
    $loggedin = false;
} else {
    $loggedin = isloggedin();
}

$templatecontext = [
    'loggedin' => $loggedin,
    'subjects' => $subjects,
    'enablesubject' => $enablesubject,
    'user' => $USER,
    'action' => "send_mail.php"
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_contactus/contactus', $templatecontext);
echo $OUTPUT->footer();

