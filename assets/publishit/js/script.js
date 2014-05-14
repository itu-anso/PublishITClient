$(function(){
	$('.accContainer').hide();
	//$('.accContainer:first').next().slideDown();	
	$('.accordionHeader').click(function(){
		if($(this).next().is(':hidden')){
			$('.accordionHeader').next().slideUp();
			$(this).next().slideDown();
			}
			return false;
	});

	$('#dialog').dialog({
		autoOpen : false,
		show : true
	});

	$('#upload_button').on('click', function() {
		$('#dialog').dialog('open');
	});

	//$('#upload').on('click', uploadHandler);
});
	
function uploadHandler() {
	var file = $('#upload_file').val();
	if (file != null) {
		var form = $('Form[name="uploadFileForm"]')
		$.ajax({
			url: '',
			method : 'post',
			data : form.serialize()
		});
	}
}