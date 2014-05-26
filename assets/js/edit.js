jQuery(document).ready(function($) {

	var previous = $('#pw-spe-expiration').val();

	$('#pw-spe-expiration').datepicker({
		dateFormat: 'yy-mm-dd'
	});

	$('#pw-spe-edit-expiration, .pw-spe-hide-expiration').click(function(e) {
		e.preventDefault();

		if( $(this).hasClass('cancel') ) {
			$('#pw-spe-expiration').val( previous );
		}
		$('#pw-spe-expiration-wrap').slideToggle();
	});
});