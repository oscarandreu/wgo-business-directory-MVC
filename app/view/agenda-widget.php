<?php echo $args['before_widget'] ?>

<?php if( $title ): ?>
	<?php echo $before_title . $title . $after_title ?>
<?php endif ?>

<div class="wgobd-agenda-widget-view">

	<?php if( ! $dates ): ?>
		<p class="wgobd-no-results">
			<?php _e( 'There are no upcoming events.', wgobd_PLUGIN_NAME ) ?>
		</p>
	<?php else: ?>
		<ol>
			<?php foreach( $dates as $timestamp => $date_info ): ?>
				<li class="wgobd-date <?php if( isset( $date_info['today'] ) && $date_info['today'] ) echo 'wgobd-today' ?>">
					<h3 class="wgobd-date-title">
						<div class="wgobd-month"><?php echo date_i18n( 'M', $timestamp, true ) ?></div>
						<div class="wgobd-day"><?php echo date_i18n( 'j', $timestamp, true ) ?></div>
						<div class="wgobd-weekday"><?php echo date_i18n( 'D', $timestamp, true ) ?></div>
					</h3>
					<ol class="wgobd-date-events">
						<?php foreach( $date_info['events'] as $category ): ?>
							<?php foreach( $category as $event ): ?>
								<li class="wgobd-event
									wgobd-event-id-<?php echo $event->post_id ?>
									wgobd-event-instance-id-<?php echo $event->instance_id ?>
									<?php if( $event->allday ) echo 'wgobd-allday' ?>">

									<?php // Insert post ID for use by JavaScript filtering later ?>
									<input type="hidden" class="wgobd-post-id" value="<?php echo $event->post_id ?>" />

									<a href="<?php echo esc_attr( get_permalink( $event->post_id ) ) . $event->instance_id ?>">
										<?php if( $event->category_colors ): ?>
											<span class="wgobd-category-colors"><?php echo $event->category_colors ?></span>
										<?php endif ?>
										<?php if( ! $event->allday ): ?>
											<span class="wgobd-event-time">
												<?php echo esc_html( $event->start_time ) ?></span>
											</span>
										<?php endif ?>
										<span class="wgobd-event-title">
											<?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?>
										</span>
									</a>

								</li>
							<?php endforeach ?>
						<?php endforeach ?>
					</ol>
				</li>
			<?php endforeach ?>
		</ol>
	<?php endif ?>


	<?php if( $show_calendar_button ): ?>
		<a class="wgobd-button wgobd-calendar-link" href="<?php echo $calendar_url ?>">
			<?php _e( 'View Calendar »', wgobd_PLUGIN_NAME ) ?>
		</a>
	<?php endif ?>

	<?php if( $show_subscribe_buttons ): ?>
		<div class="wgobd-subscribe-buttons">
			<a class="wgobd-button wgobd-subscribe"
				href="<?php echo $subscribe_url ?>"
				title="<?php _e( 'Subscribe to this calendar using your favourite calendar program (iCal, Outlook, etc.)', wgobd_PLUGIN_NAME ) ?>" />
				<?php _e( '✔ Subscribe', wgobd_PLUGIN_NAME ) ?>
			</a>
			<a class="wgobd-button wgobd-subscribe-google" target="_blank"
				href="http://www.google.com/calendar/render?cid=<?php echo urlencode( str_replace( 'webcal://', 'http://', $subscribe_url ) ) ?>"
				title="<?php _e( 'Subscribe to this calendar in your Google Calendar', wgobd_PLUGIN_NAME ) ?>" />
				<img src="<?php echo wgobd_IMAGE_URL ?>/google-calendar.png" />
				<?php _e( 'Add to Google', wgobd_PLUGIN_NAME ) ?>
			</a>
		</div>
	<?php endif ?>

</div>

<?php echo $args['after_widget'] ?>
