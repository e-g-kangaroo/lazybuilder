jQuery(function() {
	draw_modification(jQuery('#builder_num').val(), jQuery('a.tab.active').attr('id'));

	jQuery('#lazy_builder_up, #lazy_builder_down').live('click', function () {
		var type = jQuery(this).attr('id').replace('lazy_builder_', '');

		jQuery.ajax({
			url: ajaxurl,
			data: {
				action: 'lazy_builder_' + type,
			},
			type: 'post',
			dataType: 'json',
			success: function(building){
				jQuery('.doing_separator').slideUp('fast', function () {

					if (building.id == 0) {
						jQuery('.doing_separator').html('Never doing');
					} else {
						jQuery('.doing_separator').html('Done');
					}
					
					if (building.is_last) {
						jQuery('.doing_separator').prependTo('#buildings ul');
					} else {
						jQuery('.doing_separator').insertAfter('#building_' + ++building.id);
					}

					jQuery('.doing_separator').slideDown();
				});
				
				var id = building.id + 1;
				var zero_padding_id = ('00' + id).slice(-3);
				var title = building.title;
				
				if (building.is_last) {
					id = -1;
					zero_padding_id = 'none';
					title = 'All done';
					jQuery('#details ul').html('');
				} else {
					draw_modification(id, jQuery('a.tab.active').attr('id'));
				}

				jQuery('#builder_num').val(id);
				jQuery('#next_building, #show_builder_id').html(zero_padding_id);
				jQuery('#show_builder_title').html(title);
				
			}
		});

        return false;
	});

	jQuery('a.tab').live('click', function() {
		if (jQuery(this).hasClass('active')) {
			return false;
		}
		
		draw_modification(jQuery('#builder_num').val(), jQuery(this).attr('id'));

		jQuery('a.tab').removeClass('active');
		jQuery(this).addClass('active');

		return false;
	});
	
	jQuery('#buildings ul li a').live('click', function() {
		var id = jQuery(this).attr('id');
		var title = jQuery(this).html();
		
		jQuery('#builder_num').val(id);
		jQuery('#show_builder_id').html( ('00' + id).slice(-3) );
		jQuery('#show_builder_title').html(title);
		draw_modification(id, jQuery('a.tab.active').attr('id'));
		return false;
	});
});

function draw_modification(num, type) {
	jQuery('#details ul').empty();

	if (num == -1) {
		return;
	}

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