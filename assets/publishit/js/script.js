$(function(){
	$( "#accordion" ).accordion({
		collapsible: true,
		active:false
	});

	$( "#search_accordion" ).accordion({
		collapsible: true,
		active: false
	});

	$('#dialog').dialog({
		autoOpen : false,
		show : true,
		modal: true
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
	
	