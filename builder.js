jQuery(function() {
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