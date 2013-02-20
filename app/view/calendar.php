<!-- START All-in-One Event Calendar Plugin - Version 1.5 -->
<table class="wgobd-calendar-toolbar">
	<tbody>
		<tr>

			<td>
				<ul class="wgobd-view-tabs">
					<li>
						<a id="wgobd-view-month" class="wgobd-load-view wgobd-button"
							href="#action=wgobd_month&amp;wgobd_post_ids=<?php echo $selected_post_ids ?>">
							<img src="<?php echo wgobd_IMAGE_URL ?>/month-view.png" alt="<?php _e( 'Month', wgobd_PLUGIN_NAME ) ?>" />
							<?php _e( 'Month', wgobd_PLUGIN_NAME ) ?>
						</a>
					</li>
					<li>
						<a id="wgobd-view-oneday" class="wgobd-load-view wgobd-button"
							href="#action=wgobd_oneday&amp;wgobd_post_ids=<?php echo $selected_post_ids ?>">
							<img src="<?php echo wgobd_IMAGE_URL ?>/oneday-view.png" alt="<?php _e( 'Day', wgobd_PLUGIN_NAME ) ?>" />
							<?php _e( 'Day', wgobd_PLUGIN_NAME ) ?>
						</a>
					</li>
					<li>
						<a id="wgobd-view-week" class="wgobd-load-view wgobd-button"
							href="#action=wgobd_week&amp;wgobd_post_ids=<?php echo $selected_post_ids ?>">
							<img src="<?php echo wgobd_IMAGE_URL ?>/week-view.png" alt="<?php _e( 'Week', wgobd_PLUGIN_NAME ) ?>" />
							<?php _e( 'Week', wgobd_PLUGIN_NAME ) ?>
						</a>
					</li>
					<li>
						<a id="wgobd-view-agenda" class="wgobd-load-view wgobd-button"
							href="#action=wgobd_agenda&amp;wgobd_post_ids=<?php echo $selected_post_ids ?>">
							<img src="<?php echo wgobd_IMAGE_URL ?>/agenda-view.png" alt="<?php _e( 'Month', wgobd_PLUGIN_NAME ) ?>" />
							<?php _e( 'Agenda', wgobd_PLUGIN_NAME ) ?>
						</a>
					</li>
				</ul>
			</td>

			<?php if( $create_event_url ): ?>
				<td>
					<a class="wgobd-button" href="<?php echo $create_event_url ?>">
						<?php _e( '+ Post Your Event', wgobd_PLUGIN_NAME ) ?>
					</a>
				</td>
			<?php endif ?>

			<?php if( $categories || $tags ): ?>
				<td>
					<div class="wgobd-filters-container">
						<label class="wgobd-label">
							<a class="wgobd-clear-filters" title="<?php _e( 'Clear Filters', wgobd_PLUGIN_NAME ) ?>"><?php _e( '✘', wgobd_PLUGIN_NAME ) ?></a>
							<?php _e( 'Filter:', wgobd_PLUGIN_NAME ) ?>
						</label>

						<?php if( $categories ): ?>
							<span class="wgobd-filter-selector-container">
								<a class="wgobd-button wgobd-dropdown"><?php _e( 'Categories ▾', wgobd_PLUGIN_NAME ) ?></a>
								<input class="wgobd-selected-terms"
									id="wgobd-selected-categories"
									type="hidden"
									value="<?php echo $selected_cat_ids ?>" />
								<div class="wgobd-filter-selector wgobd-category-filter-selector">
									<ul>
										<?php foreach( $categories as $cat ): ?>
											<li class="wgobd-category"
												<?php if( $cat->description ) echo 'title="' . esc_attr( $cat->description ) . '"' ?>>
												<?php echo $cat->color ?>
												<?php echo esc_html( $cat->name ) ?>
												<input class="wgobd-term-ids" name="wgobd-categories" type="hidden" value="<?php echo $cat->term_id ?>" />
											</li>
										<?php endforeach ?>
									</ul>
								</div>
							</span>
						<?php endif // $categories ?>

						<?php if( $tags ): ?>
							<span class="wgobd-filter-selector-container">
								<a class="wgobd-button wgobd-dropdown"><?php _e( 'Tags ▾', wgobd_PLUGIN_NAME ) ?></a>
								<input class="wgobd-selected-terms"
									id="wgobd-selected-tags"
									type="hidden"
									value="<?php echo $selected_tag_ids ?>" />
								<div class="wgobd-filter-selector wgobd-tag-filter-selector">
									<ul>
										<?php foreach( $tags as $tag ): ?>
											<li class="wgobd-tag"
												<?php if( $tag->description ) echo 'title="' . esc_attr( $tag->description ) . '"' ?>
												style="<?php echo $tag->count > 1 ? 'font-weight: bold;' : 'font-size: 10px !important;' ?>">
												<?php echo esc_html( $tag->name ) . " ($tag->count)" ?>
												<input class="wgobd-term-ids" name="wgobd-tags" type="hidden" value="<?php echo $tag->term_id ?>" />
											</li>
										<?php endforeach ?>
									</ul>
									<input class="wgobd-selected-terms" id="wgobd-selected-tags" type="hidden" />
								</div>
							</span>
						<?php endif // $tags ?>
					</div>
				</td>
			<?php endif // $categories || $tags ?>

		</tr>
	</tbody>
</table>

<div id="wgobd-calendar-view-container">
	<div id="wgobd-calendar-view-loading" class="wgobd-loading"></div>
	<div id="wgobd-calendar-view">
		<?php echo $view ?>
	</div>
</div>

<?php if( $show_subscribe_buttons ): ?>
	<a class="wgobd-button wgobd-subscribe"
		href="<?php echo wgobd_EXPORT_URL ?>"
		title="<?php _e( 'Subscribe to this calendar using your favourite calendar program (iCal, Outlook, etc.)', wgobd_PLUGIN_NAME ) ?>" />
		<?php _e( '✔ Subscribe', wgobd_PLUGIN_NAME ) ?>
		<span class="wgobd-subscribe-filtered"><?php _e( 'to this filtered calendar', wgobd_PLUGIN_NAME ) ?></span>
	</a>
	<a class="wgobd-button wgobd-subscribe-google" target="_blank"
		href="http://www.google.com/calendar/render?cid=<?php echo urlencode( str_replace( 'webcal://', 'http://', wgobd_EXPORT_URL ) ) ?>"
		title="<?php _e( 'Subscribe to this calendar in your Google Calendar', wgobd_PLUGIN_NAME ) ?>" />
		<img src="<?php echo wgobd_IMAGE_URL ?>/google-calendar.png" />
		<?php _e( 'Subscribe in Google Calendar', wgobd_PLUGIN_NAME ) ?>
	</a>
<?php endif ?>
<!-- END All-in-One Event Calendar Plugin -->
