<a name="wgobd-event"></a>
<table class="wgobd-full-event wgobd-single-event wgobd-event-id-<?php echo $event->post_id ?> <?php if( $event->allday ) echo 'wgobd-allday' ?>">
	<tbody>
		<tr>
			<th scope="row" class="wgobd-time"><?php _e( 'When:', wgobd_PLUGIN_NAME ) ?></th>
			<td colspan="2" class="wgobd-time">
				<a class="wgobd-button wgobd-calendar-link" href="<?php echo $calendar_url ?>">
					<?php _e( 'Back to Calendar »', wgobd_PLUGIN_NAME ) ?>
				</a>
				<?php echo $event->timespan_html ?>
			</td>
		</tr>
		<?php if( $recurrence ): ?>
			<tr>
				<th scope="row" class="wgobd-recurrence"><?php _e( 'Repeats:', wgobd_PLUGIN_NAME ) ?></th>
				<td class="wgobd-recurrence" colspan="2"><?php echo $recurrence ?></td>
			</tr>
		<?php endif ?>
		<?php if( $exclude ): ?>
			<tr>
				<th scope="row" class="wgobd-exclude"><?php _e( 'Excluding:', wgobd_PLUGIN_NAME ) ?></th>
				<td class="wgobd-exclude" colspan="2"><?php echo $exclude ?></td>
			</tr>
		<?php endif ?>
			<th scope="row" class="wgobd-location <?php if( ! $location ) echo 'wgobd-empty' ?>"><?php if( $location ) _e( 'Where:', wgobd_PLUGIN_NAME ) ?></th>
			<td class="wgobd-location <?php if( ! $location ) echo 'wgobd-empty' ?>"><?php echo $location ?></td>
			<td rowspan="5" class="wgobd-map <?php if( $map ) echo 'wgobd-has-map' ?>">
				<?php echo $map ?>
				<?php if( $show_subscribe_buttons ) : ?>
  				<a class="wgobd-button wgobd-subscribe"
  					href="<?php echo esc_attr( $subscribe_url ) ?>"
  					title="<?php _e( 'Add this event to your favourite calendar program (iCal, Outlook, etc.)', wgobd_PLUGIN_NAME ) ?>" />
  					<?php _e( '✔ Add to Calendar', wgobd_PLUGIN_NAME ) ?></a>
  				<a class="wgobd-button wgobd-subscribe-google" target="_blank"
  					href="<?php echo esc_attr( $google_url ) ?>"
  					title="<?php _e( 'Add this event to your Google Calendar', wgobd_PLUGIN_NAME ) ?>" />
  					<img src="<?php echo wgobd_IMAGE_URL ?>/google-calendar.png" />
  					<?php _e( 'Add to Google Calendar', wgobd_PLUGIN_NAME ) ?>
  				</a>
				<?php endif ?>
			</td>
		</tr>
		<tr>
			<?php if( $event->cost ): ?>
				<th scope="row" class="wgobd-cost"><?php _e( 'Cost:', wgobd_PLUGIN_NAME ) ?></th>
				<td class="wgobd-cost"><?php echo esc_html( $event->cost ) ?></td>
			<?php endif ?>
		</tr>
		<tr>
			<?php if( $contact ): ?>
				<th scope="row" class="wgobd-contact"><?php _e( 'Contact:', wgobd_PLUGIN_NAME ) ?></th>
				<td class="wgobd-contact"><?php echo $contact ?></td>
			<?php endif ?>
		</tr>
		<tr>
			<?php if( $categories ): ?>
				<th scope="row" class="wgobd-categories"><?php _e( 'Categories:', wgobd_PLUGIN_NAME ) ?></th>
				<td class="wgobd-categories"><?php echo $categories ?></td>
			<?php endif ?>
		</tr>
		<tr>
			<th scope="row" class="wgobd-tags">
				<?php if( $tags ): ?>
					<?php _e( 'Tags:', wgobd_PLUGIN_NAME ) ?>
				<?php endif ?>
			</th>
			<td class="wgobd-tags"><?php echo $tags ?></td>
		</tr>
	</tbody>
</table>
