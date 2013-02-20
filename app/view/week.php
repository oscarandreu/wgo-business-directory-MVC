<h2 class="wgobd-calendar-title"><?php echo esc_html( $title ) ?></h2>
<span class="wgobd-title-buttons">
	<a id="wgobd-today" class="wgobd-load-view wgobd-button" href="#action=wgobd_week&amp;wgobd_post_ids=<?php echo $post_ids ?>">
		<?php _e( 'Today', wgobd_PLUGIN_NAME ) ?>
	</a>
</span>
<ul class="wgobd-pagination">
	<?php foreach( $pagination_links as $link ) : ?>
		<li>
			<a id="<?php echo $link['id'] ?>"
				class="wgobd-load-view wgobd-button"
				href="<?php echo esc_attr( $link['href'] ) ?>&amp;wgobd_post_ids=<?php echo $post_ids ?>">
				<?php echo esc_html( $link['text'] ) ?>
			</a>
		</li>
	<?php endforeach ?>
</ul>
<table class="wgobd-week-view-original">
	<thead>
		<tr>
			<?php foreach( $cell_array as $date => $day ) : ?>
				<th class="wgobd-weekday <?php if( $day['today'] ) echo 'wgobd-today' ?>">
					<span class="wgobd-weekday-date"><?php echo date_i18n( 'j', $date, true ) ?></span>
					<span class="wgobd-weekday-day"><?php echo date_i18n( 'D', $date, true ) ?></span>
				</th>
			<?php endforeach // weekday ?>
		</tr>
		<tr>
			<?php foreach( $cell_array as $day ) : ?>
				<td class="wgobd-allday-events <?php if( $day['today'] ) echo 'wgobd-today' ?>">

					<?php if( ! $done_allday_label ) : ?>
						<div class="wgobd-allday-label"><?php _e( 'All-day', wgobd_PLUGIN_NAME ) ?></div>
						<?php $done_allday_label = true ?>
					<?php endif ?>

					<?php foreach( $day['allday'] as $event ) : ?>
						<a href="<?php echo esc_attr( get_permalink( $event->post_id ) ) . $event->instance_id ?>"
							class="wgobd-event-container
								wgobd-event-id-<?php echo $event->post_id ?>
								wgobd-event-instance-id-<?php echo $event->instance_id ?>
								wgobd-allday
								<?php if( $event->start_truncated ) echo 'wgobd-start-truncated' ?>
								<?php if( $event->end_truncated ) echo 'wgobd-end-truncated' ?>">

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
									<span class="wgobd-event-title">
									  <?php if( function_exists( 'mb_strimwidth' ) ) : ?>
									    <?php echo esc_html( mb_strimwidth( apply_filters( 'the_title', $event->post->post_title ), 0, 35, '...' ) ) ?></span>
									  <?php else : ?>
									    <?php $read_more = strlen( apply_filters( 'the_title', $event->post->post_title ) ) > 35 ? '...' : '' ?>
                      <?php echo esc_html( substr( apply_filters( 'the_title', $event->post->post_title ), 0, 35 ) . $read_more );  ?>
									  <?php endif; ?>
									</span>
									<small><?php esc_html_e( '(all-day)', wgobd_PLUGIN_NAME ) ?></small>
								</div>
							</div><!-- .event-popup -->

							<div class="wgobd-event <?php if( $event->post_id == $active_event ) echo 'wgobd-active-event' ?>" style="<?php echo $event->color_style ?>">
								<span class="wgobd-event-title"><?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?></span>
							</div>

						</a>
					<?php endforeach // allday ?>

				</td>
			<?php endforeach // weekday ?>
		</tr>
	</thead>
	<tbody>
		<tr class="wgobd-week">
			<?php foreach( $cell_array as $day ): ?>
				<td <?php if( $day['today'] ) echo 'class="wgobd-today"' ?>>

					<?php if( ! $done_grid ) : ?>
						<div class="wgobd-grid-container">
							<?php for( $hour = 0; $hour < 24; $hour++ ) : ?>
								<div class="wgobd-hour-marker <?php if( $hour >= 8 && $hour < 18 ) echo 'wgobd-business-hour' ?>" style="top: <?php echo $hour * 60 ?>px;">
									<div><?php echo esc_html( date_i18n( $time_format, gmmktime( $hour, 0 ), true ) ) ?></div>
								</div>
								<?php for( $quarter = 1; $quarter < 4; $quarter++ ) : ?>
									<div class="wgobd-quarter-marker" style="top: <?php echo $hour * 60 + $quarter * 15 ?>px;"></div>
								<?php endfor ?>
							<?php endfor ?>
							<div class="wgobd-now-marker" style="top: <?php echo $now_top ?>px;"></div>
						</div>
						<?php $done_grid = true ?>
					<?php endif ?>

					<div class="wgobd-day">
						<?php foreach( $day['notallday'] as $notallday ): ?>
							<?php extract( $notallday ) ?>
							<a href="<?php echo esc_attr( get_permalink( $event->post_id ) ) . $event->instance_id ?>"
								class="wgobd-event-container
									wgobd-event-id-<?php echo $event->post_id ?>
									wgobd-event-instance-id-<?php echo $event->instance_id ?>
									<?php if( $event->start_truncated ) echo 'wgobd-start-truncated' ?>
									<?php if( $event->end_truncated ) echo 'wgobd-end-truncated' ?>"
								style="top: <?php echo $top ?>px; height: <?php echo max( $height, 31 ) ?>px; left: <?php echo $indent * 8 ?>px; <?php echo $event->color_style ?> <?php if( $event->faded_color ) echo "border: 2px solid $event->faded_color !important;" ?> background: linear-gradient( top, #fff, <?php echo $event->faded_color ?> ) !important; background: -o-linear-gradient( top, #fff, <?php echo $event->faded_color ?> ) !important; background: -moz-linear-gradient( top, #fff, <?php echo $event->faded_color ?> ) !important; background: -webkit-gradient( linear, left top, left bottom, color-stop( 0, # ), color-stop( 1, <?php echo $event->faded_color ?> ) ) !important; background: -webkit-linear-gradient( top, #fff, <?php echo $event->faded_color ?> ) !important;">

								<?php if( $event->start_truncated ) : ?><div class="wgobd-start-truncator">◤</div><?php endif ?>
								<?php if( $event->end_truncated ) : ?><div class="wgobd-end-truncator">◢</div><?php endif ?>

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
										<span class="wgobd-event-time"><?php echo esc_html( $event->short_start_time ) ?></span>
										<span class="wgobd-event-title"><?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?></span>
										</span>
									</div>
								</div><!-- .event-popup -->

								<div class="wgobd-event <?php if( $event->post_id == $active_event ) echo 'wgobd-active-event' ?>">
									<span class="wgobd-event-time"><?php echo esc_html( $event->short_start_time ) ?></span>
									<span class="wgobd-event-title"><?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?></span>
								</div>

							</a>
						<?php endforeach // events ?>
					</div>
				</td>
			<?php endforeach // day ?>
		</tr>
	</tbody>
</table>
