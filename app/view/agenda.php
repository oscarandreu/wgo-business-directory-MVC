<h2 class="wgobd-calendar-title"><?php echo esc_html( $title ) ?></h2>
<span class="wgobd-title-buttons">
	<?php if( $dates ): ?>
		<a id="wgobd-expand-all" class="wgobd-button">
			<?php _e( '+ Expand All', wgobd_PLUGIN_NAME ) ?>
		</a><a
		id="wgobd-collapse-all" class="wgobd-button">
			<?php _e( '− Collapse All', wgobd_PLUGIN_NAME ) ?>
		</a
	><?php endif ?><a
		id="wgobd-today" class="wgobd-load-view wgobd-button" href="#action=wgobd_agenda&amp;wgobd_post_ids=<?php echo $post_ids ?>">
		<?php _e( 'Today', wgobd_PLUGIN_NAME ) ?>
	</a>
</span>
<ul class="wgobd-pagination">
	<?php foreach( $pagination_links as $link ): ?>
		<li>
			<a id="<?php echo $link['id'] ?>"
				class="wgobd-load-view wgobd-button"
				href="<?php echo esc_attr( $link['href'] ) ?>&amp;wgobd_post_ids=<?php echo $post_ids ?>">
				<?php echo esc_html( $link['text'] ) ?>
			</a>
		</li>
	<?php endforeach ?>
</ul>
<ol class="wgobd-agenda-view">
	<?php if( ! $dates ): ?>
		<p class="wgobd-no-results">
			<?php _e( 'There are no upcoming events to display at this time.', wgobd_PLUGIN_NAME ) ?>
		</p>
	<?php else: ?>
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
								<?php if( $event->allday ) echo 'wgobd-allday' ?>
								<?php if( $event->post_id == $active_event ) echo 'wgobd-active-event' ?>
								<?php if( $expanded ) echo 'wgobd-expanded' ?>">

								<?php // Insert post ID for use by JavaScript filtering later ?>
								<input type="hidden" class="wgobd-post-id" value="<?php echo $event->post_id ?>" />

								<?php // Hidden summary, until clicked ?>
								<div class="wgobd-event-summary"<?php if( $expanded ) echo ' style="display: block;"' ?>>
									<div class="wgobd-event-click">
										<div class="wgobd-event-expand">−</div>
										<div class="wgobd-event-title">
											<?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?>
											<?php if( $event->allday ): ?>
												<span class="wgobd-allday-label"><?php _e( '(all-day)', wgobd_PLUGIN_NAME ) ?></span>
											<?php endif ?>
										</div>
										<div class="wgobd-event-time">
											<?php if( $event->allday ): ?>
												<?php echo esc_html( $event->short_start_date ) ?>
												<?php if( $event->short_end_date != $event->short_start_date ): ?>
													– <?php echo esc_html( $event->short_end_date ) ?>
												<?php endif ?>
											<?php else: ?>
												<?php echo esc_html( $event->start_time . ' – ' . $event->end_time ) ?></span>
											<?php endif ?>
										</div>
									</div>
									<div class="wgobd-event-description">
										<div class="wgobd-event-overlay">
											<a class="wgobd-read-more wgobd-button"
												href="<?php echo esc_attr( get_permalink( $event->post_id ) . $event->instance_id ) ?>">
												<?php _e( 'Read more »', wgobd_PLUGIN_NAME ) ?>
											</a>
											<?php if( $event->categories_html ): ?>
												<div class="wgobd-categories">
													<label class="wgobd-label"><?php _e( 'Categories:', wgobd_PLUGIN_NAME ) ?></label>
													<?php echo $event->categories_html ?>
												</div>
											<?php endif ?>
											<?php if( $event->tags_html ): ?>
												<div class="wgobd-tags">
													<label class="wgobd-label"><?php _e( 'Tags:', wgobd_PLUGIN_NAME ) ?></label>
													<?php echo $event->tags_html ?>
												</div>
											<?php endif ?>
										</div>
										<?php echo apply_filters( 'the_content', $event->post->post_content ) ?>
									</div>
								</div>

								<div class="wgobd-event-click"<?php echo $expanded ? ' style="display: none;"' : ''?>>
									<?php if( $event->category_colors ): ?>
										<div class="wgobd-category-colors"><?php echo $event->category_colors ?></div>
									<?php endif ?>
									<div class="wgobd-event-expand">+</div>
									<?php if( ! $event->allday ): ?>
										<div class="wgobd-event-time">
											<?php echo esc_html( $event->start_time ) ?></span>
										</div>
									<?php endif ?>
									<div class="wgobd-event-title">
										<?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?>
										<?php if( $event->allday ): ?>
											<span class="wgobd-allday-label"><?php _e( '(all-day)', wgobd_PLUGIN_NAME ) ?></span>
										<?php endif ?>
									</div>
								</div>

							</li>
						<?php endforeach ?>
					<?php endforeach ?>
				</ol>
			</li>
		<?php endforeach ?>
	<?php endif ?>
</ol>
