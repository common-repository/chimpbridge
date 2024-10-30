<div class="error chimpbridge-error-notice">
	<p><?php _e('It appears something went wrong with ChimpBridge!', 'chimpbridge'); ?></p>
	<ul>
		<?php foreach ($errors_for_user as $error): ?>
			<li><?php echo wp_kses_data($error); ?></li>
		<?php endforeach; ?>
	</ul>
</div>