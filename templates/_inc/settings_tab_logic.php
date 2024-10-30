<?php
// NB! This logic is in its own file so that it can be included by others when they need it.

/**
 * Here, we set the form values for the fields. Order of priority:
 *
 * 1. Assigned value from database
 * 2. Default value (informed by list)
 * 3. Default value (no list set, probably blank)
 */
// Set the values of the "From Name" and "From Email" fields, using either the database value or the default.
$chimpbridge_from_name_form_value = $this->get_meta_with_default($postID, '_chimpbridge_from_name');
$chimpbridge_from_email_form_value = $this->get_meta_with_default($postID, '_chimpbridge_from_email');

if (!isset($lists)) {
    $lists = [];
}

// Pull in defaults from selected list. Uses variables from `tab_recipients.php` to cut down on queries, be aware of naming changes.
if (isset($chimpbridge_selected_list) && true == $chimpbridge_selected_list) {
    foreach ((array) $lists as $list) {
        if ($list['id'] == $chimpbridge_selected_list) {
            // If there's a selected mailing list present and no value has been entered in the database yet (other than the default), set the name and email fields to the default provided by the list.
            if ('' == $chimpbridge_from_name_form_value) {
                $chimpbridge_from_name_form_value = $list['default_from_name'];
            }
            if ('' == $chimpbridge_from_email_form_value) {
                $chimpbridge_from_email_form_value = $list['default_from_email'];
            }
        }
    }
}

// Set the "To Name" value to either the database value or the "no list default" value.
$chimpbridge_to_name_form_value = $this->get_meta_with_default($postID, '_chimpbridge_to_name', '*|FNAME|*');
