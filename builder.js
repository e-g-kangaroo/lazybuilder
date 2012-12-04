jQuery(function() {
    jQuery('#migrations ul li a[href=#]').click(function(){
		jQuery.ajax({
			url: ajaxurl,
			data: {
				action: 'migration_file_read',
				file: jQuery(this).attr('id')
			},
			type: 'post',
			dataType: 'json',
			success: function(json){
				alert(json.categories);
				alert(json.tags);
				alert(json.regions);
				alert(json.pages);
			}
		});

        return false;
    });
});