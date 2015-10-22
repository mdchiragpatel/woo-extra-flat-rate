jQuery( function() {
	jQuery('.wc_extra_flat_rates .remove_tax_rates').click(function() {
		var $tbody = jQuery('.wc_extra_flat_rates').find('tbody');
		if ( $tbody.find('tr.current').size() > 0 ) {
			$current = $tbody.find('tr.current');
			$current.find('input').val('');
			$current.find('input.remove_flat_rate').val('1');

			$current.each(function(){
				if ( jQuery(this).is('.new') )
					jQuery(this).remove();
				else
					jQuery(this).hide();
			});
		} else {
			alert('No row(s) selected');
		}
		return false;
	});



	jQuery('.wc_extra_flat_rates .insert').click(function() {
		var $tbody = jQuery('.wc_extra_flat_rates').find('tbody');
		var size = $tbody.find('tr').size();
		
		var code = '<tr class="new">\
				<td width="4%" class="sort"></td>\
				<td class="name" width="48%">\
					<input type="text" name="extra_flat_rate_name[new-' + size + ']" />\
				</td>\
				<td class="rate" width="48%">\
					<input type="number" step="any" min="0" placeholder="0" name="extra_flat_rate[new-' + size + ']" />\
				</td>\
			</tr>';
		 
		if ( $tbody.find('tr.current').size() > 0 ) {
			$tbody.find('tr.current').after( code );
		} else {
			$tbody.append( code );
		}

		return false;
	});
});