<?php

/**
 * Handle everything related to the creation, display, and deletion of error notices in the admin UI for ChimpBridge.
 *
 * Based off of the ideas present in Daniel Grundel's work (https://github.com/dgrundel/wp-flash-messages) but extended to account for the current user's ID.
 */
class ChimpBridge_Error_Notices
{
    /**
     * Where the party starts.
     */
    public function __construct()
    {
        add_action('admin_notices', [$this, 'show_error_notices']);
    }

    /**
     * Display all errors associated with the current user using the template found in ChimpBridge's template directory, called `error_notice.php`. Following the display, remove the errors associated with the user.
     */
    public function show_error_notices()
    {
        $current_user_ID = get_current_user_id();

        $errors_for_user = $this->get_error_notices_by_ID($current_user_ID);

        if (!empty($errors_for_user)) {
            include CHIMPBRIDGE_DIR.'/templates/error_notice.php';
            $this->remove_error_notices_for_ID($current_user_ID);
        }
    }

    /**
     * Add an error to the database, placing it in the errors array indexed by the current user's ID.
     *
     * Note: The current user's ID is actually acting as a key, pointing to an array which contains all the errors associated with that user.
     *
     * @param string $error
     */
    public function add_error_notice($error)
    {
        if (defined('CHIMPBRIDGE_DEBUG') && CHIMPBRIDGE_DEBUG) {
            error_log(print_r(debug_backtrace(false), true));
        }

        $stored_errors = $this->get_error_notices();

        $updated_errors = $stored_errors;
        $updated_errors[get_current_user_id()][] = $error;

        $this->store_error_notices($updated_errors);
    }

    /**
     * Get all errors associated with a specific User ID.
     *
     * @param WP_User->ID $user_ID
     * @return array
     */
    public function get_error_notices_by_ID($user_ID)
    {
        $all_stored_errors = $this->get_error_notices();

        if (!empty($all_stored_errors)) {
            $stored_errors_for_ID = $all_stored_errors[$user_ID];
            $stored_errors_for_ID_without_duplicates = array_unique($stored_errors_for_ID);

            return $stored_errors_for_ID_without_duplicates;
        }
    }

    /**
     * Remove all the errors associated with a specific User ID.
     *
     * @param WP_User->ID $user_ID
     */
    public function remove_error_notices_for_ID($user_ID)
    {
        $all_stored_errors = $this->get_error_notices();

        $all_errors_without_errors_for_ID = $all_stored_errors;
        unset($all_errors_without_errors_for_ID[$user_ID]);

        $this->store_error_notices($all_errors_without_errors_for_ID);
    }

    /**
     * Retrieve all error notices stored in the WP Option 'chimpbridge_error_notices'.
     *
     * @return array
     */
    public function get_error_notices()
    {
        return get_option('chimpbridge_error_notices', []);
    }

    /**
     * Set the WP Option 'chimpbridge_error_notices' to whatever is passed to it.
     *
     * @param array $errors_to_store
     */
    public function store_error_notices($errors_to_store = [])
    {
        update_option('chimpbridge_error_notices', $errors_to_store);
    }
}
