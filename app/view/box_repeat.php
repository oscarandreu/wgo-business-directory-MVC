<ul class="wgobd_repeat_tabs">
  <li><a href="#wgobd_daily_content" id="wgobd_daily_tab" class="wgobd_tab wgobd_active"><?php _e( 'Daily', wgobd_PLUGIN_NAME ) ;?></a></li>
  <li><a href="#wgobd_weekly_content" id="wgobd_weekly_tab" class="wgobd_tab"><?php _e( 'Weekly', wgobd_PLUGIN_NAME ) ;?></a></li>
  <li><a href="#wgobd_monthly_content" id="wgobd_monthly_tab" class="wgobd_tab"><?php _e( 'Monthly', wgobd_PLUGIN_NAME ) ;?></a></li>
  <li><a href="#wgobd_yearly_content" id="wgobd_yearly_tab" class="wgobd_tab"><?php _e( 'Yearly', wgobd_PLUGIN_NAME ) ;?></a></li>
</ul>
<div style="clear:both;"></div>
<div id="wgobd_daily_content" class="wgobd_tab_content" title="daily">
  <?php echo $row_daily ?>
  <div id="wgobd_repeat_tab_append">
    <div id="wgobd_ending_box" class="wgobd_repeat_centered_content">
  		<div id="wgobd_end_holder">
  		  <label for="wgobd_end">
  				<?php _e( 'End', wgobd_PLUGIN_NAME ) ?>:
  			</label>
  			 <?php echo $end ?>
  		</div>
  		<div style="clear:both;"></div>
  		<div id="wgobd_count_holder">
  		  <label for="wgobd_count">
  				<?php _e( 'Ending after', wgobd_PLUGIN_NAME ) ?>:
  			</label>
  			<?php echo $count; ?>
  		</div>
  		<div style="clear:both;"></div>
  		<div id="wgobd_until_holder">
  		  <label for="wgobd_until-date-input">
  				<?php _e( 'On date', wgobd_PLUGIN_NAME ) ?>:
  			</label>
  			<input type="text" class="wgobd-date-input" id="wgobd_until-date-input" />
  			<input type="hidden" name="wgobd_until_time" id="wgobd_until-time" value="<?php echo !is_null( $until ) && $until > 0 ? $until : '' ?>" />
  		</div>
  		<div style="clear:both;"></div>
  	</div>
  	<div id="wgobd_apply_button_holder">
      <input type="button" name="wgobd_none_button" value="<?php _e( 'Apply', wgobd_PLUGIN_NAME ) ?>" class="wgobd_repeat_apply button button-highlighted" />
      <a href="#wgobd_cancel" class="wgobd_repeat_cancel"><?php _e( 'Cancel', wgobd_PLUGIN_NAME ) ?></a>
    </div>
    <div style="clear:both;"></div>
  </div>
  <div style="clear:both;"></div>
</div>
<div id="wgobd_weekly_content" class="wgobd_tab_content" title="weekly">
  <?php echo $row_weekly ?>
</div>
<div id="wgobd_monthly_content" class="wgobd_tab_content" title="monthly">
  <?php echo $row_monthly ?>
</div>
<div id="wgobd_yearly_content" class="wgobd_tab_content" title="yearly">
  <?php echo $row_yearly ?>
</div>
<input type="hidden" id="wgobd_is_box_repeat" value="<?php echo $repeat ?>" />
<div style="clear:both;"></div>