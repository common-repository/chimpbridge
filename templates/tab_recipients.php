<?php global $post; ?>
<table class="form-table">
	<tbody>
		<tr id="chimpbridge-row-list">
			<th>
				<label for="chimpbridge-select-lists"><?php echo esc_html__('Select Audience', 'chimpbridge'); ?></label>
			</th>
			<td>
				<?php $chimpbridge_selected_list = get_post_meta(intval($postID), '_chimpbridge_select_lists', true); ?>
				<?php if ('publish' == get_post_status()): ?>
					<?php echo esc_html($chimpbridge_selected_list); ?>
				<?php else: ?>
					<select id="chimpbridge-select-lists" name="_chimpbridge_select_lists">
						<option disabled selected><?php _e('Select Audience', 'chimpbridge'); ?></option>
						<?php
                        $lists = $this->get_mailchimp_lists();

                        foreach ($lists as $list) {
                            $selected = null;
                            if ($list['id'] == $chimpbridge_selected_list) {
                                $selected = ' selected';
                            }

                            echo '<option data-default-from-name="'.esc_attr($list['default_from_name']).'" data-default-from-email="'.esc_attr($list['default_from_email']).'" value="'.esc_attr($list['id']).'"'.$selected.'>'.esc_html($list['name']).'</option>';
                        }
                        ?>
					</select>
					<a class="button chimpbridge-refresh" id="chimpbridge-refresh-lists" href="#" title="<?php _e('Lists are updated every 24 hours. Click to force refresh.', 'chimpbridge'); ?>"><div class="dashicons dashicons-update"></div></a>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="input-text"><?php echo esc_html__('Select Segment', 'chimpbridge'); ?></label>
			</th>
			<td>
				<?php $chimpbridge_selected_segment = get_post_meta(intval($postID), '_chimpbridge_select_segments', true); ?>
				<?php if ('publish' == get_post_status()): ?>
					<?php echo esc_html($chimpbridge_selected_segment); ?>
				<?php else: ?>
					<select id="chimpbridge-select-segments" name="_chimpbridge_select_segments">
						<?php
                        if (empty($chimpbridge_selected_list)) {
                            echo '<option selected disabled>'.esc_html__('No Audience Selected', 'chimpbridge').'</option>';
                        } else {
                            $segments = $this->get_mailchimp_segments($chimpbridge_selected_list);
                            if (empty($segments)) {
                                // no segments
                                echo '<option readonly value="no-segments">'.apply_filters('chimpbridge_msg_no_segments', __('Segments not available', 'chimpbridge')).'</option>';
                            } else {
                                // has segments
                                echo '<option readonly disabled>'.esc_html__('Select a segment', 'chimpbridge').'</option>';

                                if ($chimpbridge_selected_segment == 'send-to-all') {
                                    $selected = 'selected';
                                }

                                echo '<option value="send-to-all" '.$selected.'>'.esc_html__('Send to Entire Audience', 'chimpbridge').'</option>';
                            }
                        }
                        if ($chimpbridge_selected_segment && $chimpbridge_selected_list) {
                            foreach ($segments as $segment) {
                                $selected = null;
                                if ($segment['id'] == $chimpbridge_selected_segment) {
                                    $selected = ' selected';
                                }

                                echo '<option value="'.esc_attr($segment['id']).'"'.$selected.'>'.esc_html($segment['name']).'</option>';
                            }
                        }
                        ?>
					</select>
				<?php endif; ?>

				<?php if (get_post_status() != 'publish') : ?>
					<?php if ($chimpbridge_selected_list) : ?>
						<a class="button chimpbridge-refresh" id="chimpbridge-refresh-segments" href="#" title="<?php _e('Segments are updated every 24 hours. Click to force refresh.', 'chimpbridge'); ?>"><div class="dashicons dashicons-update"></div></a>
					<?php else : ?>
						<a class="button disabled chimpbridge-refresh" id="chimpbridge-refresh-segments" href="#" title="<?php _e('Segments are updated every 24 hours. Click to force refresh.', 'chimpbridge'); ?>"><div class="dashicons dashicons-update"></div></a>
					<?php endif; ?>
				<?php endif; ?>

                <?php if (!class_exists('ChimpBridgePro')) : ?>
                <p class="description"><?php echo apply_filters('chimpbridge_msg_recipients_help', sprintf(esc_html__('%sUpgrade to ChimpBridge Pro%s to send to specific segments of your audience.', 'chimpbridge'), '<a target="_blank" href="https://chimpbridge.com/upgrade?utm_source=plugin&utm_campaign=segments-help">', '</a>')); ?></p>
                <?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>
