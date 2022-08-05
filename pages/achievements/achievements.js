function achievements_first_to_level {
	u = "#achievements_first_to_level";
	entire_query = "?a=achievements&first_to_level=" + "&v_ajax";
	$.get(entire_query, function (data) {
		$(u).html(data);
	});
}