<?php

/**
 * Sendmail for component 'contactus'.
 *
 * @copyright           Trema Tech
 * @author              @rmady & @trevorfurtado
 * @package             local_contactus
 * @license             http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('event/send_email.php');
global $CFG, $USER, $SITE;

$email = required_param('email', PARAM_EMAIL);
$name = required_param('name', PARAM_TEXT);
$subject = required_param('subject', PARAM_TEXT);
$message = required_param('message', PARAM_CLEANHTML);

$PAGE->set_context(context_system::instance());

$to = new stdClass();
$to->username = "admin";
$to->email = empty($CFG->senderemail) ? $CFG->supportemail : $CFG->senderemail;
$to->id = 1; //some id from nowhere
$to->firstname = $SITE->fullname;
$to->lastname = "";
$to->maildisplay = true;
$to->mailformat = 1;
$to->firstnamephonetic = "";
$to->lastnamephonetic = "";
$to->middlename = "";
$to->alternatename = "";

$messagetext = empty($USER->id) ?
    get_string('name', 'local_contactus') . " <b>{$name}</b>" :
    "<b>".get_string('name', 'local_contactus') . "</b> <a href='" . $CFG->wwwroot . "/user/view.php?id=" .
    $USER->id . "' target='_blank'>" . fullname($USER) . "</a>";
//email from user
$messagetext .= "<p><b>" . get_string('senderemail', 'local_contactus') . "</b> " . $email;
$messagetext .= "</p> <p><b>" . get_string('subject', 'local_contactus') . "</b> " . $subject;
$messagetext .= "</p><hr><p><b>" . get_string('message', 'local_contactus') . "</b><br>" . $message . "</p><hr>";

if (email_to_user($to, $email, "FALE CONOSCO ICMBio: {$subject}", "", $messagetext,
"", "", true, $email)) {
    $userid = empty($USER->id) ? -10 : $USER->id;
    $event = \local_contactus\event\send_email::create(array(
        'userid' => $userid,
        'context' => context_system::instance(),
        'relateduserid' => $to->id,
        'other' => array(
            'messageid' => 0,
            'subjecttext' => $subject,
            'messagetext' => $messagetext,
        )
    ));
    // Trigger and capturing the event.
    echo $event->trigger();

    // enableresponsemessage
    if ($CFG->enableresponsemessage) {
        $from = clone($to);
        $from->email = $email;
        $from->username = empty($USER->username) ? "guest" : $USER->username;
        $from->id = $userid;
        $from->firstname = strip_tags($name);
        $answer = $CFG->responsemessage;

        //send one e-mail for user with the success
        $messagetext2 = "{$answer}<br><br><blockquote>{$messagetext}</blockquote>";
        if (email_to_user($from, $to, "FALE CONOSCO ICMBio: {$subject}", "", $messagetext2, "", "",
            true)) {
            $event = \local_contactus\event\send_email::create(array(
                'userid' => $to->id,
                'context' => context_system::instance(),
                'relateduserid' => $userid,
                'other' => array(
                    'messageid' => 1,
                    'subjecttext' => $subject,
                    'messagetext' => $messagetext2,
                )
            ));
            // Trigger and capturing the event.
            echo $event->trigger();

        }
    }
} else {
    redirect($CFG->wwwroot . '/local/contactus/index.php', get_string('messagenotsent', 'local_contactus'), '', 'NOTIFY_ERROR');
}
redirect($CFG->wwwroot . '/local/contactus/index.php', get_string('responsemessage_default', 'local_contactus'));
