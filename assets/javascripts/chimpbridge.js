// insertAtCaret
// via http://stackoverflow.com/a/2819568
jQuery.fn.extend({
	insertAtCaret: function(myValue){
		return this.each(function(i) {
			if (document.selection) {
				//For browsers like Internet Explorer
				this.focus();
				var sel = document.selection.createRange();
				sel.text = myValue;
				this.focus();
			}
			else if (this.selectionStart || this.selectionStart == '0') {
				//For browsers like Firefox and Webkit based
				var startPos = this.selectionStart;
				var endPos = this.selectionEnd;
				var scrollTop = this.scrollTop;
				this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
				this.focus();
				this.selectionStart = startPos + myValue.length;
				this.selectionEnd = startPos + myValue.length;
				this.scrollTop = scrollTop;
			} else {
				this.value += myValue;
				this.focus();
			}
		});
	}
});

// Animate height to auto
// via http://css-tricks.com/snippets/jquery/animate-heightwidth-to-auto/
jQuery.fn.animateAuto = function(prop, speed, callback){
    var elem, height, width;
    return this.each(function(i, el){
        el = jQuery(el), elem = el.clone().css({"height":"auto","width":"auto"}).appendTo( el.parent() );
        height = elem.css("height"),
        width = elem.css("width"),
        elem.remove();

        if(prop === "height")
            el.animate({"height":height}, speed, callback);
        else if(prop === "width")
            el.animate({"width":width}, speed, callback);
        else if(prop === "both")
            el.animate({"width":width,"height":height}, speed, callback);
    });
}

function chimpbridge_verify_campaign_valid() {
    if ( jQuery('#chimpbridge-select-lists').find(':selected').text() == chimpbridge_general_localized_strings["Select Audience"] ) {
        alert( chimpbridge_general_localized_strings["Please select an audience."] );
        return false;
    }
    if ( jQuery('#chimpbridge-select-segments').find(':selected').text() == chimpbridge_general_localized_strings["Select Segment"] ) {
        alert( chimpbridge_general_localized_strings["Please select an audience segment (or choose to send this campaign to the entire audience)."] );
        return false;
    }
    if ( jQuery.trim( jQuery('#title').val() ) == '' ) {
        alert( chimpbridge_general_localized_strings["Enter Subject"] );
        return false;
    }
    return true;
}

jQuery(document).ready(function() {
    // Hide the revisions box
    jQuery('.misc-pub-revisions, .misc-pub-post-status').hide();

	jQuery('#title-prompt-text').text('Enter subject here');

	jQuery('#chimpbridge-code-textarea').focus( function() {
		var $this = jQuery(this);
		$this.select();

		// Work around Chrome's little problem
		$this.mouseup(function() {
			// Prevent further mouseup intervention
			$this.unbind("mouseup");
			return false;
		});
	});

	jQuery('#chimpbridge_reference dt > span').on( 'click', function() {
		var $insertme = jQuery(this).text();
		tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, $insertme );
		jQuery( '#wp-content-editor-container' ).find( 'textarea' ).insertAtCaret( $insertme );
	});

	jQuery(document).on('click', '.chimpbridge-tab', function() {
		var tab = jQuery(this).attr('rel');
		jQuery('.chimpbridge-tab').removeClass('active');
		jQuery('.chimpbridge-tab-content').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.chimpbridge-tab-content-' + tab).addClass('active');
	});

    jQuery('#save-post').click( function( event ) {
        if ( ! chimpbridge_verify_campaign_valid() ) {
            event.preventDefault();
        }
    });

	jQuery('#publish').click( function( event ) {
        if ( ! chimpbridge_verify_campaign_valid() ) {
            event.preventDefault();
            return;
        }

		if ( jQuery('#chimpbridge-verify-wrapper').hasClass('chimpbridge-hidden') ) {
			jQuery('#chimpbridge-verify-wrapper')
				.animateAuto('height', 300)
				.removeClass('chimpbridge-hidden');

			jQuery('#major-publishing-actions').addClass('chimpbridge-publishing-actions');

			jQuery('#post').attr('value', chimpbridge_general_localized_strings["Send Campaign"]);
			event.preventDefault();
		}
	});

	jQuery('body').addClass( 'chimpbridge-post-status-' + jQuery('#chimpbridge-post-status').data('chimpbridge-post-status') );

	// Set things to read-only once a campaign has been published
	if ( jQuery('body').hasClass('chimpbridge-post-status-publish') ) {
		// Disable the textarea
		jQuery('#title').prop('readonly', 'true');

		// Remove lots of stuff
		jQuery('input#publish').remove();
		jQuery('#wp-content-editor-tools').remove();
		jQuery('a.edit-post-status').remove();
	}
	
	jQuery('#chimpbridge-from-name').on( 'change', function( event ) {
	    var new_name_val = jQuery('#chimpbridge-from-name').val();
	    
	    jQuery('#chimpbridge-preview-email strong.chimpbridge-preview-meta-fromname').html(new_name_val);
	});
	
	jQuery('#chimpbridge-from-email').on( 'change', function( event ) {
	    var new_email_val = jQuery('#chimpbridge-from-email').val();
	    
	    jQuery('#chimpbridge-preview-email span.chimpbridge-preview-meta-fromemail span').html(new_email_val);
	});
});
