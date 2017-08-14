<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
  return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Back in stock</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <style type="text/css">
  
  /* CLIENT-SPECIFIC STYLES ------------------- */
  
  #outlook a {
    padding: 0; /* Force Outlook to provide a "view in browser" message */
  } 
  
  .ReadMsgBody {
    width: 100%; /* Force Hotmail to display emails at full width */
  } 
  
  .ExternalClass {
    width:100%; /* Force Hotmail to display emails at full width */
  }
  
  .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
    line-height: 100%; /* Force Hotmail to display normal line spacing */
  }
  
  body, table, td, a { /* Prevent WebKit and Windows mobile changing default text sizes */
    -webkit-text-size-adjust: 100%;
    -ms-text-size-adjust: 100%;
  }
  
  table, td { /* Remove spacing between tables in Outlook 2007 and up */
    mso-table-lspace: 0pt;
    mso-table-rspace:0pt;
  }
  
  img { /* Allow smoother rendering of resized image in Internet Explorer */
    -ms-interpolation-mode: bicubic;
  }

  /* RESET STYLES --------------------------- */
  
  body { 
    height: 100% !important;
    margin: 0;
    padding: 0;
    width: 100% !important;
  }
  
  img { 
    border: 0;
    height: auto;
    line-height: 100%;
    outline: none;
    text-decoration: none;
  }
  
  table {
    border-collapse: collapse!important;
  }

  /* iOS BLUE LINKS */
  
  .apple-links a { 
    color: #999999;
    text-decoration: none;
  }

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
</head>
<body style="margin: 0; padding: 0">
  <table cellpadding="0" border="0" cellspacing="0" width="100%">
    <tr>
      <td align="<?php echo $xoo_wl_emsy_align_value; ?>" bgcolor="#ffffff" style="padding: 20px 0 20px 0;">
        <table cellpadding="0" cellspacing="0" width="600" class="xoo-em-wrapper">
          <?php echo $logo; ?>
          <tr>
            <td style="color: #C75471; font-weight: bold; font-size: 19px; padding: 15px 0 15px 0;" align="center"><?php _e('Your Product is Now In Stock.','waitlist-woocommerce'); ?></td>
          </tr>
          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"">
                <tr>
                  <td>
                    <table width="35%" class="xoo-em-wrapper" align="right">
                      <tr>
                        <td>
                          <img height="200" width="200"  border="0" alt="Product Image" src="<?php echo $product_image;  ?>" style="display: block; margin-left: auto; margin-right: auto;" class="xoo-em-pimg"/>
                        </td>
                      </tr>
                    </table>

                    <table width ="63%" class="xoo-em-wrapper" align="left">
                      <tr>
                      <?php $product_link_a = '<a href="'.$product_link.'">'.$product_name.'</a>' ?>

                        <td style="vertical-align: baseline; padding: 10px 0 0 10px; font-family: Arial"><?php printf(__('You requested to be notified when %s was back in stock and available for order.','waitlist-woocommerce'),$product_link_a) ?><br><br>
                        <?php _e('We are extremely pleased to announce that the product is now available for purchase. Please act fast, as the item may only be available in limited quantities.','waitlist-woocommerce'); ?></td>
                      </tr>
                      <tr>
                        <td style="padding-top: 15px;" align="center">
                          <a href="<?php echo $product_link; ?>" style="border-radius:3px;color:#ffffff;text-decoration:none;background-color:#00a63f;border-top:14px solid #00a63f;border-bottom:14px solid #00a63f;border-left:14px solid #00a63f;border-right:14px solid #00a63f;display:inline-block;border-radius:3px; font-weight: bold;" target="_blank"><?php _e('BUY NOW','waitlist-woocommerce'); ?></a>
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
</body>
</html>