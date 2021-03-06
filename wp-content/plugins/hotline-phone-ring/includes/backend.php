<?php
/**
 * Admin Settings.
 */

$data = $this->data();
?>

<div class="wrap">

	<h2><?php esc_html_e( 'Hotline Phone Ring Settings', 'hotline-phone-ring' ); ?></h2>

	<?php $this->message(); ?>

	<form method="post" id="hpr-settings-form" action="<?php echo $this->form_action(); ?>">

		<hr>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Hotline', 'hotline-phone-ring' ); ?>
					</th>
					<td>
						<input id="hpr_phone" name="hpr_options[phone]" type="text" class="regular-text" value="<?php echo esc_attr( $data['phone'] ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Select style', 'hotline-phone-ring' ); ?>
					</th>
					<td>
						<label for="hpr_hotline_bar">
							<select id="hpr_hotline_bar" name="hpr_options[style]">
								<option value="style1" <?php selected( $data['style'], 'style1' ); ?>><?php esc_html_e( 'Style 1', 'hotline-phone-ring' ); ?></option>
								<option value="style2" <?php selected( $data['style'], 'style2' ); ?>><?php esc_html_e( 'Style 2', 'hotline-phone-ring' ); ?></option>
							</select>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Color', 'hotline-phone-ring' ); ?>
					</th>
					<td>
						<label for="hpr_color">
							<input id="hpr_color" name="hpr_options[color]" type="text" value="<?php echo esc_attr( $data['color'] ); ?>" class="hpr-color-picker" />
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Hide Hotline Bar', 'hotline-phone-ring' ); ?>
					</th>
					<td>
						<label for="hpr_hotline_bar">
							<input id="hpr_hotline_bar" name="hpr_options[hotline_bar]" type="checkbox" value="1"<?php echo $data['hotline_bar'] == 'on' ? ' checked="checked"' : '' ?> />
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Position', 'hotline-phone-ring' ); ?>
					</th>
					<td>
						<label for="hpr_hotline_bar">
							<select id="hpr_hotline_bar" name="hpr_options[position]">
								<option value="left" <?php selected( $data['position'], 'left' ); ?>><?php esc_html_e( 'Left', 'hotline-phone-ring' ); ?></option>
								<option value="right" <?php selected( $data['position'], 'right' ); ?>><?php esc_html_e( 'Right', 'hotline-phone-ring' ); ?></option>
							</select>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Space Vertical', 'hotline-phone-ring' ); ?>
					</th>
					<td>
						<input id="hpr_space_vertical" name="hpr_options[space_vertical]" type="text" class="regular-text" value="<?php echo esc_attr( $data['space_vertical'] ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Space Horizontal', 'hotline-phone-ring' ); ?>
					</th>
					<td>
						<input id="hpr_space_horizon" name="hpr_options[space_horizon]" type="text" class="regular-text" value="<?php echo esc_attr( $data['space_horizon'] ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>

		<?php submit_button(); ?>
		<?php wp_nonce_field( 'hpr-settings', 'hpr-settings-nonce' ); ?>

	</form>

	<hr />

	<h2><?php esc_html_e( 'Support', 'hotline-phone-ring' ); ?></h2>
	<p>
		<?php _e( 'For submitting any support queries, feedback, bug reports or feature requests, please visit <a href="https://namncn.com/lien-he/" target="_blank">this link</a>. Other great plugins by Nam Truong, please visit <a href="https://namncn.com/chuyen-muc/plugins/" target="_blank">this link</a>.', 'hotline-phone-ring' ); ?>
	</p>

</div>
