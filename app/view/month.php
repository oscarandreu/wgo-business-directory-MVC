<h2 class="wgobd-calendar-title"><?php echo esc_html( $title ) ?></h2>
<span class="wgobd-title-buttons">
	<a id="wgobd-today" class="wgobd-load-view wgobd-button" href="#action=wgobd_month&amp;wgobd_post_ids=<?php echo $post_ids ?>">
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
<table class="wgobd-month-view">
	<thead>
		<tr>
			<?php foreach( $weekdays as $weekday ): ?>
				<th class="wgobd-weekday"><?php echo $weekday; ?></th>
			<?php endforeach // weekday ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $cell_array as $week ): ?>
			<tr class="wgobd-week">
				<?php foreach( $week as $day ): ?>
					<?php if( $day['date'] ): ?>
						<td <?php if( $day['today'] ) echo 'class="wgobd-today"' ?>>
							<div class="wgobd-day">
								<div class="wgobd-date"><?php echo $day['date'] ?></div>
								<?php foreach( $day['events'] as $event ): ?>
									<a href="<?php echo esc_attr( get_permalink( $event->post_id ) ) . $event->instance_id ?>"
										class="wgobd-event-container
											wgobd-event-id-<?php echo $event->post_id ?>
											wgobd-event-instance-id-<?php echo $event->instance_id ?>
											<?php if( $event->allday ) echo 'wgobd-allday' ?>">

										<?php // Insert post ID for use by JavaScript filtering later ?>
										<input type="hidden" class="wgobd-post-id" value="<?php echo $event->post_id ?>" />

										<div class="wgobd-event-popup">
											<div class="wgobd-event-summary">
												<?php if( $event->category_colors ): ?>
												  <div class="wgobd-category-colors"><?php echo $event->category_colors ?></div>
												<?php endif ?>
												<?php if( $event->post_excerpt ): ?>
													<strong><?php _e( 'Summary:', wgobd_PLUGIN_NAME ) ?></strong>
													<p><?php echo esc_html( $event->post_excerpt ) ?></p>
												<?php endif ?>
												<div class="wgobd-read-more"><?php esc_html_e( 'click anywhere for details', wgobd_PLUGIN_NAME ) ?></div>
											</div>
											<div class="wgobd-event-popup-bg">
												<?php if( ! $event->allday ): ?>
													<span class="wgobd-event-time"><?php echo esc_html( $event->short_start_time ) ?></span>
												<?php endif ?>
												<span class="wgobd-event-title">
												  <?php if( function_exists( 'mb_strimwidth' ) ) : ?>
												    <?php echo esc_html( mb_strimwidth( apply_filters( 'the_title', $event->post->post_title ), 0, 35, '...' ) ) ?></span>
												  <?php else : ?>
												    <?php $read_more = strlen( apply_filters( 'the_title', $event->post->post_title ) ) > 35 ? '...' : '' ?>
                            <?php echo esc_html( substr( apply_filters( 'the_title', $event->post->post_title ), 0, 35 ) . $read_more );  ?>
												  <?php endif; ?>
												</span>
												<?php if( $event->allday ): ?>
													<small><?php esc_html_e( '(all-day)', wgobd_PLUGIN_NAME ) ?></small>
												<?php endif ?>
											</div>
										</div><!-- .event-popup -->

										<div class="wgobd-event <?php if( $event->post_id == $active_event ) echo 'wgobd-active-event' ?>" style="<?php echo $event->color_style ?>">
											<?php if( ! $event->allday ): ?>
												<span class="wgobd-event-time"><?php echo esc_html( $event->short_start_time ) ?></span>
											<?php endif ?>
											<span class="wgobd-event-title"><?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?></span>
										</div>

									</a>
								<?php endforeach // events ?>
							</div>
						</td>
					<?php else: ?>
						<td class="wgobd-empty"></td>
					<?php endif // date ?>
				<?php endforeach // day ?>
			</tr>
		<?php endforeach // week ?>
	</tbody>
</table>
