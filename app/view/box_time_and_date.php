<?php wp_nonce_field( 'wgobd', wgobd_POST_TYPE ); ?>
<h4 class="wgobd-section-title"><?php _e( 'Event date and time', wgobd_PLUGIN_NAME ); ?></h4>
<table class="wgobd-form">
	<tbody>
		<tr>
			<td class="wgobd-first">
				<label for="wgobd_all_day_event">
					<?php _e( 'All-day event', wgobd_PLUGIN_NAME ); ?>?
				</label>
			</td>
			<td>
				<input type="checkbox" name="wgobd_all_day_event" id="wgobd_all_day_event" value="1" <?php echo $all_day_event; ?> />
			</td>
		</tr>
		<tr>
			<td>
				<label for="wgobd_start-date-input">
					<?php _e( 'Start date / time', wgobd_PLUGIN_NAME ); ?>:
				</label>
			</td>
			<td>
				<input type="text" class="wgobd-date-input" id="wgobd_start-date-input" />
				<input type="text" class="wgobd-time-input" id="wgobd_start-time-input" />
				<small><?php echo $timezone ?></small>
				<input type="hidden" name="wgobd_start_time" id="wgobd_start-time" value="<?php echo $start_timestamp ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="wgobd_end-date-input">
					<?php _e( 'End date / time', wgobd_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<input type="text" class="wgobd-date-input" id="wgobd_end-date-input" />
				<input type="text" class="wgobd-time-input" id="wgobd_end-time-input" />
				<small><?php echo $timezone ?></small>
				<input type="hidden" name="wgobd_end_time" id="wgobd_end-time" value="<?php echo $end_timestamp ?>" />
			</td>
		</tr>
		<tr>
			<td>
			  <input type="checkbox" name="wgobd_repeat" id="wgobd_repeat" value="1" <?php echo $repeating_event ? 'checked="checked"' : '' ?>/>
			  <input type="hidden" name="wgobd_rrule" id="wgobd_rrule" value="<?php echo $rrule ?>" />
				<label for="wgobd_repeat" id="wgobd_repeat_label">
					<?php _e( 'Repeat', wgobd_PLUGIN_NAME ); echo $repeating_event ? ':' : '...' ?>
				</label>
			</td>
			<td>
			  <div id="wgobd_repeat_text">
			    <a href="#wgobd_repeat_box"><?php echo $rrule_text ?></a>
			  </div>
			</td>
		</tr>
		<tr>
			<td>
			  <input type="checkbox" name="wgobd_exclude" id="wgobd_exclude" value="1" <?php echo $exclude_event ? 'checked="checked"' : '' ?>/>
			  <input type="hidden" name="wgobd_exrule" id="wgobd_exrule" value="<?php echo $exrule ?>" />
				<label for="wgobd_exclude" id="wgobd_exclude_label">
					<?php _e( 'Exclude', wgobd_PLUGIN_NAME ); echo $exclude_event ? ':' : '...' ?>
				</label>
			</td>
			<td>
			  <div id="wgobd_exclude_text">
			    <a href="#wgobd_exclude_box"><?php echo $exrule_text ?></a>
			  </div>
				<span class="wgobd-info-text">(<?php _e( 'Choose a rule for exclusion', wgobd_PLUGIN_NAME ) ?>)</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="wgobd_exdate_calendar_icon" id="wgobd_exclude_date_label">
					<?php _e( 'Exclude dates', wgobd_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<div id="datepicker-widget">
					<div id="widgetField">
						<span></span>
						<a href="#"><?php _e( 'Select date range', wgobd_PLUGIN_NAME ) ?></a>
					</div>
					<div id="widgetCalendar"></div>
				</div>
				<input type="hidden" name="wgobd_exdate" id="wgobd_exdate" value="<?php echo $exdate ?>" />
				<span class="wgobd-info-text">(<?php _e( 'Choose specific dates to exclude', wgobd_PLUGIN_NAME ) ?>)</span>
			</td>
		</tr>
		<div id="wgobd_repeat_box"></div>
	</tbody>
</table>
