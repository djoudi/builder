/*
 * Global Definitions
 */

// Usually defined by WordPress, but not in the customizer...
var ajaxurl = 'http://onboard.placester.local/wp-admin/admin-ajax.php';

jQuery(document).ready(function($) {

	/*
	 * Add custom javascript here that applies/affects the customizer as a whole. 
	 * (Configured to execute on any load of customize.php)
	 */

	 /*
	  * Applies to loading default theme options "pallets"
	  */
	 $('#btn_def_opts').live('click', function (event) {
		event.preventDefault();

		if (!confirm('Are you sure you want to overwrite your existing Theme Options?'))
		{ return; }

		var data = { action: 'import_default_options',
					 name: $('#def_theme_opts option:selected').val() }
		// console.log(data);
		
		$.post(ajaxurl, data, function(response) {
		  if (response) {
		  	// console.log(response);
		  }
		  
	      // Refresh theme options to reflect newly imported settings...
	      window.location.reload(true);  
		});
	});

	/*
	 * Handles switching themes in the preview iframe...
	 */
	$('#switch_theme_main #theme_choices').live('change', function (event) {
		console.log($(this).val());
		window.location.href = $(this).val();
	});

	if (wp.customize)
	{ console.log("wp.customize exists..."); }

});	


