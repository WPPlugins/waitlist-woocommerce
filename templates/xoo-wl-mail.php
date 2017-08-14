<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}

global $xoo_wl_emsy_logo_value,$xoo_wl_emsy_align_value;

$product_link = get_permalink($product->post->ID);
$product_name = $product->post->post_title;


if($image_id){
  $product_image = wp_get_attachment_url($image_id);
}
else{
  $product_image = plugins_url('/assets/images/placeholder.jpg',dirname(__FILE__));
}

//Logo

if($xoo_wl_emsy_logo_value){
  $logo  = '<tr>';
  $logo .= '<td align="center" style="padding: 0 0 10px 0">';
  $logo .= '<img height="auto" width="auto" border="0" alt="Product Image" src="'.$xoo_wl_emsy_logo_value.'" style="display: block"/>';
  $logo .= '</td></tr>';   
}

$email_all = json_decode($waitlist,true);
$subject = sprintf(__('%s is back in stock','waitlist-woocommerce'),$product_name);

//Headers
$headers = array();

//Email FROM [email-id]
function xoo_wl_email_from(){
  global $xoo_wl_emgl_frem_value;
  if($xoo_wl_emgl_frem_value){
    return $xoo_wl_emgl_frem_value;
  }
  else{
    // Get the site domain and get rid of www.
    $sitename = strtolower( $_SERVER['SERVER_NAME'] );
    if ( substr( $sitename, 0, 4 ) == 'www.' ) {
        $sitename = substr( $sitename, 4 );
    }

    return 'wordpress@' . $sitename;
  }
}

//Email From [name]
function xoo_wl_email_from_name(){
  global $xoo_wl_emgl_frnm_value;
  if($xoo_wl_emgl_frnm_value){
    return $xoo_wl_emgl_frnm_value;
  }
  else{
    return 'Wordpress';
  }
}

$headers[] = 'Content-Type: text/html; charset=UTF-8'; 
$headers[] = 'From: '.xoo_wl_email_from_name().' <'.xoo_wl_email_from().'>';



//Email Content
ob_start();
include(plugin_dir_path(__FILE__).'/xoo-wl-email-content.php');
$content = ob_get_clean();

foreach ($email_all as $emails => $qty) {
	wp_mail($emails, $subject, $content,$headers);
}
?>