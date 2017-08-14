<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}

global $xoo_wl_emsy_logo_value;
if($xoo_wl_emsy_logo_value){
  $logo  = '<tr>';
  $logo .= '<td align="center" style="padding: 0 0 10px 0">';
  $logo .= '<img height="auto" width="auto" border="0" alt="Product Image" src="'.$xoo_wl_emsy_logo_value.'" style="display: block"/>';
  $logo .= '</td></tr>';
}

?>
<style type="text/css">
/* MOBILE STYLES ------------------------ */

  @media screen and (max-width: 600px){

  table[class="xoo-em-wrapper"]{
    width: 100%!important;
  }
  img[class="xoo-em-pimg"]{
      width: 100%!important;
      max-width: 200px!important;
      max-height: 200px!important;
      height: auto!important;
    }
  }
  
</style>
<table class="email-demo" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="center" bgcolor="#ffffff" style="padding: 20px 0 20px 0;">
			<table cellpadding="0" cellspacing="0" width="600" class="xoo-em-wrapper">
			<?php echo $logo; ?>
				<tr>
					<td style="color: #C75471; font-weight: bold; font-size: 19px; padding: 15px 0 15px 0;" align="center">Your Product is Now In Stock.</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"">
							<tr>
								<td>

                  <table width="35%" class="xoo-em-wrapper" align="right">
                    <tr>
                      <td align="center">
                        <img height="200" width="200" class="xoo-em-pimg" border="0" alt="Product Image" src="<?php echo plugins_url('/product-image.png',__FILE__); ?>" style="display: block; margin-left: auto; margin-right: auto;" align="center" />
                      </td>
                    </tr>
                  </table>

									<table width ="63%" class="xoo-em-wrapper" align="left">
										<tr>
											<td style="vertical-align: baseline; padding: 10px 0 0 10px; font-family: Arial">You requested to be notified when <a href="#">T-Shirt Superman</a> was back in stock and available for order.<br><br>We are extremely pleased to announce that the product is now avaiable for purchase. Please act fast, as the item may only be available in limited quantities.</td>
										</tr>
										<tr>
											<td style="padding-top: 15px;" align="center">
												<a href="#" style="border-radius:3px;color:#ffffff;text-decoration:none;background-color:#00a63f;border-top:14px solid #00a63f;border-bottom:14px solid #00a63f;border-left:14px solid #00a63f;border-right:14px solid #00a63f;display:inline-block;border-radius:3px font-weight: bold;">BUY NOW</a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</html>

