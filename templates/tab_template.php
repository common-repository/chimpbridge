<?php include '_inc/settings_tab_logic.php'; ?>

<table class="form-table">
	<tbody>
        <?php do_action('chimpbridge_template_before'); ?>
        
        <?php if (!class_exists('ChimpBridgePro')): ?>
        <tr>
            <th>
                <label for="chimpbridge-footer"><?php _e('Template', 'chimpbridge'); ?></label>
            </th>
            <td>
                <p><?php echo apply_filters('chimpbridge_msg_template_help', sprintf(esc_html__('%sUpgrade to ChimpBridge Pro%s to select or upload a custom template for your campaign.', 'chimpbridge'), '<a target="_blank" href="https://chimpbridge.com/upgrade?utm_source=plugin&utm_campaign=template-help">', '</a>')); ?></p>
            </td>
        </tr>
        <?php endif; ?>

        <?php do_action('chimpbridge_template_after'); ?>
	</tbody>
</table>
