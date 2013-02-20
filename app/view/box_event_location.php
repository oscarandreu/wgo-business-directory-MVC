<h4 class="wgobd-section-title"><?php _e( 'Event location details', wgobd_PLUGIN_NAME ); ?></h4>
<table class="wgobd-form wgobd-location-form">
	<tbody>
		<tr>
			<td class="wgobd-first">
				<label for="wgobd_venue">
					<?php _e( 'Venue name:', wgobd_PLUGIN_NAME ); ?>
				</label>
			</td>
			<td>
				<input type="text" name="wgobd_venue" id="wgobd_venue" value="<?php echo $venue; ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="wgobd_address">
					<?php _e( 'Address:', wgobd_PLUGIN_NAME ); ?>
				</label>
			</td>
			<td>
				<input type="text" name="wgobd_address" id="wgobd_address" value="<?php echo $address; ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="wgobd_google_map">
					<?php _e( 'Show Google Map:', wgobd_PLUGIN_NAME ); ?>
				</label>
			</td>
			<td>
				<input type="checkbox" value="1" name="wgobd_google_map" id="wgobd_google_map" <?php echo $google_map; ?> />
			</td>
		</tr>
	</tbody>
</table>
<div class="wgobd_box_map <?php if( $show_map ) echo 'wgobd_box_map_visible' ?>">
	<div id="wgobd_map_canvas"></div>
</div>
<input type="hidden" name="wgobd_city" 				id="wgobd_city" 				value="<?php echo $city; ?>" />
<input type="hidden" name="wgobd_province" 		id="wgobd_province" 		value="<?php echo $province; ?>" />
<input type="hidden" name="wgobd_postal_code" id="wgobd_postal_code"	value="<?php echo $postal_code; ?>" />
<input type="hidden" name="wgobd_country" 		id="wgobd_country" 			value="<?php echo $country; ?>" />
