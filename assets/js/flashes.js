
function flash(type, message) {

	if ($('#ajax-flashes').length > 0) {

		 clear_flash();
		btn_close_flash = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		switch (type) {
			case "sucess":
			msg_flash = "<div class='alert alert-success' role='alert'>"+btn_close_flash+message+"</div>";
			break;
			case "error":
			msg_flash = "<div class='alert alert-danger' role='alert'>"+btn_close_flash+message+"</div>";
			break;
			case "info":
			msg_flash = "<div class='alert alert-info' role='alert'>"+btn_close_flash+message+"</div>";
			break;
			case "warning":
			msg_flash = "<div class='alert alert-warning' role='alert'>"+btn_close_flash+message+"</div>";
			break;
			default:
				case "sucess":
				msg_flash = "<div class='alert alert-success' role='alert'>"+btn_close_flash+message+"</div>";
		}

		return $('#ajax-flashes').append(msg_flash);
	}
	return false;
}


function clear_flash() {
	$('#ajax-flashes').empty();
}

