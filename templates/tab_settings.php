<?php
include '_inc/settings_tab_logic.php';
?>
<table class="form-table">
	<tbody>
		<?php do_action('chimpbridge_settings_before'); ?>
		<tr>
			<th>
				<label for="chimpbridge-from-name"><?php esc_html_e('From Name', 'chimpbridge'); ?></label>
			</th>
			<td>
				<input type="text" class="large-text" id="chimpbridge-from-name" name="_chimpbridge_from_name" value="<?php echo esc_html($chimpbridge_from_name_form_value); ?>">
				<p class="description"><?php esc_html_e('The name your subscribers will see on your email.', 'chimpbridge'); ?></p>
			</td>
		</tr>
		<tr>
			<th>
				<label for="chimpbridge-from-email"><?php esc_html_e('From Email', 'chimpbridge'); ?></label>
			</th>
			<td>
				<input type="email" class="large-text" id="chimpbridge-from-email" name="_chimpbridge_from_email" value="<?php echo esc_html($chimpbridge_from_email_form_value); ?>">
				<p class="description"><?php esc_html_e('The email address your campaign will be sent from. This must be an email address verified for your Mailchimp account. The default is probably fine.', 'chimpbridge'); ?></p>
			</td>
		</tr>
		<tr>
			<th>
				<label for="chimpbridge-to-name"><?php esc_html_e('To Name', 'chimpbridge'); ?></label>
			</th>
			<td>
				<input type="text" class="large-text" id="chimpbridge-to-name" name="_chimpbridge_to_name" value="<?php echo esc_html($chimpbridge_to_name_form_value); ?>">
				<p class="description"><?php esc_html_e('How the "To" field will be addressed to subscribers. *|FNAME|* is a good default for this.', 'chimpbridge'); ?></p>
			</td>
		</tr>
		<?php if (!class_exists('ChimpBridgePro')): ?>
			<tr>
				<th>
					<label for="chimpbridge-footer"><?php _e('Footer', 'chimpbridge'); ?></label>
				</th>
				<td>
					<p><?php echo apply_filters('chimpbridge_msg_settings_help', sprintf(esc_html__('%sUpgrade to ChimpBridge Pro%s to customize the footer to match your brand.', 'chimpbridge'), '<a target="_blank" href="https://chimpbridge.com/upgrade?utm_source=plugin&utm_campaign=footer-help">', '</a>')); ?></p>
				</td>
			</tr>
		<?php endif; ?>
		<?php do_action('chimpbridge_settings_after'); ?>
	</tbody>
</table>
