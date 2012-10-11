<?php

/**
 * Entity functions to be used for shortcodes/widgets/frames
 *
 */

class PL_Component_Entity {

	public static function featured_listings_entity( $atts ) {
		wp_register_script( 'modernizr', trailingslashit( PLS_JS_URL ) . 'libs/modernizr/modernizr.min.js' , array(), '2.6.1');
		wp_enqueue_script( 'modernizr' );
		$atts = wp_parse_args($atts, array('limit' => 5, 'featured_id' => 'custom', 'context' => 'shortcode'));
		ob_start();

		if( isset( $atts['featured_listing_id'] ) ) {
			add_filter( $atts['context'] . '_partial_get_listings', array( __CLASS__, 'partial_one' ), 10, 2 );
			echo pls_get_listings( $atts );
		} else if( isset( $atts['static_listing_id'] ) ) {
			PL_Component_Entity::print_filters( $atts['static_listing_id'] );
			echo PLS_Partials::get_listings_list_ajax('table_id=placester_listings_list'); 
		}
		
		return ob_get_clean();
	}
	
	public static function search_listings_entity( $atts ) {
		ob_start();
		?>
			  	<script type="text/javascript">
				  	if (typeof bootloader !== 'object') {
						var bootloader;
					}
				  jQuery(document).ready(function( $ ) {
		
				  	if (typeof bootloader !== 'object') {
				  		bootloader = new SearchLoader();
				  		bootloader.add_param({list: {context: "shortcode"}});
				  	} else {
				  		bootloader.add_param({list: {context: "shortcode"}});
				  	}
				  });
				</script>
		
		
			  	<?php
			    PLS_Partials_Get_Listings_Ajax::load(array('context' => 'shortcode'));
			  return ob_get_clean();  
	}
	
	public static function search_map_entity( $atts ) {
		ob_start();
	?>
	 <script type="text/javascript">
    	jQuery(document).ready(function( $ ) {
    		
    		var map = new Map (); 
    		// var filter = new Filters ();
    		var listings = new Listings ({
    			map: map
    			// filter: filter,
    		});
            
            var status = new Status_Window ({map: map, listings:listings});
            
            map.init({
                // type: 'lifestyle',
                // type: 'lifestyle_polygon',
                // type: 'neighborhood',
                type: 'listings',
                // lifestyle: lifestyle,
                listings: listings,
                // lifestyle_polygon: lifestyle_polygon,
                status_window: status
            });

    		listings.init();
    		
    	});
    </script>

	<?php
	    echo PLS_Map::listings( null, array('width' => 600, 'height' => 400) );
	  	return ob_get_clean();  
	}
	
	public static function advanced_slideshow_entity( $atts ) {
		$atts = wp_parse_args($atts, array(
			'animation' => 'fade', 									// fade, horizontal-slide, vertical-slide, horizontal-push
			'animationSpeed' => 800, 								// how fast animtions are
			'timer' => true,											// true or false to have the timer
			'pauseOnHover' => true,									// if you hover pauses the slider
			'advanceSpeed' => 5000,									// if timer is enabled, time between transitions
			'startClockOnMouseOut' => true,					// if clock should start on MouseOut
			'startClockOnMouseOutAfter' => 1000,		// how long after MouseOut should the timer start again
			'directionalNav' => true, 							// manual advancing directional navs
			'captions' => true, 										// do you want captions?
			'captionAnimation' => 'fade', 					// fade, slideOpen, none
			'captionAnimationSpeed' => 800, 				// if so how quickly should they animate in
			'afterSlideChange' => 'function(){}',		// empty function
			'width' => 610,
			'height' => 320,
			'bullets' => 'false',
			'context' => 'home',
			'featured_option_id' => 'slideshow-featured-listings',
			'listings' => 'limit=5&is_featured=true&sort_by=price'
		));
		ob_start();
		echo PLS_Slideshow::slideshow($atts);
		return ob_get_clean();
	}
	
	public static function listing_sub_entity( $atts, $content, $tag ) {
		$val = '';
		
		if (array_key_exists($tag, self::$listing['cur_data'])) {
			$val = self::$listing['cur_data'][$tag];
		}else if (array_key_exists($tag, self::$listing['location'])) {
			$val = self::$listing['location'][$tag];
		}else if (array_key_exists($tag, self::$listing['contact'])) {
			$val = self::$listing['contact'][$tag];
		}else if (array_key_exists($tag, self::$listing['rets'])) {
			$val = self::$listing['rets'][$tag];
		}
		else {
		}
		
		// This is an example of handling a specific tag in a different way
		// TODO: make this more elegant...
		switch ($tag)
		{
			case 'desc':
				$max_len = @array_key_exists('maxlen', $atts) ? (int)$atts['maxlen'] : 500;
				$val = substr($val, 0, $max_len);
				break;
			case 'image':
				$width = @array_key_exists('width', $atts) ? (int)$atts['width'] : 180;
				$height = @array_key_exists('height', $atts) ? (int)$atts['height'] : 120;
				$val = PLS_Image::load(self::$listing['images'][0]['url'],
						array('resize' => array('w' => $width, 'h' => $height),
								'fancybox' => true,
								'as_html' => true,
								'html' => array('alt' => self::$listing['location']['full_address'],
										'itemprop' => 'image')));
				break;
			case 'gallery':
				ob_start();
				?>
					<div id="slideshow" class="clearfix theme-default left bottomborder">
						<div class="grid_8 alpha">
							<ul class="property-image-gallery grid_8 alpha">
								<?php foreach (self::$listing['images'] as $image): ?>
									<li><?php echo PLS_Image::load($image['url'], 
										                           array('resize' => array('w' => 100, 'h' => 75), 
																   		 'fancybox' => true, 
																   		 'as_html' => false, 
																   		 'html' => array('itemprop' => 'image'))); ?>
									</li>
								<?php endforeach ?>
							</ul>
						</div>
					</div>
				<?php
				$val = ob_get_clean();
				break;
			case 'map':
				$val = PLS_Map::lifestyle(self::$listing, array('width' => 590, 'height' => 250, 'zoom' => 16, 'life_style_search' => true,
																'show_lifestyle_controls' => true, 'show_lifestyle_checkboxes' => true, 
																'lat' => self::$listing['location']['coords'][0], 'lng' => self::$listing['location']['coords'][1]));
				break;
			case 'price':
				$val = PLS_Format::number(self::$listing['cur_data']['price'], array('abbreviate' => false, 'add_currency_sign' => true));
				break;
			case 'listing_type':
				$val = PLS_Format::translate_property_type(self::$listing);
				break;
			case 'amenities':
				$amenities = PLS_Format::amenities_but(&self::$listing, array('half_baths', 'beds', 'baths', 'url', 'sqft', 'avail_on', 'price', 'desc'));
				$amen_type = array_key_exists('type', $atts) ? (string)$atts['type'] : 'list';
				ob_start();
				?>
					<div class="amenities-section grid_8 alpha">
	                    <ul>
	                    	<?php if (is_array($amenities[$amen_type])): ?>
	                    	<?php PLS_Format::translate_amenities(&$amenities[$amen_type]); ?>
			                    <?php foreach ($amenities[$amen_type] as $amenity => $value): ?>
			                        <li><span><?php echo $amenity; ?></span> <?php echo $value ?></li>
			                    <?php endforeach ?>		
	                      	<?php endif ?>
	                    </ul>
	                </div>
				<?php 
				$val = ob_get_clean();
				break;
			  case 'compliance':
			  	ob_start();
			  	PLS_Listing_Helper::get_compliance(array('context' => 'listings', 
	  												     'agent_name' => self::$listing['rets']['aname'] , 
	  												     'office_name' => self::$listing['rets']['oname'], 
	  												     'office_phone' => PLS_Format::phone(self::$listing['contact']['phone'])));
			  	$val = ob_get_clean();
			  	break;
			default:
		}
		
		return $val;
		}
		
		public static function listing_slideshow( $atts ) {
			$atts = wp_parse_args($atts, array(
				'animation' => 'fade', 									// fade, horizontal-slide, vertical-slide, horizontal-push
				'animationSpeed' => 800, 								// how fast animtions are
				'timer' => true,											// true or false to have the timer
				'pauseOnHover' => true,									// if you hover pauses the slider
				'advanceSpeed' => 5000,									// if timer is enabled, time between transitions
				'startClockOnMouseOut' => true,					// if clock should start on MouseOut
				'startClockOnMouseOutAfter' => 1000,		// how long after MouseOut should the timer start again
				'directionalNav' => true, 							// manual advancing directional navs
				'captions' => true, 										// do you want captions?
				'captionAnimation' => 'fade', 					// fade, slideOpen, none
				'captionAnimationSpeed' => 800, 				// if so how quickly should they animate in
				'afterSlideChange' => 'function(){}',		// empty function
				'width' => 610,
				'height' => 320,
				'bullets' => 'false',
				'context' => 'home',
				'featured_option_id' => 'slideshow-featured-listings',
				'listings' => 'limit=5&is_featured=true&sort_by=price'
			));
			ob_start();
			?>
			<style type="text/css">
			.orbit-wrapper .orbit-caption { 
				z-index: 999999 !important;
				margin-top: -113px;
				position: absolute;
				right: 0;
				bottom: 0;
				width: 100%;
			}
			.orbit-caption {
				display: none;
			}
			</style>

			<?php
			echo PLS_Slideshow::slideshow($atts); 
		
			return ob_get_clean();
		}
		
		public static function search_form_entity( $atts ) {
			// Handle attributes using shortcode_atts...
			// Ajax setting as an attr?
			
			// Default form enclosure
			$header = '<form method="post" action="' . esc_url( home_url( '/' ) ) . 'listings" class="pls_search_form_listings">';
			$footer = '</form>';
			wp_register_script( 'modernizr', trailingslashit( PLS_JS_URL ) . 'libs/modernizr/modernizr.min.js' , array(), '2.6.1');
			wp_enqueue_script( 'modernizr' );
			?>
			<script type="text/javascript" src="<?php echo trailingslashit(PLS_JS_URL); ?>scripts/filters.js"></script>
			<script type="text/javascript">
				if (typeof bootloader !== 'object') {
					var bootloader;
				}
	
			  jQuery(document).ready(function( $ ) {
			  	if (typeof bootloader !== 'object') {
			  		bootloader = new SearchLoader();
			  		bootloader.add_param({filter: {context: "shortcode"}});
			  	} else {
			  		bootloader.add_param({filter: {context: "shortcode"}});
			  	}
			  });
			</script>
	
			<?php
			return ( $header . PLS_Partials_Listing_Search_Form::init(array('context' => 'shortcode', 'ajax' => true)) . $footer );
		} 
		
		/**
		 * Helpers
		 */
		
		private static function get_property_ids( $featured_listing_id ) {
			// if( ! is_int( $featured_listing_id ) ) { }
			$values = get_post_custom( $featured_listing_id );
			$property_ids = isset( $values['keatingbrokerage_meta'] ) ? unserialize($values['keatingbrokerage_meta'][0]) : '';
			$pl_featured_listing_meta = isset( $values['pl_featured_listing_meta'] ) ? unserialize($values['pl_featured_listing_meta'][0]) : '';
			$pl_featured_meta_value = empty( $pl_featured_listing_meta ) ? array('listings' => array()) : $pl_featured_listing_meta['featured-listings-type'];
		
			return $pl_featured_meta_value;
		}
		
		private static function print_filters( $static_listing_id ) {
			$static_listings = get_post_meta($static_listing_id, false);
			
			if( ! empty( $static_listings ) && isset( $static_listings['pl_static_listings_option'] ) ) {
				$static_listing_filters = unserialize( $static_listings['pl_static_listings_option'][0] );

				wp_enqueue_script('filters-featured.js', trailingslashit(PLS_JS_URL) . 'scripts/filters.js', array('jquery'));l
				?>
					<script type="text/javascript">

					  jQuery(document).ready(function( $ ) {
					
					    var list = new List ();
					    var filter = new Filters ();
					    var listings = new Listings ({
					      filter: filter,
					      list: list,
					    });
					
					    filter.init({
					      dom_id : "#pls_search_form_listings",
					      class : ".pls_search_form_listings",
					      list : list,
					      listings : listings
					    });
					
					    list.init({
					      dom_id: '#placester_listings_list',
					      filter : filter,
					      class: '.placester_listings_list',
					      listings: listings,
					      context: 'listings_search',
					    });

					    <?php 
					    	foreach( $static_listing_filters as $top_key => $top_value ) {
								if( is_array( $top_value ) ) {
									foreach( $top_value as $key => $value ) {
										echo 'listings.active_filters.push( { "name": "' . $top_key . '[' .  $key . ']", "value" : "'. $value . '" } );';	
									}
								} else {
									echo 'listings.active_filters.push( { "name": "'. $top_key . '", "value" : "'. $top_value . '" } );';
								}
							} 
						?>
					    listings.init();
					
					  });
					
					</script>
				
				<?php 
			}
		} 

		public static function partial_one( $listing, $featured_listing_id ) {

			$property_ids = PL_Component_Entity::get_property_ids( $featured_listing_id );
			$property_ids = array_flip( $property_ids );
			
			$api_response = PLS_Plugin_API::get_listings_details_list(array('property_ids' => $property_ids));
			//response is expected to be of fortmat api response
			//no addiitonal formatting needed.
			return $api_response;
		}
		
}