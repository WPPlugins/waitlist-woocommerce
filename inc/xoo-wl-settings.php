<?php
//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}
?>
<?php settings_errors(); ?>
<div class="xoo-wl-main-settings">
	<form method="POST" action="options.php" class="xoo-wl-form">
		<?php settings_fields('xoo-wl-group'); ?>
		<?php do_settings_sections('xoo_waitlist'); ?>
		<div class="pemail-opac"></div>
		<div class="pemail-modal">
			<div class="pemail-cont">
				<span class="pemail-close">X</span>
				<?php include(plugin_dir_path(__FILE__).'xoo-email-demo.php'); ?>
			</div>
		</div>
		<?php submit_button(); ?>
	</form>
	<div class="rate-plugin">If you like the plugin , please show your support by rating <a href="https://wordpress.org/support/plugin/waitlist-woocommerce/reviews/" target="_blank">here.</a></div>
		<div class="plugin-support">
			Use <a href="http://xootix.com/plugins/waitlist-for-woocommerce" target="_blank"> Live Chat </a>for instant support.
		</div>
</div>
<div class="xoo-wl-sidebar">
	<div class="xoo-chat">
		<span class="xoo-chhead">Need Help?</span>
		<span class="dashicons dashicons-format-chat xoo-chicon"></span>
		<span class="xoo-chtxt">Use <a href="http://xootix.com/support">Live Chat</a></span>
	</div>
	<a href="http://xootix.com/plugins" class="xoo-more-plugins">Try other awesome plugins.</a>

</div>