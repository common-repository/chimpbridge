function set_refresh_rel( refreshButton, listID ) {
	refreshButton
		.prop( 'rel', listID );
}

function disable_select_field( selectField, message ) {
	message = message || chimpbridge_ajax_localized_strings["Loading..."];

	// Clear out the segment <select> field, disable it, and make it say "Loading"
	var option = jQuery( '<option />' );
	option.prop( 'disabled', true );
	option.prop( 'selected', true );
	option.attr( 'value', 'no-segments' );
	option.text( message );

	selectField
		.empty()
		.prop( 'readonly', true )
		.append( option );
}

function disable_refresh_button( refreshButton ) {
	// Disable the refresh button
	refreshButton
		.addClass('disabled');
}

function add_select_options( selectField, response ) {
	// Loop through the response array
	jQuery.each( response.data, function( index, value ) {
		// And add an <option> for each list
		var option = jQuery( '<option />' );
		option.attr( 'value', value.id );
		option.text( value.name );
		selectField
			.append( option );
	});
}

/**
 * Iterates over each mailing list option and grabs its default from name and email, adding them to a big unorganized array.
 * 
 * @returns {build_default_name_email_array.default_names_and_emails}
 */
function build_default_name_email_array() {
    var default_names_and_emails = { "name": [ ], "email": [ ] };

    jQuery( '#chimpbridge-select-lists' )
	.children( 'option' )
	.each( function( ) {
	    var list_id = jQuery( this ).val();

	    if ( chimpbridge_ajax_localized_strings["Select Audience"] === list_id ) {
		return true;
	    }

	    var list_default_from_name = jQuery( this ).data( 'defaultFromName' );
	    var list_default_from_email = jQuery( this ).data( 'defaultFromEmail' );

	    default_names_and_emails.name.push( list_default_from_name );
	    default_names_and_emails.email.push( list_default_from_email );
	} );

    return default_names_and_emails;
}

/**
 * Iterates over each mailing list option and grabs its default from name and email, adding it to an object indexed by the list ID and returning it.
 * 
 * @returns {Array}
 */
function build_default_name_email_array_by_ID() {
    var default_names_and_emails_by_ID = [ ];

    jQuery( '#chimpbridge-select-lists' )
	.children( 'option' )
	.each( function( ) {
	    var list_id = jQuery( this ).val();

	    if ( chimpbridge_ajax_localized_strings["Select Audience"] === list_id ) {
		return true;
	    }

	    var list_default_from_name = jQuery( this ).data( 'defaultFromName' );
	    var list_default_from_email = jQuery( this ).data( 'defaultFromEmail' );

	    default_names_and_emails_by_ID[list_id] = {
		"default_from_name": list_default_from_name,
		"default_from_email": list_default_from_email
	    };
	} );

    return default_names_and_emails_by_ID;
}

/**
 * Wrapper function which farms out the setting of the defaults to a generic child function.
 * 
 * @param string list_ID
 * @param object default_from_names_emails
 * @param array default_from_names_emails_by_ID
 * @returns none
 */
function set_default_from_name_email( list_ID, default_from_names_emails, default_from_names_emails_by_ID ) {
    // Name
    set_default_from_generic( list_ID, default_from_names_emails, default_from_names_emails_by_ID, 'name' );

    // Email
    set_default_from_generic( list_ID, default_from_names_emails, default_from_names_emails_by_ID, 'email' );
}

function set_default_from_generic( list_ID, default_from_names_emails, default_from_names_emails_by_ID, identifier ) {
    var field = jQuery( '#chimpbridge-from-' + identifier );
    var current_value_of_field = field.val();

    if ( '' === current_value_of_field || -1 !== jQuery.inArray( current_value_of_field, default_from_names_emails[identifier] ) ) {
	// If the current value of the field is nothing, let's fill it with the default from the list! Or, if the current value of the field is from within the defaults, it's safe to assume that we can overwrite it with a new default!
	field.val( default_from_names_emails_by_ID[list_ID]['default_from_' + identifier] );
	field.trigger( 'change' );

	return;
    } else {
	// The user has probably set a custom value here. Overwriting would be bad.
	return;
    }
}

/**
 * populate_select
 */
function populate_select( selectField, refreshButton, action, listID ) {
	// Build the AJAX call data
	var data = {
		'action': action,
		'nonce':  chimpbridgeAjax.nonce
	}

	if ( listID ) {
		var merge_me = {
			'listID': listID
		}

		data = jQuery.extend( data, merge_me );
	}

	// Make the AJAX call
	jQuery.post( chimpbridgeAjax.url, data, function( response ) {
		response = JSON.parse( response );

		if ( response.success ) {
			// If successful, add list <select> options and enable it
			selectField
				.empty()
				.append( '<option disabled selected>' + chimpbridge_ajax_localized_strings["Select " + ( listID ? "Segment" : "Audience" )] + '</option>' )
				.prop( 'disabled', false );

			if ( listID ) {
				selectField
					.append( '<option value="send-to-all">' + chimpbridge_ajax_localized_strings["Send to Entire Audience"] + '</option>' );
			}

			add_select_options( selectField, response );
		} else {
			// If there's an error, disable the <select> and add an error message
			disable_select_field( selectField, response.data );
		}

		// Enable the segment refresh button
		refreshButton
			.removeClass('disabled');
	}, 'text');
}

function update_segment_and_list_confirmation_message() {
    var segmentName = jQuery('#chimpbridge-select-segments').find(':selected').text();
    var listName = jQuery('#chimpbridge-select-lists').find(':selected').text();

    jQuery('#chimpbridge-verify-list').text( listName );

    jQuery('#chimpbridge-verify-segment').html( '' );

    if ( segmentName == chimpbridge_ajax_localized_strings["Send to Entire Audience"] ) {
        jQuery('#chimpbridge-verify-segment').html( 'entire' );
        return;
    }

    if ( segmentName != chimpbridge_ajax_localized_strings["Loading..."] &&  segmentName != chimpbridge_ajax_localized_strings["No Audience Selected"] && segmentName != chimpbridge_ajax_localized_strings["Select Segment"] && segmentName != chimpbridge_ajax_localized_strings["This audience has no segments"] ) {
        jQuery('#chimpbridge-verify-segment').html( '<strong>' + segmentName + '</strong> ' + chimpbridge_ajax_localized_strings["segment of the"] );
    }
}

jQuery(document).ready(function() {
    /**
     * TEST EMAIL
     */
    jQuery('#chimpbridge_email_test_submit').on( 'click', function( event ) {
        if ( ! jQuery('#chimpbridge_test_emails').val() ) {
            event.preventDefault();
            alert( chimpbridge_general_localized_strings["Enter Test Emails"] );
            return;
        }
        jQuery('#chimpbridge_email_send').val( 'yes' );
        jQuery('#save-post').trigger( 'click' );
    });


	/**
	 *
	 * LISTS
	 *
	 */

	// Whenever the select list changes:
	jQuery('#chimpbridge-select-lists').on( 'change', function( event ) {
		// Build array of default "from" names and emails from options in list select box.
		var default_from_names_emails = build_default_name_email_array();
		var default_from_names_emails_by_ID = build_default_name_email_array_by_ID();
		var listID   = this.value;

		set_default_from_name_email( listID, default_from_names_emails, default_from_names_emails_by_ID );

        update_segment_and_list_confirmation_message();

		// Disable the select block
		disable_select_field( jQuery( '#chimpbridge-select-segments' ) );
		disable_refresh_button( jQuery( '#chimpbridge-refresh-segments' ) );

		// Set the rel on the refresh button
		set_refresh_rel( jQuery( '#chimpbridge-refresh-segments' ), listID );

		// Populate the segments field
		//populate_segments( listID );
		populate_select(
			jQuery('#chimpbridge-select-segments'),
			jQuery('#chimpbridge-refresh-segments'),
			'get_mailchimp_segments',
			listID
		);
	});

	/**
	 * List Refresh Button
	 */
	jQuery('#chimpbridge-refresh-lists').on( 'click', function( event ) {
		// Don't let the link do linky things
		event.preventDefault();

		if ( jQuery('#chimpbridge-refresh-lists').hasClass('disabled') ) {
			// If the refresh button is disabled, do nothing.
		} else {
			// If the refresh button is not disabled:

			// Build the AJAX call
			var data = {
				'action': 'refresh_mailchimp_lists',
				'nonce':  chimpbridgeAjax.nonce
			};

			// Make the AJAX call
			jQuery.post( chimpbridgeAjax.url, data, function( response ) {
				if ( response.success ) {
					// Disable the select blocks
					disable_select_field( jQuery('#chimpbridge-select-lists') );
					disable_refresh_button( jQuery('#chimpbridge-refresh-lists') );

					disable_select_field( jQuery('#chimpbridge-select-segments'), chimpbridge_ajax_localized_strings["No Audience Selected"] );
					disable_refresh_button( jQuery('#chimpbridge-refresh-segments') );

					// If successful, populate the segment <select> field
					populate_select(
						jQuery('#chimpbridge-select-lists'),
						jQuery('#chimpbridge-refresh-lists'),
						'get_mailchimp_lists'
					);
				} else {
					// Something went wrong.
				}
			});

		}
	});


	/**
	 *
	 * SEGMENTS
	 *
	 */

	/**
	 * Segment Refresh Button
	 */
	jQuery('#chimpbridge-refresh-segments').on( 'click', function( event ) {
		// Don't let the link do linky things
		event.preventDefault();

		if ( jQuery('#chimpbridge-refresh-segments').hasClass('disabled') ) {
			// If the refresh button is disabled, do nothing.
		} else {
			// If the refresh button is not disabled:

			// Grab the list ID
			var listID = jQuery('#chimpbridge-select-lists').find(':selected').val();

			// Build the AJAX call
			var data = {
				'action': 'refresh_mailchimp_segments',
				'nonce':  chimpbridgeAjax.nonce,
				'listID': listID
			};

			// Disable the select block
			disable_select_field( jQuery( '#chimpbridge-select-segments' ) );
			disable_refresh_button( jQuery( '#chimpbridge-refresh-segments' ) );

			// Make the AJAX call
			jQuery.post( chimpbridgeAjax.url, data, function( response ) {
				if ( response.success ) {
					// If successful, populate the segment <select> field
					//populate_segments( listID );
					populate_select(
						jQuery('#chimpbridge-select-segments'),
						jQuery('#chimpbridge-refresh-segments'),
						'get_mailchimp_segments',
						listID
					);
				} else {
					// Something went wrong.
				}
			});

		}
	});

	// Whenever the select segment list changes:
	jQuery('#chimpbridge-select-segments').on( 'change', function( event ) {
        update_segment_and_list_confirmation_message();
	});

    // update the message on initial load
    update_segment_and_list_confirmation_message();
});
