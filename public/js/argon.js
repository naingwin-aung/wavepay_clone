//
// Navbar collapse
//

var NavbarCollapse = (function() {

	// Variables
	var navbar_menu_visible = 0;

	$( ".sidenav-toggler" ).click(function() {
		if(navbar_menu_visible == 1){
		  $('body').removeClass('nav-open');
			navbar_menu_visible = 0;
			$('.bodyClick').remove();
		} else {
			var div = '<div class="bodyClick"></div>';
			$(div).appendTo('body').click(function() {
				 $('body').removeClass('nav-open');
					navbar_menu_visible = 0;
					$('.bodyClick').remove();
			 });

		 $('body').addClass('nav-open');
			navbar_menu_visible = 1;
		}

	});

})();