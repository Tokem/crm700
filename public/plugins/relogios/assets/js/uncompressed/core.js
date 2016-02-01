$(document).ready(function(){
						
	/* ---------- Add class .active to current link  ---------- */
	$('ul.main-menu li a').each(function(){
		
		if($(this).hasClass('submenu')) {
			
			if($($(this))[0].href==String(window.location)) {
				
				$(this).parent().parent().parent().addClass('active');
				
			}
			
		} else {
			
			if($($(this))[0].href==String(window.location)) {
				
				$(this).parent().addClass('active');
				
			}
					
		}		
		
	});
	
	/* ---------- Submenu  ---------- */	
	$('.dropmenu').click(function(e){

		e.preventDefault();

		$(this).parent().find('ul').slideToggle();
	
	});
	
	$('.btn-close').click(function(e){
		e.preventDefault();
		$(this).parent().parent().parent().fadeOut();
	});
	
	$('.btn-minimize').click(function(e){
		e.preventDefault();
		var $target = $(this).parent().parent().next('.box-content');
		if($target.is(':visible')) $('i',$(this)).removeClass('fa fa-chevron-up').addClass('fa fa-chevron-down');
		else 					   $('i',$(this)).removeClass('fa fa-chevron-down').addClass('fa fa-chevron-up');
		$target.slideToggle();
	});
	
	$('.btn-setting').click(function(e){
		e.preventDefault();
		$('#myModal').modal('show');
	});
			
	/* ---------- Acivate Functions ---------- */
	template_functions();
	sparkline_charts();
	charts();
	calendars();
	growlLikeNotifications();
	widthFunctions();
	circle_progess();
	
	
});

/* ---------- Numbers Sepparator ---------- */

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1.$2");
    return x;
}

/* ---------- Template Functions ---------- */		
		
function template_functions(){
	
	
	
	
	/* ---------- ToDo List Action Buttons ---------- */
	
	if($(".todo-list")) {
		
		$(".todo-remove").click(function(){

			$(this).parent().parent().fadeTo("slow", 0.00, function(){ //fade
				$(this).slideUp("slow", function() { //slide up
			    	$(this).remove(); //then remove from the DOM
			    });
			});


			return false;
		});
		
	}
	
	
	
	/* ---------- Disable moving to top ---------- */
	$('a[href="#"][data-top!=true]').click(function(e){
		e.preventDefault();
	});

	/* ---------- Tooltip ---------- */
	$('[rel="tooltip"],[data-rel="tooltip"]').tooltip({"placement":"bottom",delay: { show: 400, hide: 200 }});

	/* ---------- Popover ---------- */
	$('[rel="popover"],[data-rel="popover"]').popover();

	

	

	
				
}

/* ---------- Circle Progess Bars ---------- */

function circle_progess() {
	
	
	
	
}                

      

/* ---------- Calendars ---------- */

function calendars(){
	

	
	
}

/* ---------- Sparkline Charts ---------- */

function sparkline_charts() {
	
	
	
}

/* ---------- Charts ---------- */

function charts() {

}

function growlLikeNotifications() {

}




/* ---------- Page width functions ---------- */

$(window).bind("resize", widthFunctions);

function widthFunctions( e ) {
    var winHeight = $(window).height();
    var winWidth = $(window).width();

	if (winHeight) {
		
		$("#content").css("min-height",winHeight);
		
	}
    
	if (winWidth < 980 && winWidth > 767) {
		
		if($(".main-menu-span").hasClass("col-sm-2")) {
			
			$(".main-menu-span").removeClass("col-sm-2");
			$(".main-menu-span").addClass("col-sm-1");
			
		}
		
		if($("#content").hasClass("col-sm-10")) {
			
			$("#content").removeClass("col-sm-10");
			$("#content").addClass("col-sm-11");
			
		}
							
	} else {
		
		if($(".main-menu-span").hasClass("col-sm-1")) {
			
			$(".main-menu-span").removeClass("col-sm-1");
			$(".main-menu-span").addClass("col-sm-2");
			
		}
		
		if($("#content").hasClass("col-sm-11")) {
			
			$("#content").removeClass("col-sm-11");
			$("#content").addClass("col-sm-10");
		
		}
				
	}

}