<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}

global $xoo_wl_gl_enguest_value,$xoo_wl_gl_enqty_value,$xoo_wl_gl_bntxt_value;

?>

<div class="xoo-wl-opac"></div>
<div class="xoo-wl-modal">
	<div class="xoo-wl-inmodal">
		<div class="xoo-wl-plouter">
			<span class="xoo-wl-preloader xoo-wl xoowl-spinner2"></span>
		</div>
		<span class="xoo-wl-close xoowl-cross xoo-wl"></span>
		<span class="xoo-wl-success"></span>
		<div class="xoo-wl-main">
			<?php
				$user_logged_in =  wp_get_current_user();
				$logged_in_email = $user_logged_in->user_email;
				if(!$logged_in_email && !$xoo_wl_gl_enguest_value){
					$html  = '<span class="xoo-wl-nlogin">'.__('You need to Login for joining waitlist.','waitlist-woocommerce').'</span>';
					$html .= '<div class="xoo-wl-myacc">';
					$html .= '<a href="'.get_permalink(get_option("woocommerce_myaccount_page_id")).'" class="button">Log In</a> Or ';
					$html .= '<a href="'.get_permalink(get_option("woocommerce_myaccount_page_id")).'" class="button">Sign up</a>';
					$html .= '</div>';
					$html .= '</div></div>';
					echo $html;
				}else{
			?>
			<div class="xoo-wl-info">
				<span class="xoo-wl-mhead"><?php echo $xoo_wl_gl_bntxt_value; ?></span>
				<span class="xoo-wl-minfo"><?php _e('We will inform you when the product arrives in stock. Just leave your valid email address below.','waitlist-woocommerce'); ?></span>
				<span class="xoo-wl-error"></span>
			</div>
			<form method="POST" action="" class="xoo-wl-form">
			<span class="xwl-emlab"><?php _e('Email','waitlist-woocommerce'); ?></span>
			<input type="text" placeholder="<?php _e('Email','waitlist-woocommerce'); ?>" name="xoo-wl-email" class='xoo-wl-email' value="<?php echo $logged_in_email; ?>">
			<?php 
				if($xoo_wl_gl_enqty_value){

					echo '<span class="xwl-qtlab">'.__('Quantity','waitlist-woocommerce').'</span>'.
						 '<input type="number" placeholder="'.__('Quantity required','waitlist-woocommerce').'" name="xoo-wl-qty" class="xoo-wl-qty">';
				}
			?>
			<input type="hidden" value ="" class="xwl-form-id">
			<span class="xoo-wl-emsec"><?php _e('We won\'t share your address with anybody else.','waitlist-woocommerce'); ?></span>
			<button name="xoo-wl-submit" class="xoo-wl-submit"><?php _e('Email me when available','waitlist-woocommerce'); ?></button>
			</form>
		</div>
	</div>
	<?php } ?>
</div>