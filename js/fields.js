(function( $ ) {
	

	var select = $('#dgm-select-term');
	var container = $('#dgm-other-what');
	var input = $('#dgm-other-what input[type="text"]');

	$(document).ready(function() {
		var option = select.find('option:selected');
		console.log(option);
		if (option.text() != 'Muu') {
			input.prop('disabled', true);
		}
	});

	select.change(function(event) {
		
		var option = $(this).find('option:selected');
		console.log(option.text());

		if (option.text() == 'Muu') {
			input.prop('disabled', false);
			input.prop('required', true);
		} else {
			input.prop('disabled', true);
			input.prop('required', false);
			input.val('');
		}
	
	});

	
})(jQuery);