<table class="wgobd-event wgobd-multi-event wgobd-event-id-<?php echo $event->post_id ?> <?php if( $event->allday ) echo 'wgobd-allday' ?>">
	<tbody>
		<tr>
			<th scope="row" class="wgobd-time"><?php _e( 'When:', wgobd_PLUGIN_NAME ) ?></th>
			<td class="wgobd-time">
				<a class="wgobd-button wgobd-calendar-link" href="<?php echo $calendar_url ?>">
					<?php _e( 'View in Calendar »', wgobd_PLUGIN_NAME ) ?>
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
		<tr>
			<?php if( $location ): ?>
				<th scope="row" class="wgobd-location"><?php _e( 'Where:', wgobd_PLUGIN_NAME ) ?></th>
				<td class="wgobd-location">
					<?php if( $event->show_map ): ?>
						<a class="wgobd-button wgobd-gmap-link" href="<?php the_permalink() ?>#wgobd-event">
							<?php _e( 'View Map »', wgobd_PLUGIN_NAME ) ?>
						</a>
					<?php endif ?>
					<?php echo $location ?>
				</td>
			<?php endif ?>
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
			<?php if( $tags ): ?>
				<th scope="row" class="wgobd-tags"><?php _e( 'Tags:', wgobd_PLUGIN_NAME ) ?></th>
				<td class="wgobd-tags"><?php echo $tags ?></td>
			<?php endif ?>
		</tr>
	</tbody>
</table>
