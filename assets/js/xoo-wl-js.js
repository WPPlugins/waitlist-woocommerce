jQuery(document).ready(function($){


	//waitlist Button
	$('.xoo-wl-btn').on('click',function(e){
		e.preventDefault();
		$('.xoo-wl-success , .xoo-wl-error').empty().hide();
		var product_id = $(this).attr('xwl-id');
		$('.xwl-form-id').val(product_id);
		$('.xoo-wl-opac , .xoo-wl-modal , .xoo-wl-main').show();
		
		if(xoo_wl_localize.animation == 'slide-down' || xoo_wl_localize.animation == 'bounce-in'){
			var inmodal_height = ($(window).height())/2 + ($('.xoo-wl-inmodal').height())/2;
			$('.xoo-wl-inmodal').css('top',-inmodal_height);
		}		
		
	})

	//Close Waitlist
	$('.xoo-wl-close').on('click',function(){
		$('.xoo-wl-opac , .xoo-wl-modal').hide();
		$('.xoo-wl-success , .xoo-wl-error').empty().hide();
		
	})


	//WooCommerce Product Variation on select
	$('form.variations_form').on( 'change', '.variations select', function(){
		var _this = $(this);
		var var_form = _this.parents('form.variations_form')
		var wl_btn = var_form.parent().find('.xoo-wl-btn');
		$('.xoo-wl-smodal').hide();
		var variation_id = var_form.find( 'input[name="variation_id"]' ).val();
		var xoo_wl_variations = $('.xoo-wl-var').data('xoo_wl_var');
		
		$.each(xoo_wl_variations,function(key,value){
			if(value == variation_id){
				wl_btn.show().attr('xwl-id',value);
				return false;
			}
			else{
				wl_btn.hide().attr('xwl-id',' ');
			}
		})
	})
	
	//Trigger change on page load
	$('body').find('form.variations_form .variations select').trigger('change');

	//Wait list ajax call on submit form.
	$('.xoo-wl-form').on('submit',function(event){
		event.preventDefault();
		var _this = $(this);
		var user_email = _this.find('.xoo-wl-email').val();
		var user_qty_input 	= _this.find('.xoo-wl-qty');
		if(user_qty_input.length === 1){
			var user_qty   	= parseInt(user_qty_input.val()) || 0; 
		}else{
			var user_qty    = 1;
		}
		var product_id = _this.find('.xwl-form-id').val();

		$('.xoo-wl-success , .xoo-wl-error').empty().hide();

		var send_ajax_request = false;
		if(user_email.length == 0){
			$('.xoo-wl-error').html(xoo_wl_localize.e_empty_email);
		}
		else if(user_qty <= 0){
			$('.xoo-wl-error').html(xoo_wl_localize.e_min_qty);
		}
		else{
			send_ajax_request = true;
		}

		if(!send_ajax_request){$('.xoo-wl-error').show(); return;}
		$.ajax({
			url: xoo_wl_localize.adminurl,
			method: 'POST',
			data: {action: 'xoo_wl_add_email',
				   product_id: product_id,
				   user_email: user_email,
				   user_qty: user_qty,
				   security:  xoo_wl_localize.wl_nonce},
		   beforeSend: function(){
		   		_this.parent('.xoo-wl-smain , .xoo-wl-main').addClass('xoo-wl-optive');
		   		$('.xoo-wl-plouter').show();
		   		_this.find('.xoo-wl-submit').prop('disabled',true);
		   },
			success: function(response){
				if(response.success){
					$('.xoo-wl-success').html(response.success).show();
					_this.parent('.xoo-wl-smain , .xoo-wl-main').removeClass('xoo-wl-optive');
					$('.xoo-wl-main').hide();

				}
				else if(response.email_exists){
					$('.xoo-wl-error').html(response.email_exists).show();
				}
				else if(response.email_empty){
					$('.xoo-wl-error').html(response.email_empty).show();
				}
				else if(response.email_invalid){
					$('.xoo-wl-error').html(response.email_invalid).show();
				}
				else if(response.quantity_invalid){
					$('.xoo-wl-error').html(response.quantity_invalid).show();
				}
				else if(response.in_stock){
					$('.xoo-wl-error').html(response.in_stock).show();
				}
				else{
					console.log(response);
				}

				_this.parent('.xoo-wl-main').removeClass('xoo-wl-optive');
		   		$('.xoo-wl-plouter').hide();
		   		_this.find('.xoo-wl-submit').prop('disabled',false);
			}
		})
	})
})