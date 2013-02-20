<div class="wgobd-plugin-branding">
	
	<div class="wgobd-plugin-logo">
		<img src="http://yellowseedimages.s3.amazonaws.com/logo-plugin.png" alt="<?php esc_attr_e( 'The Seed Studio', wgobd_PLUGIN_NAME ) ?>" class="pluginlogo" />
	</div>
	
	<p><?php _e( 'The Seed Studio provides web development and support services for clients and web developers.', wgobd_PLUGIN_NAME ) ?></p>

	<div class="wgobd-follow-fan">
		<div class="wgobd-facebook-like-top">
			<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
			<fb:like href="http://www.facebook.com/pages/The-Seed-Agency/66657743707" layout="button_count" show_faces="true" width="110" font="lucida grande"></fb:like>
		</div>
		<a href="http://twitter.com/theseednet" class="twitter-follow-button"><?php _e( 'Follow @theseednet', wgobd_PLUGIN_NAME ) ?></a>
		<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
		<div class="clear"></div>
	</div>

	<div class="wgobd-support-button">
		<a href="http://theseednetwork.com/get-supported/" target="_blank"><?php _e( 'Get Support<span> from one of our experienced pros</span>', wgobd_PLUGIN_NAME ) ?></a>
	</div>

	<h2><?php _e( 'Support', wgobd_PLUGIN_NAME ) ?></h2>
	<p>
		<a href="http://theseednetwork.com/software/all-in-one-event-calendar-wordpress/all-in-one-event-calendar-documentation/" target="_blank"><?php _e( 'View plugin documentation', wgobd_PLUGIN_NAME ) ?></a>
	</p>
	<p>
		<?php _e( 'You can also hire The Seed for support on a contract or per-hour basis for this plugin, for your website or for any of your Internet marketing needs (we can really help!).', wgobd_PLUGIN_NAME ) ?>
	</p>
	<p>
		<?php _e( 'Plugin users: The Seed gives support priority to clients. For free support from other WordPress users, visit the plugin\'s forum.', wgobd_PLUGIN_NAME ) ?>
	</p>

	<h2><?php _e( 'Vote and Share', wgobd_PLUGIN_NAME ) ?></h2>
	<p>
		<?php _e( 'This plugin is offered free to the Wordpress Community under the GPL3 license. All we ask is that you:', wgobd_PLUGIN_NAME ) ?>
		<ol>
		  <li><?php _e( '<a href="http://wordpress.org/extend/plugins/all-in-one-event-calendar/" target="_blank">Give it a five-star rating on wordpress.org</a> (if you think it deserves it!)', wgobd_PLUGIN_NAME ) ?></li>
		  <li><a href="http://theseednetwork.com/software/all-in-one-event-calendar-wordpress/" target="_blank"><?php _e( 'Link to the plugin page on our website', wgobd_PLUGIN_NAME ) ?></a></li>
		  <li><a href="http://www.facebook.com/theseednet" target="_blank"><?php _e( 'Become a Fan on Facebook', wgobd_PLUGIN_NAME ) ?></a></li>
		  <li><a href="https://twitter.com/intent/user?screen_name=theseednet" target="_blank"><?php _e( 'Follow us on Twitter', wgobd_PLUGIN_NAME ) ?></a></li>
		</ol>
	</p>

	<?php if( count( $news ) >= 1 ) : ?>
		<h2><?php _e( 'Latest from the Seed Network', wgobd_PLUGIN_NAME ) ?></h2>
		<p>
			<ul id="wgobd-rss-news">
			<?php foreach( $news as $n ) : ?>
				<li><a href="<?php echo $n->get_link() ?>" target="_blank"><?php echo $n->get_title() ?></a></li>
			<?php endforeach ?>
			</ul>
		</p>
	<?php endif ?>
</div>
<br class="clear" />
