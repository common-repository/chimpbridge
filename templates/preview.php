<?php
global $post;

$postID = $post->ID;

$content_raw = $post->post_content;
$the_content = apply_filters('the_content', $content_raw);
$the_title = $post->post_title;

if (empty($the_title)) {
    $the_title = '(no subject)';
}

include CHIMPBRIDGE_DIR.'/templates/_inc/settings_tab_logic.php';

?>

<div id="chimpbridge-preview-email">
	<h2 class="chimpbridge-preview-subject"><?php echo $the_title; ?></h2>
	<div class="chimpbridge-preview-meta">
		<img src="<?php echo CHIMPBRIDGE_URL; ?>/assets/images/mystery-avatar.png" alt="" class="avatar">
		<strong class="chimpbridge-preview-meta-fromname"><?php echo esc_html($chimpbridge_from_name_form_value); ?></strong> <span class="chimpbridge-preview-meta-fromemail">&lt;<span><?php echo esc_html($chimpbridge_from_email_form_value); ?></span>&gt;</span>
		<span class="chimpbridge-preview-meta-toname"><?php esc_html_e('to me', 'chimpbridge'); ?></span>
	</div>
	<div class="chimpbridge-preview-body">
		<?php echo $the_content; ?>
	</div>
</div>
