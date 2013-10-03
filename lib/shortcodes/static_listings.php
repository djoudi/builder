<?php
/**
 * Post type/Shortcode to generate a list of listings
 *
 */
include_once(PL_LIB_DIR . 'shortcodes/search_listings.php');

class PL_Static_Listing_CPT extends PL_Search_Listing_CPT {

	protected $shortcode = 'static_listings';

	protected $title = 'List of Listings';

	protected $options = array(
		'context'				=> array( 'type' => 'select', 'label' => 'Template', 'default' => '' ),
		'width'					=> array( 'type' => 'int', 'label' => 'Width', 'default' => 250, 'description' => '(px)' ),
		'height'				=> array( 'type' => 'int', 'label' => 'Height', 'default' => 250, 'description' => '(px)' ),
		'widget_class'	=> array( 'type' => 'text', 'label' => 'CSS Class', 'default' => '', 'description' => '(optional)' ),
		'sort_by_options'		=> array( 'type' => 'multiselect', 'label' => 'Items in "Sort By" list',
			'options'	=> array(	// options we always want to show even if they are not part of the filter set
				'location.address'	=> 'Address',
				'cur_data.price'	=> 'Price',
				'cur_data.sqft'		=> 'Square Feet',
				'cur_data.lt_sz'	=> 'Lot Size',
				'compound_type'		=> 'Listing Type',
				'cur_data.avail_on'	=> 'Available On',
			),
			'default'	=> array('cur_data.price','cur_data.beds','cur_data.baths','cur_data.sqft','location.locality','location.postal'),
		),
		'sort_by'				=> array( 'type' => 'select', 'label' => 'Default sort by', 'options' => array(), 'default' => 'cur_data.price' ),
		'sort_type'				=> array( 'type' => 'select', 'label' => 'Default sort direction', 'options' => array('asc'=>'Ascending', 'desc'=>'Descending'), 'default' => 'desc' ),
		'hide_sort_by'			=> array( 'type' => 'checkbox', 'label' => 'Hide "Sort By" dropdown', 'default' => false ),
		'hide_sort_direction'	=> array( 'type' => 'checkbox', 'label' => 'Hide "Sort Direction" dropdown', 'default' => false ),
		'hide_num_results'		=> array( 'type' => 'checkbox', 'label' => 'Hide "Show # entries" dropdown', 'default' => false ),
		// TODO: sync up with js list
		'query_limit'			=> array( 'type' => 'int', 'label' => 'Number of results to display', 'default' => 10 ),
	);




	public static function init() {
		parent::_init(__CLASS__);
	}

	public function shortcode_handler($atts, $content) {
		add_filter('pl_filter_wrap_filter', array(__CLASS__, 'js_filter_str'));
		$filters = '';

		// call do_shortcode for all pl_filter shortcodes
		// Note: don't leave whitespace or other non-valuable symbols
		if (!empty($content)) {
			$filters = do_shortcode(strip_tags($content));
		}
		$filters = str_replace('&nbsp;', '', $filters);

		$content = PL_Component_Entity::static_listings_entity($atts, $filters);

		return self::wrap('static_listings', $content);
	}
}

PL_Static_Listing_CPT::init();