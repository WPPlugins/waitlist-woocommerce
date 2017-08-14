<?php
/**
* Plugin Name: WooCommerce Waitlist
* Plugin URI: http://xootix.com
* Author: XootiX
* Version: 1.4
* Text Domain: waitlist-woocommerce
* Domain Path: /languages
* Author URI: http://xootix.com
* Description: Waitlist WooCommerce allow users to add out of stock products to the waitlist and they get informed through email when the product is back in stock.
**/

//Exit if accessed directly
if(!defined('ABSPATH')){
	return; 	
}

//Load plugin text domain
function xoo_load_txtdomain() {
	$domain = 'waitlist-woocommerce';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	load_textdomain( $domain, WP_LANG_DIR . '/'.$domain.'-' . $locale . '.mo' ); //wp-content languages
	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' ); // Plugin Languages
	$premium_texts = __('Please verfiy you are a human.');
}
add_action('plugins_loaded','xoo_load_txtdomain');


include(plugin_dir_path(__FILE__).'/inc/xoo-wl-admin.php');
function xoo_wl_enqueue_scripts(){
	global $xoo_wl_sy_anim_value;
	$wl_nonce = wp_create_nonce('xoo-wl-email-nonce'); 
	wp_enqueue_style('xoo-wl-style',plugins_url('/assets/css/xoo-wl-style.css',__FILE__),null,'1.4');
	wp_enqueue_script( 'wc-add-to-cart-variation' );
	wp_enqueue_script('xoo-wl-js',plugins_url('/assets/js/xoo-wl-js.js',__FILE__),array('jquery'),'1.4',true);
	wp_localize_script('xoo-wl-js','xoo_wl_localize',array(
		'adminurl'     		=> admin_url().'admin-ajax.php',
		'wl_nonce'			=> $wl_nonce,
		'animation'			=> $xoo_wl_sy_anim_value,
		'e_empty_email' 	=> __('Email address cannot be empty.','waitlist-woocommerce'),
		'e_min_qty' 		=> __('Minimum quantity: 1','waitlist-woocommerce')
		));
}

add_action('wp_enqueue_scripts','xoo_wl_enqueue_scripts',500);


//Send Email
function xoo_wl_check_stock_updated($post_ID,$post){
	global $post,$pagenow;
	if(!is_admin() || in_array($pagenow, array('post-new.php'))){return;}

	$product_id 		= $post_ID;
	$all_products 		= array();
	$product 	  		= wc_get_product($product_id);
	if(!$product){return;}
	$product_type 		= $product->get_type();
	$product_name 		= $product->get_title();
	$featured_image_id 	= $product->get_image_id();

	if($product_type == 'variable'){
		$variations = $product->get_available_variations();

		foreach($variations as $variation){
			if($variation['is_in_stock']){
				$variation_id = $variation['variation_id'];
				$waitlist = get_post_meta($variation_id,'_xoo-wl-users',true);
				//Skip if waitlist is empty
				if($waitlist == '' || $waitlist == ' '){
					continue;
				}

				//Send Email
				$product_link  		= get_permalink($variation_id);
				$product_price 		= $variation['display_price'];
				$image_id  			= $variation['image_id'] ? $variation['image_id'] : $featured_image_id;
				include(plugin_dir_path(__FILE__).'/templates/xoo-wl-mail.php');
				update_post_meta( $variation_id, '_xoo-wl-users', '');
			}
		}
	}
	else{
		$waitlist = get_post_meta($product_id,'_xoo-wl-users',true);
		$stock_status = $product->get_stock_status();
		if($stock_status == 'instock' && $waitlist != '' && $waitlist != ' '){
			$product_link  = get_permalink($product_id);
			$product_price = $product->get_price();
			$image_id 	   = $featured_image_id;
			include(plugin_dir_path(__FILE__).'/templates/xoo-wl-mail.php');
			update_post_meta( $product_id, '_xoo-wl-users', '');
		}
	}
	
}
if($xoo_wl_gl_enmail_value){
	add_action('save_post','xoo_wl_check_stock_updated',10,2); 
}


/*Insert email ids into wp_post_meta table 
	@metakey = _xoo-wl-users
*/ 
function xoo_wl_add_email(){
	check_ajax_referer('xoo-wl-email-nonce','security');
	global $xoo_wl_gl_enqty_value;
	$product_id = sanitize_text_field($_POST['product_id']);
	$user_email = sanitize_text_field($_POST['user_email'] );

	if(!$xoo_wl_gl_enqty_value){
		$user_qty = 1;
	}
	else{
		$user_qty = intval($_POST['user_qty']);
	}

	if(empty($user_email)){
		$error = __('Email address cannot be empty.','waitlist-woocommerce');
		$json = array('email_empty' => $error);
		wp_send_json($json);
	}
	elseif(!$user_qty){
		$error = __('Invalid Quantity.','waitlist-woocommerce');
		$json  = array('quantity_invalid' => $error);
		wp_send_json($json);
	}

	if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
		$error = __('Please enter valid email address.','waitlist-woocommerce');
		$json  = array('email_invalid' => $error);
		wp_send_json($json);
	}

	$stock_status = get_post_meta($product_id, '_stock_status',true);

	if($stock_status == 'instock'){
		$in_stock = true;
		$post = get_post($product_id);
		if($post->post_type == 'product_variation'){
			$parent_product = new WC_Product($post->post_parent);
			$product = new Wc_Product_Variation($product_id);
			if($product->managing_stock() != 1 && $parent_product->managing_stock() == 1 && !$parent_product->backorders_allowed()){
				if($parent_product->get_stock_quantity() == 0){
					$in_stock = false;
				}
			}
		}
		if($in_stock){
			$error = __('Product is already in stock. You can add to cart.','waitlist-woocommerce');
			$json  = array('in_stock' => $error);
			wp_send_json($json);
		}
	}

	$previous_value = json_decode(get_post_meta( $product_id,'_xoo-wl-users', true ),true);

	if(empty($previous_value)){
		add_post_meta( 'product',$product_id , '_xoo-wl-users', '',true);
	}
	else{
		if(array_key_exists($user_email,$previous_value)){
			$error = __('You are already in waitlist.','waitlist-woocommerce');
			$json = array('email_exists' => $error);
			wp_send_json($json);
		}
	}

	$previous_value[$user_email] = $user_qty;		
	$new_value = json_encode($previous_value);
	update_post_meta( $product_id, '_xoo-wl-users', $new_value);
	$error =  __('You are now in waitlist. We will inform you as soon as we are back in stock.','waitlist-woocommerce');
	$json = array('success' => $error);
	wp_send_json($json);
}
add_action('wp_ajax_xoo_wl_add_email','xoo_wl_add_email');
add_action('wp_ajax_nopriv_xoo_wl_add_email','xoo_wl_add_email');



//Waitlist Form on button.
function xoo_wl_shop_button(){
	global $product,$xoo_wl_gl_bntxt_value;
	if($product->is_type('variable') || $product->is_in_stock()){return;}
	$product_id = $product->get_id();
	$html = '<a href="#" class="xoo-wl-btn button" xwl-id ='.$product_id.'>'.$xoo_wl_gl_bntxt_value.'</a>';
	echo $html;
}

//Waitlist Form.
function xoo_wl_form(){
	include(plugin_dir_path(__FILE__).'/templates/xoo-wl-form.php');
}
add_action('wp_footer','xoo_wl_form');

function xoo_wl_enable_on_shop(){
	global $xoo_wl_sy_posi_value,$xoo_wl_gl_enshop_value;
	if(!$xoo_wl_gl_enshop_value){return;}
	add_action($xoo_wl_sy_posi_value,'woocommerce_template_loop_product_link_close',11);//Closing WC link
	add_action($xoo_wl_sy_posi_value,'xoo_wl_shop_button',11);// Waitlist Button
	add_action($xoo_wl_sy_posi_value,'woocommerce_template_loop_product_link_open',11);// Opening WC link

}
add_action('init','xoo_wl_enable_on_shop');

//Waitlist Form on product page.
function xoo_wl_form_single(){
	global $product,$variations,$xoo_wl_gl_bntxt_value;
	$product_type = $product->get_type();
	$product_id = $product->get_id();
	$wl_button = '<a href="#" class="xoo-wl-btn button" xwl-id ='.$product_id.'>'.$xoo_wl_gl_bntxt_value.'</a>';

	if($product_type != 'variable'){
		if(!$product->is_in_stock()){
			echo $wl_button;
		}
	}
	else if($product_type == 'variable'){
		$variations = $product->get_available_variations();
		$out_of_stock = array();
		if($product->managing_stock()){
			if($product->get_stock_quantity() == 0 && !$product->backorders_allowed()){
				foreach($variations as $variation){
					if($variation['max_qty'] === 0){
						$out_of_stock[] = $variation['variation_id'];
					}
				}
			}
		}

		foreach ($variations as $variation) {
			$in_stock = $variation['is_in_stock'];
			if(!$in_stock){
				$out_of_stock[] = $variation['variation_id']; 
			}
		}
		if(empty($out_of_stock)){return;}

		$json = json_encode(array_unique($out_of_stock));

		$html  = '<input type="hidden" class="xoo-wl-var" data-xoo_wl_var ='.$json.'>';
		$html  .= $wl_button;
		echo $html;
	}
	
	
}
add_action('woocommerce_single_product_summary','xoo_wl_form_single',31);

//Waitlist Styling
function xoo_wl_style(){
	global $xoo_wl_sy_anim_value;
	$style = '<style>';
	if($xoo_wl_sy_anim_value  == 'fade-in'){
		$style  .=  '
			.xoo-wl-inmodal{
				-webkit-animation: xoo-wl-key-fadein 500ms ease;
				animation: xoo-wl-key-fadein 500ms ease;
    			animation-fill-mode: forwards;
   				opacity: 0;
			}

		';
	}
	elseif($xoo_wl_sy_anim_value  == 'slide-down'){
		$style  .=  '
			.xoo-wl-inmodal{
				-webkit-animation: xoo-wl-key-slide 650ms ease;
				animation: xoo-wl-key-slide 650ms ease;
    			animation-fill-mode: forwards;
			}

		';
	}
	elseif($xoo_wl_sy_anim_value  == 'bounce-in'){
		$style  .=  '
			.xoo-wl-inmodal{
				-webkit-animation: xoo-wl-key-slide 650ms cubic-bezier(.47,1.41,.6,1.17);
				animation: xoo-wl-key-slide 650ms cubic-bezier(.47,1.41,.6,1.17);
    			animation-fill-mode: forwards;
			}

		';
	}
	$style .= '</style>';
	echo $style;
}
add_action('wp_head','xoo_wl_style');

//Send Email using send button
function xoo_send_email(){
	if(isset($_POST['post_id'])){
		$product_id 	= $_POST['post_id'];
		$product 		= wc_get_product($product_id );
		if(!$product){return;}
		$product_type 	= $product->get_type();
		$waitlist 		= get_post_meta( $product_id , '_xoo-wl-users',true);
		if($waitlist == '' || $waitlist == ' '){}
		else{
			$product_name 	= $product->get_title();
			$product_link 	= get_permalink($product_id);
			$product_price 	= $product->get_price();
			$image_id 		= $product->get_image_id();

			include(plugin_dir_path(__FILE__).'templates/xoo-wl-mail.php');
			update_post_meta( $product_id, '_xoo-wl-users', '');
		}
	}
	die();
}

add_action('wp_ajax_xoo_send_email','xoo_send_email');

//function remove email id
function xoo_remove_email(){
	$pid = $_POST['pid'];
	$emid = $_POST['emid'];
	$waitlist 	= json_decode(get_post_meta( $pid, '_xoo-wl-users',true),true);
	if(array_key_exists($emid, $waitlist)){
		unset($waitlist[$emid]);
		if(!empty($waitlist)){
			update_post_meta($pid,'_xoo-wl-users',json_encode($waitlist));
		}
		else{
			update_post_meta($pid,'_xoo-wl-users','');
		}
	}
	die();
}
add_action('wp_ajax_xoo_remove_email','xoo_remove_email');

?>