<?php

/**
 * Functions for component 'contactus'.
 *
 * @copyright           Trema Tech
 * @author              @rmady & @trevorfurtado
 * @package             local_contactus
 * @license             http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function mountSelect($name, $label, $no_option, $elements) {

    $select = HTML_QuickForm::createElement('select', $name, $label);
    $select->addOption($no_option, null, array('disabled' => 'disabled'));
    $selected = '';
    foreach ($elements as $name) {
        if (!empty($name)) {
            if (strpos($name, '*') === 0) {
                $name = trim(trim($name, '*'));
                $selected = $name;
            }
            $select->addOption($name, $name);
        }
    }
    $select->setSelected($selected);
    return $select;

}

function redirectIndex($setting) {

    if (!$setting) {
        $returnurl = new moodle_url('/index.php');
        redirect($returnurl);
    }

}
