jQuery(document).ready(function($){

	//Send Email
	$('a.send_email').on('click',function(e){
		e.preventDefault();
		var _this = $(this);
		var row = _this.parents('tr');
		if(_this.hasClass('email-sent') === false){
			_this.html('Sending....');
			var post_id =  _this.attr('xwl-pid');
			$.ajax({
				url: admin_wl_lz.adminurl,
				type: 'POST',
				data: {action: 'xoo_send_email',
					   post_id: post_id
					},
				success: function(response){
					 _this.addClass('email-sent');
					 row.find('td').remove();
					 row.addClass('xem-suc-tr').append('<td colspan="5" class="xem-suc-td">&#10003; Email Sent Successfully.</td>');
				}
			})
		}
	})

	//Remove email id
	$('.xpt-rem-em').on('click',function(){
		var row = $(this).parents('tr');
		var emid = row.find('.xpt-em-id').html();
		var pid = row.parents('li.xpt-emlist').data('pid');
		row.find('td').remove();
		row.append('<td colspan="4">Removing User...</td>');

		$.ajax({
				url: admin_wl_lz.adminurl,
				type: 'POST',
				data: {action: 'xoo_remove_email',
					   emid: emid,
					   pid: pid},
				success: function(response){
					row.find('td').addClass('xem-suc-td').html('&#10003; User removed Successfully.');
				}
		})
	})

	//View Waitlist
	$('td a.users_list_id').on('click',function(){
		var product_row = $(this).attr('xwlu-id');
		$('.product-viewer-cont , .product-viewer-opac').show();
		$('li.product-row-'+product_row).show();
	})

	$('.pv-close').click(function(){
		$('.product-viewer-cont , .product-viewer-opac , .users-list li').hide();
	})

	//Tabs change
	$('.xoo-tabs li').on('click',function(){
		var tab_class = $(this).attr('class').split(' ')[0];
		$('li').removeClass('active-tab');
		$('.settings-tab').removeClass('settings-tab-active');
		$(this).addClass('active-tab');
		var class_c = $('[tab-class='+tab_class+']').attr('class');
		$('[tab-class='+tab_class+']').attr('class',class_c+' settings-tab-active');
	})

	//Preview
	$('.xprev-em').click(function(e){
		e.preventDefault();
		$('.pemail-modal , .pemail-opac').show();
	})

	//Close Preview
	$('.pemail-close').click(function(){
		$('.pemail-modal , .pemail-opac').hide();
	})

	//Hide button position if shop button is disabled
	$('#xoo-wl-gl-enshop').change(function(){
		if($(this).is(':checked')){
			$('select[name=xoo-wl-sy-posi]').prop('disabled',false);
		}
		else{
			$('select[name=xoo-wl-sy-posi]').prop('disabled',true);
		}
	})
	$('#xoo-wl-gl-enshop').trigger('change');

	//Remove Logo
	$('.xoo-remove-logo').click(function(e){
		e.preventDefault();
		$('#xoo-wl-emsy-logo').val('');
		$('.xoo-logo-name').html('');

	})

	//Logo name

	function xoo_logoname(){
		var image_url = $('#xoo-wl-emsy-logo').val();
		if(!image_url){return;}
		var index = image_url.lastIndexOf('/') + 1;
		var image_name = image_url.substr(index);
		$('.xoo-logo-name').html(image_name);
		return image_name;
	}
	xoo_logoname();

	//Valid email
	$('#submit').on('click',function(e){
		var email = $('#xoo-wl-emgl-frem').val();
		var name  = $('#xoo-wl-emgl-frnm').val();
		var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		if(!regex.test(email)){
			alert('Invalid Email Id');
			e.preventDefault();
		}
		else if(name.length < 1){
			alert('Email - From [name] Cannot be empty');
			e.preventDefault();
		}
	})

	
	//Media uploader
	var xoo_media;
	$('#xlogo-btn').on('click',function(e){
		e.preventDefault();
		if(xoo_media){
			xoo_media.open();
			return;
		}
		xoo_media = wp.media.frames.file_frame = wp.media({
			title: 'Select Logo',
			button: {
				text: 'Choose Logo'
			},
			multiple: false
		});

		xoo_media.on('select',function(){
			attachment = xoo_media.state().get('selection').first().toJSON();
			console.log(attachment);
			var allowed_types = ['jpeg','jpg','png'];
			if(allowed_types.indexOf(attachment.subtype) === -1){
				alert('Only jpeg/jpg & png allowed.');
				return false;
			}
			$('#xoo-wl-emsy-logo').val(attachment.url);
			 xoo_logoname();
		})
		xoo_media.open();
	})


})