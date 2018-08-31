jQuery(document).ready(function(){
	var image_custom_uploader;
	jQuery('#your_image_url_button').on('click', function(e){
		e.preventDefault();

		//If the uploader object has already been created, reopen the dialog
		if (image_custom_uploader) {
			image_custom_uploader.open();
			return;
		}

		//Extend the wp.media object
		image_custom_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});

		//When a file is selected, grab the URL and set it as the text field's value
		image_custom_uploader.on('select', function() {
			attachment = image_custom_uploader.state().get('selection').first().toJSON();
			var url = '';
			url = attachment['url'];
			jQuery('#your_image_url').val(url);
			jQuery( "img#your_image_url_img" ).attr({
				src: url
			});
			jQuery("#your_image_url_button").css("display", "none");
			jQuery("#your_image_url_button_remove").css("display", "block");
		});

		//Open the uploader dialog
		image_custom_uploader.open();
	 });
	jQuery('#your_image_url_button_remove').click(function(e) {
		jQuery('#your_image_url').val('');
		jQuery( "img#your_image_url_img" ).attr({
			src: ''
		});
		jQuery("#your_image_url_button").css("display", "block");
		jQuery("#your_image_url_button_remove").css("display", "none");
	});
 //Category Icon update code
	var image_custom_uploader2;
	jQuery('#category_image_button').click(function(e){
		e.preventDefault();
		//If the uploader object has already been created, reopen the dialog
		if (image_custom_uploader2) {
			image_custom_uploader2.open();
			return;
		}

		//Extend the wp.media object
		image_custom_uploader2 = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});

		//When a file is selected, grab the URL and set it as the text field's value
		image_custom_uploader2.on('select', function() {
			attachment = image_custom_uploader2.state().get('selection').first().toJSON();
			var url = '';
			url = attachment['url'];
			jQuery('#category_image').val(url);
			jQuery( "img#category_image_img" ).attr({
				src: url
			});
			jQuery("#category_image_button").css("display", "none");
			jQuery("#category_image_button_remove").css("display", "block");
		});

		//Open the uploader dialog
		image_custom_uploader2.open();
	});
	jQuery('#category_image_button_remove').click(function(e) {
		jQuery('#category_image').val('');
		jQuery( "img#category_image_img" ).attr({
			src: ''
		});
		jQuery("#category_image_button").css("display", "block");
		jQuery("#category_image_button_remove").css("display", "none");
	});
});