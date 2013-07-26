<?php
/**
 * Post type/Shortcode to generate a list of listings
 *
 */
include_once(PL_LIB_DIR . 'shortcodes/search_listings.php');

class PL_Static_Listing_CPT extends PL_Search_Listing_CPT {

	protected $pl_post_type = 'static_listings';

	protected $shortcode = 'static_listings';

	protected $title = 'List of Listings';

	protected $help =
		'<p>
		You can insert your Static Listings snippet by using the [static_listings id="<em>listingid</em>"] shortcode in a page or a post.
		The shortcode requires an ID parameter of the static listing ID number published in your
		Featured Listings post type control on the left side of the admin panel.
		</p>';

	protected $options = array(
		'context'				=> array( 'type' => 'select', 'label' => 'Template', 'default' => ''),
		'width'					=> array( 'type' => 'numeric', 'label' => 'Width(px)', 'default' => 250 ),
		'height'				=> array( 'type' => 'numeric', 'label' => 'Height(px)', 'default' => 250 ),
		'widget_class'			=> array( 'type' => 'text', 'label' => 'Widget Class', 'default' => '' ),
		'sort_by_options'		=> array( 'type' => 'multiselect', 'label' => 'Items in "Sort By" list', 
			'options'	=> array(	// options we always want to show even if they are not part of the filter set
				'location.address'	=> 'Address', 
				'cur_data.price'	=> 'Price',
				'cur_data.sqft'		=> 'Square Feet',
				'cur_data.lt_sz'	=> 'Lot Size',
				'compound_type'		=> 'Listing Type',
				'cur_data.avail_on'	=> 'Available On',
			),
			'default'	=> array('cur_data.price','cur_data.beds','cur_data.baths','location.locality'), 
		),
		'sort_by'				=> array( 'type' => 'select', 'label' => 'Default sort by', 'options' => array(), 'default' => 'cur_data.price' ),
		'sort_type'				=> array( 'type' => 'select', 'label' => 'Default sort direction', 'options' => array('asc'=>'Ascending', 'desc'=>'Descending'), 'default' => 'desc' ),
		'hide_sort_by'			=> array( 'type' => 'checkbox', 'label' => 'Hide "Sort By" dropdown', 'default' => false ),
		'hide_sort_direction'	=> array( 'type' => 'checkbox', 'label' => 'Hide "Sort Direction" dropdown', 'default' => false ),
		'hide_num_results'		=> array( 'type' => 'checkbox', 'label' => 'Hide "Show # entries" dropdown', 'default' => false ),
		// TODO: sync up with js list			
		'query_limit'			=> array( 'type' => 'numeric', 'label' => 'Number of results to display', 'default' => 10 ),
	);




	public static function init() {
		parent::_init(__CLASS__);
	}
}

PL_Static_Listing_CPT::init();