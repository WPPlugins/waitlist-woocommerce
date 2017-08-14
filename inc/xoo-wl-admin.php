<?php
/**
 ========================
      ADMIN SETTINGS
 ========================
 */

//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}

//Enqueue Scripts & Stylesheet
function xoo_wl_admin_enqueue($hook){
	$screen = get_current_screen();
	$screen_id = $screen->id;
	if($screen_id != 'toplevel_page_xoo_waitlist' && $screen_id != 'wait-list_page_xoo_waitlist_view'){return;}

	wp_enqueue_style('xoo-wl-admin-css',plugins_url('/assets/css/xoo-wl-admin-style.css',__FILE__),null,'1.4');
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('xoo-wl-admin-js',plugins_url('/assets/js/xoo-wl-admin-js.js',__FILE__),array('jquery','wp-color-picker'),'1.4',true);
	wp_enqueue_media();
	wp_localize_script('xoo-wl-admin-js','admin_wl_lz',array(
		'adminurl'     		=> admin_url().'admin-ajax.php',
		));
	
}
add_action('admin_enqueue_scripts','xoo_wl_admin_enqueue');


//Settings page
function xoo_wl_menu_settings(){
	add_menu_page( 'Wait List Settings', 'Wait List', 'manage_options', 'xoo_waitlist', 'xoo_wl_settings_cb', 'dashicons-list-view', 60 );

	add_submenu_page( 'xoo_waitlist', 'Settings', 'Settings', 'manage_options', 'xoo_waitlist', 'xoo_wl_settings_cb');

	add_submenu_page( 'xoo_waitlist', 'View Waitlist', 'View Waitlist', 'manage_options', 'xoo_waitlist_view', 'xoo_view_wl_settings_cb');
	add_action('admin_init','xoo_wl_settings');
}
add_action('admin_menu','xoo_wl_menu_settings');

//Settings callback function
function xoo_wl_settings_cb(){
	include plugin_dir_path(__FILE__).'xoo-wl-settings.php';
}

//Custom settings
function xoo_wl_settings(){

	//==== MAIN || Register Settings ==== //

	/*General Options*/
	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-enguest'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-enmail'
	);


	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-enqty'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-enshop'
	);


	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-bntxt'
	);

	/* Style Options */
	register_setting(
		'xoo-wl-group',
 		'xoo-wl-sy-posi'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-sy-anim'
	);

	//========//

	//==== EMAIL || Register Settings ==== //

	/*General Options*/
	register_setting(
		'xoo-wl-group',
 		'xoo-wl-emgl-frem'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-emgl-frnm'
	);

	/*Style Options*/
	register_setting(
		'xoo-wl-group',
 		'xoo-wl-emsy-logo'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-emsy-align'
	);


	//========//

	//==== MAIN || Section Settings ==== //

	add_settings_section(//General Section
		'xoo-wl-gl-main',
		'',
		'xoo_wl_gl_main_cb',
		'xoo_waitlist'
	);

	add_settings_section(//Style Section
		'xoo-wl-sy-main',
		'',
		'xoo_wl_sy_main_cb',
		'xoo_waitlist'
	);

	
	add_settings_section(//End Main settings Section
		'xoo-wl-end-main',
		'',
		'xoo_wl_end_main_cb',
		'xoo_waitlist'
	);
	//========//

	//==== EMAIL || Section Settings ==== //
	add_settings_section(//General Section
		'xoo-wl-gl-email',
		'',
		'xoo_wl_gl_email_cb',
		'xoo_waitlist'
	);

	add_settings_section(//Style Section
		'xoo-wl-sy-email',
		'',
		'xoo_wl_sy_email_cb',
		'xoo_waitlist'
	);

	add_settings_section(//End Email settings Section
		'xoo-wl-end-email',
		'',
		'xoo_wl_end_email_cb',
		'xoo_waitlist'
	);
	//========//

	//==== ADVANCED || Section Settings ==== //


	add_settings_section(//Begin End Advanced Settings
		'xoo-wl-adv',
		'',
		'xoo_wl_adv_cb',
		'xoo_waitlist'
	);


	//========//



	//==== HOW TO || Section Settings ==== //

	add_settings_section(//Info Section
		'xoo-wl-io-howto',
		'',
		'xoo_wl_io_howto_cb',
		'xoo_waitlist'
	);

	add_settings_section(//End /how to settings Section
		'xoo-wl-end-howto',
		'',
		'xoo_wl_end_howto_cb',
		'xoo_waitlist'
	);

	//========//
	//==== MAIN || Add Fields ==== //

	/*General Options*/
	add_settings_field(
		'xoo-wl-gl-enguest',
		'Enable Guest',
		'xoo_wl_gl_enguest_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);

	add_settings_field(
		'xoo-wl-gl-enmail',
		'Auto Email',
		'xoo_wl_gl_enmail_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);


	add_settings_field(
		'xoo-wl-gl-enqty',
		'Allow Quantity',
		'xoo_wl_gl_enqty_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);

	add_settings_field(
		'xoo-wl-gl-enshop',
		'Shop Button',
		'xoo_wl_gl_enshop_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);

	add_settings_field(
		'xoo-wl-gl-bntxt',
		'Waitlist Button Text',
		'xoo_wl_gl_bntxt_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);

	/* Style Options*/
	add_settings_field(
		'xoo-wl-sy-posi',
		'Button Position',
		'xoo_wl_sy_posi_cb',
		'xoo_waitlist',
		'xoo-wl-sy-main'
	);

	add_settings_field(
		'xoo-wl-sy-anim',
		'Modal Animation',
		'xoo_wl_sy_anim_cb',
		'xoo_waitlist',
		'xoo-wl-sy-main'
	);



	//========//

	//==== EMAIL || Add Fields ==== //

	/*General Options*/
	add_settings_field(
		'xoo-wl-emgl-frem',
		'From: [Email]',
		'xoo_wl_emgl_frem_cb',
		'xoo_waitlist',
		'xoo-wl-gl-email'
	);

	add_settings_field(
		'xoo-wl-emgl-frnm',
		'From: [Name]',
		'xoo_wl_emgl_frnm_cb',
		'xoo_waitlist',
		'xoo-wl-gl-email'
	);

	/*Style Options*/
	add_settings_field(
		'xoo-wl-emsy-logo',
		'Select Logo',
		'xoo_wl_emsy_logo_cb',
		'xoo_waitlist',
		'xoo-wl-sy-email'
	);

	add_settings_field(
		'xoo-wl-emsy-align',
		'Align Email',
		'xoo_wl_emsy_align_cb',
		'xoo_waitlist',
		'xoo-wl-sy-email'
	);

	//========//

}

/***** Custom Settings Callback *****/

//Main - General Settings callback
function xoo_wl_gl_main_cb(){
	?>

<?php 	/** Settings Tab **/ ?>
	<div class="xoo-tabs">
		<ul>
			<li class="tab-1 active-tab">Main</li>
			<li class="tab-2">Email</li>
			<li class="tab-3">Advanced</li>
			<li class="tab-4">How to?</li>
		</ul>
	</div>

<?php 	/** Settings Tab **/ ?>

	<?php
	$tab = '<div class="main-settings settings-tab settings-tab-active" tab-class ="tab-1">';  //Begin Main settings
	echo $tab.'<h2>General Options</h2>';
}

//Main - Style Settings callback
function xoo_wl_sy_main_cb(){
	echo '<h2>Style Options</h2>';
}

//End Main Settings / Begin Email Settings
function xoo_wl_end_main_cb(){
	$tab  = '</div>'; // End Main Settings
	$tab .= '<div class="email-settings settings-tab" tab-class ="tab-2">';  //Begin Email Settings settings
	echo $tab;
}

//Email - General Settings callback
function xoo_wl_gl_email_cb(){
	echo '<h2>General Options</h2>';
}

//Email - Style Settings callback
function xoo_wl_sy_email_cb(){
	echo '<h2>Style Options</h2>';
}

//End Email Settings // Begin How to
function xoo_wl_end_email_cb(){
	$html   = '<span class="xprev-em xoo-prbtn button">Preview Email</span>';
	$html  .= '</div>'; // End Email Settings
	$html  .= '<div class="advanced-settings settings-tab" tab-class ="tab-3">';
	echo $html;
}

// Begin/End Advanced Settings
function xoo_wl_adv_cb(){
	$html  = '<a class="buy-prem button button-primary button-hero" href="http://xootix.com/plugins/waitlist-for-woocommerce">BUY PREMIUM - 9$</a>';
	$html .= '<div class="prem-disabled">';
	$html .= '<img src="'.plugins_url('/images/1.png',__FILE__).'"/>';
	$html .= '<img src="'.plugins_url('/images/2.png',__FILE__).'"/>';
	$html .= '<img src="'.plugins_url('/images/3.png',__FILE__).'"/>';
	$html .= '<span class="cust-email-note">Customizable Email</span>';
	$html .= '<img src="'.plugins_url('/images/4.png',__FILE__).'"/>';
	$html .= '<img src="'.plugins_url('/images/5.png',__FILE__).'"/>';
	$html .= '<img src="'.plugins_url('/images/6.png',__FILE__).'"/>';
	$html .= '</div>';
	$html .= '</div>'; // End Advanced settings
	$html .= '<div class="howto-settings settings-tab" tab-class ="tab-4">';
	echo $html;
}

//How to - Info settings callback
function xoo_wl_io_howto_cb(){
	?>
	<ol class="xoo-howto-info">
		<li>Set Product status to <b>"Out of Stock"</b>
			<span>
				<img src="<?php echo plugins_url('assets/images/howto-1.png',__FILE__); ?>"/>
			</span>
		</li>
		<hr>
		<li>Join Waitlist</b>
			<span>
				<img src="<?php echo plugins_url('assets/images/howto-2.png',__FILE__); ?>"/>
			</span>
		</li>
		<hr>
		<li>Set Product status to <b>"In Stock"</b>
			<span>
				<img src="<?php echo plugins_url('assets/images/howto-3.png',__FILE__); ?>"/>
			</span>
		</li>

	</ol>
	<?php
}

//End How to settings
function xoo_wl_end_howto_cb(){
	$html = '</div>';
	echo $html;
}


//========================================//
//============ MAIN CALLBACK ============//
//======================================//

 //Enable guest
$xoo_wl_gl_enguest_value = esc_attr(get_option('xoo-wl-gl-enguest','true'));
function xoo_wl_gl_enguest_cb(){
	global $xoo_wl_gl_enguest_value;
	$html  = '<input type="checkbox" name="xoo-wl-gl-enguest" id ="xoo-wl-gl-enguest" value="true"'.checked('true',$xoo_wl_gl_enguest_value,false).'>';
	$html .= '<label for="xoo-wl-gl-enguest">Allow guest users to be in waitlist.(<span style="text-decoration: italic;">If untick , make sure registration is enabled for woocommerce users.</span>)</label>';
	echo $html;
}

//Enable Auto Email
$xoo_wl_gl_enmail_value = esc_attr(get_option('xoo-wl-gl-enmail','true'));
function xoo_wl_gl_enmail_cb(){
	global $xoo_wl_gl_enmail_value;
	$html  = '<input type="checkbox" name="xoo-wl-gl-enmail" id ="xoo-wl-gl-enmail" value="true"'.checked('true',$xoo_wl_gl_enmail_value,false).'>';
	$html .= '<label for="xoo-wl-gl-enmail">Send Email automatically when product is back in stock.</span></label>';
	echo $html;
}


 //Allow Quantity
$xoo_wl_gl_enqty_value = esc_attr(get_option('xoo-wl-gl-enqty','true'));
function xoo_wl_gl_enqty_cb(){
	global $xoo_wl_gl_enqty_value;
	$html  = '<input type="checkbox" name="xoo-wl-gl-enqty" id ="xoo-wl-gl-enqty" value="true"'.checked('true',$xoo_wl_gl_enqty_value,false).'>';
	$html .= '<label for="xoo-wl-gl-enqty">Ask users , how much quantity they need.</label>';
	echo $html;
}

 //Waitlist button on Shop
$xoo_wl_gl_enshop_value = esc_attr(get_option('xoo-wl-gl-enshop','true'));
function xoo_wl_gl_enshop_cb(){
	global $xoo_wl_gl_enshop_value;
	$html  = '<input type="checkbox" name="xoo-wl-gl-enshop" id ="xoo-wl-gl-enshop" value="true"'.checked('true',$xoo_wl_gl_enshop_value,false).'>';
	$html .= '<label for="xoo-wl-gl-enshop">Enable Wait List button on shop  page [Simple Products]</label>';
	echo $html;
}



//Waitlist button text
$xoo_wl_gl_bntxt_value = esc_attr(get_option('xoo-wl-gl-bntxt',__('Join Waitlist','waitlist-woocommerce')));
function xoo_wl_gl_bntxt_cb(){
	global $xoo_wl_gl_bntxt_value;
	$html = '<input type="text" name="xoo-wl-gl-bntxt" id ="xoo-wl-gl-bntxt" value="'.$xoo_wl_gl_bntxt_value.'">';
	$html .= '<label for="xoo-wl-gl-bntxt">Label for waitlist button.</label>';
	echo $html;
}

//Button Position
$xoo_wl_sy_posi_value = esc_attr(get_option(
	'xoo-wl-sy-posi','woocommerce_after_shop_loop_item_title'
	));
function xoo_wl_sy_posi_cb(){
	global $xoo_wl_sy_posi_value;
	?>
	<select name="xoo-wl-sy-posi" class="xoo-wl-input">

		<?php $after_image = 'woocommerce_before_shop_loop_item_title'; ?>
		<option value="<?php echo $after_image ?>" <?php selected($xoo_wl_sy_posi_value,$after_image); ?> >After product image</option>

		<?php $after_title = 'woocommerce_shop_loop_item_title'; ?>
		<option value="<?php echo $after_title ?>" <?php selected($xoo_wl_sy_posi_value,$after_title); ?>>After product title</option>

		<?php $after_price = 'woocommerce_after_shop_loop_item_title'; ?>
		<option value="<?php echo $after_price ?>" <?php selected($xoo_wl_sy_posi_value,$after_price); ?>>After product price</option>

	</select>
	<label for = "xoo-wl-sy-posi">Position of quick view button on shop page.</label>

	<?php
}


//Modal Animation
$xoo_wl_sy_anim_value = esc_attr(get_option('xoo-wl-sy-anim','fade-in'));
function xoo_wl_sy_anim_cb(){
	global $xoo_wl_sy_anim_value;
	?>
	<select name="xoo-wl-sy-anim" class="xoo-wl-input">
		<option value="none" <?php selected($xoo_wl_sy_anim_value,'none'); ?> >None</option>
		<option value="slide-down" <?php selected($xoo_wl_sy_anim_value,'slide-down'); ?> >Slide-Down</option>
		<option value="bounce-in" <?php selected($xoo_wl_sy_anim_value,'bounce-in'); ?> >Bounce-In</option>
		<option value="fade-in" <?php selected($xoo_wl_sy_anim_value,'fade-in'); ?> >Fade-In</option>
	</select>
	<?php
	echo '<label for="xoo-wl-sy-anim">Waitlist Modal (Box) Animation.</label>';
}

//========================================//
//============ EMAIL CALLBACK ===========//
//======================================//

//From email
$xoo_wl_emgl_frem_value = esc_attr(get_option('xoo-wl-emgl-frem','wordpress@example.com'));
function xoo_wl_emgl_frem_cb(){
	global $xoo_wl_emgl_frem_value;
	$html = '<input type="text" name="xoo-wl-emgl-frem" id ="xoo-wl-emgl-frem" value="'.$xoo_wl_emgl_frem_value .'">';
	$html .= '<label for="xoo-wl-emgl-frem">Sender\'s email address.<span class="xoo-required">*</span></label>';
	echo $html;	
}

//From Name
$xoo_wl_emgl_frnm_value = esc_attr(get_option('xoo-wl-emgl-frnm','Wordpress'));
function xoo_wl_emgl_frnm_cb(){
	global $xoo_wl_emgl_frnm_value;
	$html = '<input type="text" name="xoo-wl-emgl-frnm" id ="xoo-wl-emgl-frnm" value="'.$xoo_wl_emgl_frnm_value .'">';
	$html .= '<label for="xoo-wl-emgl-frnm">Sender\'s Name.<span class="xoo-required">*</span></label>';
	echo $html;	
}


//Email Logo
$xoo_wl_emsy_logo_value = esc_attr(get_option('xoo-wl-emsy-logo',plugins_url('logo.png',__FILE__)));
function xoo_wl_emsy_logo_cb(){
	global $xoo_wl_emsy_logo_value;
	$html = '<input type="button" id="xlogo-btn" class="button xoo-prbtn" value="Select">';
	$html .= '<input type="hidden" name="xoo-wl-emsy-logo" id ="xoo-wl-emsy-logo" value="'.$xoo_wl_emsy_logo_value.'">';
	$html .= '<button class="xoo-remove-logo button">X Remove</button>';
	$html .= '<span class="xoo-logo-name"></span>';
	$html .= '<p class="description">Supported format: JPEG,PNG </p>';
	echo $html;	
}

//Email Align
$xoo_wl_emsy_align_value = esc_attr(get_option('xoo-wl-emsy-align','center'));
function xoo_wl_emsy_align_cb(){
	global $xoo_wl_emsy_align_value;
	?>
	<select name="xoo-wl-emsy-align" class="xoo-wl-input">
	<option value="left" <?php selected($xoo_wl_emsy_align_value,'left'); ?> >Left</option>
	<option value="center" <?php selected($xoo_wl_emsy_align_value,'center'); ?> >Center</option>
	</select>
	<?php
}




//View Waitlist Settings

function xoo_view_wl_settings_cb(){
	global $wpdb,$post;

	if(isset($_GET['paginate'])){
		$page_no = (int) (esc_attr($_GET['paginate']));
	}
	else{
		$page_no = 1;
	}

	$offset = ($page_no-1)*10;

	$query = "SELECT * FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value != ''  ORDER BY post_id ASC LIMIT %d , 10";
	$results = $wpdb->get_results(
				$wpdb->prepare($query,array('_xoo-wl-users',$offset)),
				'ARRAY_A'
			  	);

	$per_page_rows = $wpdb->num_rows;

	if($per_page_rows != 0){
		$product_ids = array();
		foreach($results as $product){
			$product_ids[] = $product['post_id'];
		}

	$pdo_space = str_repeat('%s,', count($product_ids) - 1) . '%s';

	$post_query = "SELECT * FROM {$wpdb->posts} WHERE ID IN ($pdo_space)";
	$post_result =  $wpdb->get_results(
						$wpdb->prepare($post_query ,$product_ids),
						'ARRAY_A'
		  			);
	}

	?>

	<div class="view-wl-main">
	<a class="cust-csv-btn button button-primary">Export CSV</a><span class="cust-csv-note description">Export users list in CSV file </span><a href="http://xootix.com/product/woocommerce-waitlist-premium"> (Premium - 9$)</a>
		<table class="wl-results xoo-table">
			<tr>
				<th>Product</th>
				<th>Users in Waitlist</th>
				<th>Total Quantity</th>
				<th>Users List</th>
				<th>Send Email</th>
			</tr>

			<?php
			$tr = '';
			if($per_page_rows === 0){
				echo '<tr><td>Wait List is empty.</td></tr></table>';
				die();
			} 
				$tr_no = 0;
				$users_viewer = '<ul class="users-list">';
				?>
			<?php foreach ($results as $product) {
				$tr_no++;
				$sq_row = $tr_no-1;
				$title = '';
				$post_id = $product['post_id'];
				if($post_result[$sq_row]['post_type'] == 'product_variation'){
					$variation = new WC_Product_variation($post_result[$sq_row]['ID']);
					$title .= $variation->get_title();
					$title .= $variation->get_formatted_variation_attributes();
				}else{
					$title = $post_result[$sq_row]['post_title'];
				}
				$tr .= '<tr>';
				$tr .= '<td>'.$title.'</td>';
				$users = json_decode($product['meta_value'],true);	
				$total_qty = 0;
				$total_users = 0;

				//Html for each product (Users list)
				$pt_html  = '<div class="xpt-pname">'.$title.'</div><hr>';
				$pt_html .= '<table class="xoo-table xpt-table">';
				$pt_html .= '<th>#</th>';
				$pt_html .= '<th>User Email</th>';
				$pt_html .= '<th>Quantity</th>';
				$pt_html .= '<th>Remove</th>';
				$sno = 0;
				foreach ($users as $email => $qty) {
					$sno++;
					$qty = (int) $qty;
					$total_qty = $total_qty + $qty;
					$total_users++;
					$pt_html .= '<tr class="xpt-tr">';
					$pt_html .= '<td>'.$sno.'</td>';
					$pt_html .= '<td class="xpt-em-id">'.esc_attr($email).'</td>';
					$pt_html .= '<td>'.$qty.'</td>';
					$pt_html .= '<td><span class="dashicons dashicons-trash xpt-rem-em"></span></td>';
					$pt_html .= '</tr>';
				}
				$pt_html .= '</table>';
				$tr .= '<td>'.$total_users.'</td>';
				$tr .= '<td>'.$total_qty.'</td>';
				$tr .= '<td><a class="users_list_id" href="#" xwlu-id ='.$tr_no.'><span class="dashicons dashicons-visibility"></span></a></td>';
				$tr .= '<td><a class="send_email xwl-sem" href="#" xwl-pid ='.$post_result[$sq_row]['ID'].'>Send</a></td>';
				$tr .= '</tr>';
				$users_viewer .= '<li style="display: none;" class="product-row-'.$tr_no.' xpt-emlist" data-pid='.$post_result[$sq_row]['ID'].'>'.$pt_html.'</li>';
			}

			$users_viewer .= '</ul>';
			echo $tr;

			?>
		</table>
	</div>
	<div class="product-viewer-opac" style="display: none;"></div>
	<div class="product-viewer-cont" style="display: none;">
		<div class="product-viewer">
			<span class="pv-close">X</span>
			<?php echo $users_viewer; ?>		
		</div>
	</div>
	<?php

	$query_total = "SELECT * FROM {$wpdb->postmeta} WHERE meta_key = '_xoo-wl-users' ";
	$wpdb->query($query_total);
	$total_rows = $wpdb->num_rows;
	
	if($total_rows > 10){
		echo '<div class="page-numbers">';
		for ($i=1; $i < ($total_rows/10)+1; $i++) { 
			$html = '<a href="'.$_SERVER["REQUEST_URI"].'&paginate='.$i.'">';
			$html .= '['.$i.']';
			$html .= '</a>';
			echo $html;
		}
		echo '</div>';
	}
	?>
	<div class="xoo-wl-sidebar">Need Help? Use <a href="http://xootix.com/product/woocommerce-waitlist-premium">Live Chat</a><br>
	<a href="http://xootix.com" class="xoo-more-plugins">Try other awesome plugins.</a>
	</div>
<?php } ?>