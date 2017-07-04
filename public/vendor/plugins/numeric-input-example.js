/* global $ */
/* this is an example for validation and change events */

$.fn.numericInputExample = function () {
	'use strict';

	function format2(n) {
		return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
	}

	var element = $(this),
		footer = element.find('tfoot tr'),
		dataRows = element.find('tbody tr'),
		initialTotal = function () {
			var column, total;
			for (column = 1; column < footer.children().size(); column++) {
				total = 0;
				dataRows.each(function () {
					var row = $(this);
	
					total += parseFloat(row.children().eq(column).text());
					
					//console.log(total)
					format2(total);
					
				});
				//footer.children().eq(column).text(total);
				footer.children().eq(column).text(format2(total));
			};
		};
	element.find('td').on('change', function (evt) {
		var cell = $(this),
			column = cell.index(),
			total = 0;
		if (column === 0) {
			return;
		}
		
		element.find('tbody tr').each(function () {
			var row = $(this);
			total += parseFloat(row.children().eq(column).text());
			//console.log(total)
		});

		if (column === 1 && total > 9000000) {
			$('.alert').show();
			return false; // changes can be rejected
		} else {
			$('.alert').hide();
			//footer.children().eq(column).text(total);
			footer.children().eq(column).text(format2(total));
		}
	}).on('validate', function (evt, value) {
		var cell = $(this),
			column = cell.index();
		if (column === 0) {
			return !!value && value.trim().length > 0;
		} else {
			
			return !isNaN(parseFloat(value)) && isFinite(value);
		}
	});
	initialTotal();
	return this;
};
