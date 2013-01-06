jQuery(function() {
	var lb = {
		'building_files' : {
			'separator' : jQuery('.doing_separator'),
			'move_separetor' : function (id, is_last) {
				var separator = this.separator;

				separator.slideUp('fast', function () {
					if (id == 0) {
						separator.html('Never doing');
					} else {
						separator.html('Done');
					}
					
					if (is_last) {
						separator.prependTo('#buildings ul');
					} else {
						separator.insertAfter('#building_' + (id + 1));
					}

					separator.slideDown();
				});
			}
		},
		'tab' : {
			'change' : function () {
				
			},
			'active' : 'up',
		},
		'refresh' : {
			'modify' : function (num, type) {
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
			},
			'all' : function(num, title, type, is_last) {
				var zero_padding_num = ('00' + num).slice(-3);

				if (is_last) {
					num = -1;
					zero_padding_num = 'none';
					title = 'All done';
					jQuery('#details ul').html('');
				} else {
					this.modify(num, type);
				}

				jQuery('#builder_num').val(num);
				jQuery('#next_building, #show_building_id').html(zero_padding_num);
				jQuery('#show_building_title').html(title);
			},
		}
	};

	lb.refresh.modify(jQuery('#builder_num').val(), lb.tab.active);

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
				lb.building_files.move_separetor(building.id, building.is_last);
				lb.refresh.all(building.id + 1, building.title, lb.tab.active, building.is_last);
			}
		});

        return false;
	});

	jQuery('a.tab').live('click', function() {
		if (jQuery(this).hasClass('active')) {
			return false;
		}
		
		lb.refresh.modify(jQuery('#builder_num').val(), jQuery(this).attr('id'));
		lb.tab.active = jQuery(this).attr('id');

		jQuery('a.tab').removeClass('active');
		jQuery(this).addClass('active');

		return false;
	});
	
	jQuery('#buildings ul li a').live('click', function() {
		var id = jQuery(this).attr('id');
		var title = jQuery(this).html();

		lb.refresh.all(id, title, lb.tab.active, false);
		
		return false;
	});
});