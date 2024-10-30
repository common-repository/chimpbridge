<p><?php esc_html_e('Send a test email by putting an email address in the box below and pressing "Send Test". You can send to multiple recipients by entering a comma-separated list of emails.', 'chimpbridge'); ?></p>
<input id="chimpbridge_test_emails" name="chimpbridge_test_emails" type="text">
<input type="hidden" id="chimpbridge_email_send" name="chimpbridge_email_send" value="">
<a id="chimpbridge_email_test_submit" class="button button-primary" href="javascript:;"><?php esc_html_e('Send Test', 'chimpbridge'); ?></a>

<div class="clear"></div>