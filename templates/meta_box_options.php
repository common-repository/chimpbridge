<?php
global $post;

$postID = $post->ID;

$content_raw = $post->post_content;
$content = apply_filters('the_content', $content_raw);

wp_nonce_field('chimpbridge', 'chimpbridge_nonce');
?>
<div class="chimpbridge-tabs">
	<div class="chimpbridge-tab active" rel="recipients"><?php _e('Select Recipients', 'chimpbridge'); ?></div>
	<div class="chimpbridge-tab" rel="settings"><?php esc_html_e('Settings', 'chimpbridge'); ?></div>
	<div class="chimpbridge-tab" rel="template"><?php esc_html_e('Template', 'chimpbridge'); ?></div>
	<div class="chimpbridge-tab" rel="code"><?php esc_html_e('View Raw Code', 'chimpbridge'); ?></div>
</div>

<div class="chimpbridge-tab-content chimpbridge-tab-content-recipients active">
	<?php include CHIMPBRIDGE_DIR.'/templates/tab_recipients.php'; ?>
</div>

<div class="chimpbridge-tab-content chimpbridge-tab-content-settings">
	<?php include CHIMPBRIDGE_DIR.'/templates/tab_settings.php'; ?>
</div>

<div class="chimpbridge-tab-content chimpbridge-tab-content-template">
	<?php include CHIMPBRIDGE_DIR.'/templates/tab_template.php'; ?>
</div>

<div class="chimpbridge-tab-content chimpbridge-tab-content-code">
	<?php include CHIMPBRIDGE_DIR.'/templates/tab_code.php'; ?>
</div>