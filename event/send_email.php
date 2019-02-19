<?php

/**
 * The send_email created event for component 'contactus'.
 *
 * @copyright           Trema Tech
 * @author              @rmady & @trevorfurtado
 * @package             local_contactus
 * @license             http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_contactus\event;
defined('MOODLE_INTERNAL') || die();

/**
 * The send_email created event class.
 *
 *
 * @package local_contactus\event
 */
class send_email extends \core\event\base {
    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventmailsent', 'local_contactus');
    }

    /**
     * Returns relevant URL.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/local/contactus/index.php');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        // Check if we are sending from a valid user.
        if (\core_user::is_real_user($this->userid)) {
            return "The user with id '$this->userid' sent a e-mail by the contactus.";
        }
        return "A message was sent by one external user.";
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['messageid'])) {
            throw new \coding_exception('The \'messageid\' value must be set in other.');
        }
    }
}