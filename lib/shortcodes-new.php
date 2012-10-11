<?php

/****** 
	This class defines the shortcodes that can be used to access blueprint 
	functionality from any page or post.

	It handles both the implementation of each code in addition to hooking 
	them into the proper events and filters.
******/

PL_Shortcodes::init();
class PL_Shortcodes
{
	public static $codes = array('search_form', 'search_listings', 'prop_details', 'search_map', 'listing_slideshow', 'advanced_slideshow','featured_listings', 'static_listings', 'post_listing');

	public static $p_codes = array(	'search_form' => 'Search Form Shortcode',
									'search_listings' => 'Search Listings Shortcode',
									'prop_details' => 'Property Details Template',
									'search_map' => 'Listings Map Template',
									'listing_slideshow' => 'Listing Slideshow Template',
									'advanced_slideshow' => 'Advanced Slideshow Template',
									'featured_listings' => 'Slideshow Template',
									'static_listings' => 'Slideshow Template',
									'post_listing' => 'Post Listing Template',
								);
	
	// TODO: Construct these lists dynamically by examining the doc hierarchy...
	public static $defaults = array('search_form' 		=> array('twentyten', 'twentyeleven'),
	  				                'search_listings' 		=> array('twentyten', 'twentyeleven'),
	  				                'prop_details' 		=> array('twentyten', 'twentyeleven'),
	  				                'search_map'		=> array('twentyten', 'twentyeleven'),
	  				                'listing_slideshow'	=> array('twentyten', 'twentyeleven'),
	  				                'advanced_slideshow'=> array('twentyten', 'twentyeleven'),
	  				                'featured_listings' => array('twentyten', 'twentyeleven'),
	  				                'static_listings' 	=> array('twentyten', 'twentyeleven'),
	  				                'post_listing' 			=> array('twentyten', 'twentyeleven'),
			               			'listings' 			=> array('twentyten', 'twentyeleven') );

	public static $subcodes = array('search_form'  =>  array('bedrooms',
												            'min_beds',
												            'max_beds',
												            'bathrooms',
												            'min_baths',
												            'max_baths',
												            'price',
												            'half_baths',
												            'property_type',
												            'listing_types',
												            'zoning_types',
												            'purchase_types',
												            'available_on',
												            'cities',
												            'states',
												            'zips',
												            'neighborhood',
												            'county',
												            'min_price',
												            'max_price',
												            'min_price_rental',
	        												'max_price_rental'),
            						'listing'	  =>  array('price',
            												'sqft',
            												'beds',
            												'baths',
            												'half_baths',
            												'avail_on',
            												'url',
            												'address',
            												'locality',
            												'region',
            												'postal',
            												'neighborhood',
            												'county',
            												'country',
            												'coords',
            												'unit',
            												'full_address',
            												'email',
            												'phone',
            												'desc',
            												'image',
            												'mls_id',
            												'map',
            												'listing_type',
            												'gallery',
            												'amenities',
            												'compliance')
            						);

	// TODO: These are a temporary solution, come up with a better convention...
	public static $form_html = false;
	public static $listing = false;
	public static $prop_details_enabled_key = 'pls_prop_details_enabled';

	public function init() 
	{

		//pulls in all the macro shortcodes, static list defined above
		foreach (self::$codes as $shortcode) {
			add_shortcode($shortcode, array(__CLASS__, $shortcode . '_shortcode_handler'));			
		}

		// For any shortcodes that use subcodes, register them to a single handler that bears the shortcode's name
		foreach (self::$subcodes as $code => $subs) {
		  foreach ($subs as $sub) {
			add_shortcode($sub, array(__CLASS__, $code . '_sub_shortcode_handler'));
		  }	
		}

		// Register hooks to customize the html for the wrapper functions
		add_filter('pls_listings_search_form_outer_shortcode', array(__CLASS__, 'searchform_shortcode_context'), 10, 6);
		add_filter('pls_listings_list_ajax_item_html_shortcode', array(__CLASS__, 'listings_shortcode_context'), 10, 3);
		add_filter('property_details_filter', array(__CLASS__, 'prop_details_shortcode_context'), 10, 2);


		// Ensure all of shortcodes are set to some snippet...
		foreach (self::$codes as $code) {
			add_option( ('pls_' . $code), self::$defaults[$code][0] );
		}

		// Handle the special case of turning property details functionality on/off...
		add_option( self::$prop_details_enabled_key, 'false' ); 

		//basically initializes the bootloader object if it's been defined because a
		//shortcode has been called
		add_action('wp_footer', array(__CLASS__, 'init_bootloader'));
		// add_action('after_switch_theme', array(__CLASS__, 'update_shortcode_js'));
	}


	/*** Shortcode Handlers ***/	
	
	public static function search_form_shortcode_handler($atts) {
		$content = PL_Component_Entity::search_form_entity( $atts );
		
		return PL_Shortcode_Wrapper::create( 'search_form', $content );
	}


	public static function listing_slideshow_shortcode_handler ($atts) {
		$content = PL_Component_Entity::listing_slideshow( $atts );
		
		return PL_Shortcode_Wrapper::create( 'listing_slideshow', $content );
		
	}
	public static function advanced_slideshow_shortcode_handler ($atts) {
		$content = PL_Component_Entity::advanced_slideshow_entity( $atts );
		
		return PL_Shortcode_Wrapper::create( 'advanced_slideshow', $content );
	}
	
	public static function featured_listings_shortcode_handler ($atts) {
		$content = PL_Component_Entity::featured_listings_entity( $atts );
		
		return PL_Shortcode_Wrapper::create( 'featured_listings', $content );	
	}
	
	public static function static_listings_shortcode_handler ( $atts ) {
		/* $atts = wp_parse_args($atts, array('limit' => 5));
		ob_start();
			echo pls_get_listings( $atts );
		return ob_get_clean(); */
		$content = PL_Component_Entity::static_listings_entity( $atts );
		
		return PL_Shortcode_Wrapper::create( 'static_listings', $content );
	}
	public static function post_listing_shortcode_handler ( $atts ) {
		// $shortcode = 'listings';
		// self::$listing = $listing;

		// // ob_start();
		// //   echo pls_dump($listing);
		// // return ob_get_clean();

	 //  	$snippet_body = self::get_active_snippet_body($shortcode);
	 //  	return do_shortcode($snippet_body);
	}


	public static function search_listings_shortcode_handler( $atts )
	{
		// Handle attributes using shortcode_atts...
		// These attributes will hand the look and feel of the listing form container, as 
		// the context func applies to each individual listing.
		$content = PL_Component_Entity::search_listings_entity( $atts );
		
		return PL_Shortcode_Wrapper::create( 'search_listings', $content );
	}

	public static function search_map_shortcode_handler( $atts ) {
		$content = PL_Component_Entity::search_map_entity( $atts );
		
		return PL_Shortcode_Wrapper::create( 'search_map', $content );
	}

/*** Context Filter Handlers ***/	

	public static function searchform_shortcode_context($form, $form_html, $form_options, $section_title, $form_data)
	{
		$shortcode = 'search_form';
		self::$form_html = $form_html;

		$snippet_body = self::get_active_snippet_body($shortcode);
		return do_shortcode($snippet_body);
	}

	// It's important to note that this is called for every individual listing...
	public static function listings_shortcode_context($item_html, $listing) 
	{
		$shortcode = 'listings';
		self::$listing = $listing;

	  	$snippet_body = self::get_active_snippet_body($shortcode);
	  	return do_shortcode($snippet_body);
	}

	public static function prop_details_shortcode_context($html, $listing_data) 
	{
		// Check to see if this functionality is enabled...
		$enabled = get_option( self::$prop_details_enabled_key, 'false' );
		
		if ($enabled == 'true') 
		{
			$shortcode = 'prop_details';
			self::$listing = $listing_data;

		  	$snippet_body = self::get_active_snippet_body($shortcode);
		  	return do_shortcode($snippet_body);
	  	}
	  	else 
	  	{
	  		// Simply pass on what was originally sent the filter...
	  		return $html;
	  	}
	}


/*** Sub-Shortcode Handlers ***/

	public static function search_form_sub_shortcode_handler ($atts, $content, $tag) 
	{
		return self::$form_html[$tag];
	}

	public static function listing_sub_shortcode_handler ($atts, $content, $tag) {
		$content = PL_Component_Entity::listing_sub_entity( $atts, $content, $tag );
		
		return PL_Shortcode_Wrapper::create( 'listing_sub', $content );
	}


	/*** Helper Functions ***/

	private static function get_active_snippet_body($shortcode)
	{
		// Get snippet ID currently associated with this shortcode...
		$option_key = ('pls_' . $shortcode);
		$snippet_name = get_option($option_key, self::$defaults[$shortcode][0]);

		// Determine if snippet is custom (in DB) or default (stored in flat-file)
		$snippet_DB_key = ('pls_' . $shortcode . '_' . $snippet_name);
		$type = ( get_option($snippet_DB_key) ? 'custom' : 'default' );

		$snippet_body = PL_Router::load_snippet($shortcode, $snippet_name, $type);
		return $snippet_body;
	}


	public static function init_bootloader () {
		ob_start();
		?>
			<script type="text/javascript">
			jQuery(document).ready(function( $ ) {
				if (typeof bootloader === 'object') {
		  			bootloader.init();
			  	}	
			});
			</script>
		<?php
		echo ob_get_clean();
	}

	function update_shortcode_templates($new_theme) {
			global $did_i_just_change_theme;
	
	}

	function update_shortcode_js ($new_theme) {

		$current_themes = get_themes();
	    $new_theme_info = $current_themes[$new_theme];

		ob_start();
	    ?>
	    	<script type="text/javascript">
	    		console.log(<?php echo json_encode($new_theme_info) ?>);
	    	</script>
	    <?php
	    echo ob_get_clean();		    
	}
}

?>