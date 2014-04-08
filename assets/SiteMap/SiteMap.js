function show_settings(event) {
	event.preventDefault();
	pageId = $(event.currentTarget).data("page-id");

	$.ajax({
		type: "POST",
		data: {action: "show_settings", settings_page_id: pageId, form_id: "settings", ajax: "true"},
		success: function(data) {
			$('#site_map').append(data);
			$('#tabs').tabs();
			$('#settings_container').dialog({width: 500});
		}
	});
}

function save_settings(event) {
	event.preventDefault();
	var form = $(event.currentTarget).parent();
	$.ajax({
		type: "POST",
		data: 'ajax=true&' + form.serialize(),
		success: update_site_map(event.currentTarget, form[0])
	});
}

function update_site_map(element, form) {
	var page_title = form[5]['value'];
	var page_id = $(element).data("page-id");
	$('#site_map .list').find('[data-page-id="' + page_id + '"]').text(page_title + " (" + page_id + ")");//.text(form.update_settings_page_title));
}

$(function(){
	$('#site_map .list a').on('click', show_settings);
	$(document).on('click', '.save_settings', save_settings);
});

