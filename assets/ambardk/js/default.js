$(function() {
	$('.editable').on('blur', function(e) {
		var editor = CKEDITOR.instances[$(e.currentTarget).attr('id')];
		var editorId = $(e.currentTarget).data('ckeditor_id');
		var moduleId = $(e.currentTarget).data('module_id');
		var data = editor.getData();

		$.ajax({
			type: 'post',
			data: {action: 'save_data', ajax: 'true', ckeditor_id: editorId, data: data, module_id: moduleId}
		});
	});
});

function updateCkeditors() {
	$('.editable').each(function(e) {
		var ckeditor_id = $(this).data('ckeditor_id');
		var editor = CKEDITOR.instances[$(this).attr('id')];
		var element = CKEDITOR.document.getById($(this).attr('id'));
		var ckeditor = this;

		$.ajax({
			type: 'post',
			url: '/ckeditor',
			data: {action: 'get_data', ckeditor_id: ckeditor_id},
			success: function(data) {
				$(ckeditor).html(data);
				return;
			}
		});
	});
}

function is_admin() {
	var retval;
	$.ajax({
		type: 'post',
		url: '/admin/is_admin',
		async: false,
		success: function(data) {
			retval = data;
		}
	});
	return retval;
} // is_admin()

function BrowseServer() {
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '../assets/js/ckfinder';	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.selectActionFunction = SetFileField;
	finder.popup();

	// It can also be done in a single line, calling the "static"
	// popup( basePath, width, height, selectFunction ) function:
	// CKFinder.popup( '../', null, null, SetFileField ) ;
	//
	// The "popup" function can also accept an object as the only argument.
	// CKFinder.popup( { basePath : '../', selectActionFunction : SetFileField } ) ;
	}

	// This is a sample function which is called when a file is selected in CKFinder.
function SetFileField( fileUrl ) {
	document.getElementById( 'xFilePath' ).value = fileUrl;
}

function toggleHide(object) {
	var target =  $(object).data('target');
	$('.' + target).toggle();
}