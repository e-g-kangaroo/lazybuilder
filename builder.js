jQuery(function() {
	draw_modification(jQuery('#builder_num').val(), 'up');

	jQuery('#lazy_builder_up').click(function () {
		jQuery.ajax({
			url: ajaxurl,
			data: {
				action: 'lazy_builder_up',
			},
			type: 'post',
			dataType: 'json',
			success: function(json){
				alert(json);
			}
		});

        return false;
	});

	jQuery('#lazy_builder_down').click(function () {
		jQuery.ajax({
			url: ajaxurl,
			data: {
				action: 'lazy_builder_down',
			},
			type: 'post',
			dataType: 'json',
			success: function(json){
				alert(json);
			}
		});

        return false;
	});
});

function draw_modification(num, type) {
	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'lazy_builder_dry_run',
			num: num,
			type: type
		},
		type: 'post',
		dataType: 'json',
		success: function(html){
			jQuery('#details ul').html(html);
		},
		error: function(error) {
			jQuery('#details ul').html(error);
		}
	});
}