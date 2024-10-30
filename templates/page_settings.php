<div class="wrap chimpbridge">
	<div class="leftcol">
	    <h2><?php esc_html_e('ChimpBridge Settings', 'chimpbridge'); ?></h2>

		<?php if (isset($_GET['settings-updated'])) : ?>
			<div id="message" class="updated">
				<p><strong><?php esc_html_e('Settings saved.', 'chimpbridge') ?></strong></p>
			</div>
		<?php endif; ?>

		<form action="options.php" method="POST">
			<?php settings_fields('chimpbridge_settings_fields'); ?>

			<?php do_settings_sections('chimpbridge-settings'); ?>

			<?php submit_button(); ?>
		</form>
	</div>

	<?php if (!class_exists('ChimpBridgePro')): ?>
    <div class="rightcol">
		<div class="chimpbridge-cta">
			<h3><?php esc_html_e('ChimpBridge Pro', 'chimpbridge'); ?></h3>

            <p>
			<?php esc_html_e('ChimpBridge Pro has features that will make your Mailchimp email marketing efforts even better.', 'chimpbridge'); ?>
            </p>

            <ul>
                <li><?php esc_html_e('Take advantage of audience segments.', 'chimpbridge'); ?></li>
                <li><?php esc_html_e('Customize the footer of your emails.', 'chimpbridge'); ?></li>
                <li><a href="https://chimpbridge.com/support/how-to-add-a-custom-email-template-to-chimpbridge-pro/?utm_campaign=cta-rightcol-top&utm_source=plugin" target="_blank"><?php esc_html_e('Use templates to give your emails a new look.', 'chimpbridge'); ?></a></li>
                <li><a href="https://chimpbridge.com/support/how-to-create-a-wordpress-newsletter-archive-with-chimpbridge-pro/?utm_campaign=cta-rightcol-top&utm_source=plugin" target="_blank"><?php esc_html_e('Create a newsletter archive on your site.', 'chimpbridge'); ?></a></li>
            </ul>

            <a class="chimpbridge-button" href="https://chimpbridge.com/upgrade/?utm_campaign=cta-rightcol-top&utm_source=plugin" target="_blank"><?php esc_html_e('Upgrade', 'chimpbrige'); ?></a>
		</div>
	</div>
    <?php endif; ?>
</div>
