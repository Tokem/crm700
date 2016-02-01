$(document).ready(function(){
	
	if($(".login-box")) {
		
		$("#username").focus(function() {

			$(this).parent(".input-prepend").addClass("input-prepend-focus");

		});

		$("#username").focusout(function() {

			$(this).parent(".input-prepend").removeClass("input-prepend-focus");

		});

		$("#password").focus(function() {

			$(this).parent(".input-prepend").addClass("input-prepend-focus");

		});

		$("#password").focusout(function() {

			$(this).parent(".input-prepend").removeClass("input-prepend-focus");

		});
		
	}
	
});