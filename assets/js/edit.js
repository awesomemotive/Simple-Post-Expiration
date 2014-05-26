jQuery(document).ready(function($) {

	var previous = $('#pw-spe-expiration').val();

	$('#pw-spe-expiration').datepicker({
		dateFormat: 'yy-mm-dd'
	});

	$('#pw-spe-edit-expiration, .pw-spe-hide-expiration').click(function(e) {

		e.preventDefault();

		var date = $('#pw-spe-expiration').val();

		if( $(this).hasClass('cancel') ) {

			$('#pw-spe-expiration').val( previous );

		} else if( date ) {

			$('#pw-spe-expiration-label').text( $('#pw-spe-expiration').val() );

		}

		$('#pw-spe-expiration-field').slideToggle();

	});
});