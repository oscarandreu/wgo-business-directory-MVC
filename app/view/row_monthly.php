<div class="wgobd_repeat_centered_content">
  <label for="wgobd_monthly_count">
	  <?php _e( 'Every', wgobd_PLUGIN_NAME ) ?>:
  </label>
  <?php echo $count ?>
  <div class="wgobd_repeat_monthly_type">
	<input type="radio" name="wgobd_monthly_type" id="wgobd_monthly_type_bymonthday" value="bymonthday" checked="1" />
	<label for="wgobd_monthly_type_bymonthday">
	  <?php _e( 'On day of the month', wgobd_PLUGIN_NAME ) ?>
	</label>
	<input type="radio" name="wgobd_monthly_type" id="wgobd_monthly_type_byday" value="byday" />
	<label for="wgobd_monthly_type_byday">
	  <?php _e( 'On day of the week', wgobd_PLUGIN_NAME ) ?>
	</label>
  </div>
  <div style="clear:both;"></div>
  <div id="ai1c_repeat_monthly_bymonthday">
  	<?php echo $month ?>
  </div>
  <div id="ai1c_repeat_monthly_byday">
	<label for="wgobd_monthly_type_byday">
	  <?php _e( 'Every', wgobd_PLUGIN_NAME ) ?>
	</label>
  	<?php echo $day_nums ?>
  	<?php echo $week_days ?>
  </div>
</div>