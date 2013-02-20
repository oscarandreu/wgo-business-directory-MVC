<h4 class="wgobd-section-title"><?php _e( 'Organizer contact info', wgobd_PLUGIN_NAME ); ?></h4>
<table class="wgobd-form">
	<tbody>
		<tr>
			<td class="wgobd-first">
				<label for="wgobd_contact_name">
					<?php _e( 'Contact name:', wgobd_PLUGIN_NAME ); ?>
				</label>
			</td>
			<td>
				<input type="text" name="wgobd_contact_name" id="wgobd_contact_name" value="<?php echo $contact_name; ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="wgobd_contact_phone">
					<?php _e( 'Phone:', wgobd_PLUGIN_NAME ); ?>
				</label>
			</td>
			<td>
				<input type="text" name="wgobd_contact_phone" id="wgobd_contact_phone" value="<?php echo $contact_phone; ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="wgobd_contact_email">
					<?php _e( 'E-mail:', wgobd_PLUGIN_NAME ); ?>
				</label>
			</td>
			<td>
				<input type="text" name="wgobd_contact_email" id="wgobd_contact_email" value="<?php echo $contact_email; ?>" />
			</td>
		</tr>
	</tbody>
</table>
