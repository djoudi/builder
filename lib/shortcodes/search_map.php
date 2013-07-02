<?php
/**
 * Post type/Shortcode to display Google maps
 *
 */

class PL_Map_CPT extends PL_SC_Base {

	protected static $pl_post_type = 'pl_map';

	protected static $shortcode = 'search_map';

	protected static $title = 'Map';

	protected static $options = array(
		'context'		=> array( 'type' => 'select', 'label' => 'Template', 'default' => ''),
		'width'			=> array( 'type' => 'numeric', 'label' => 'Width(px)', 'default' => 600 ),
		'height'		=> array( 'type' => 'numeric', 'label' => 'Height(px)', 'default' => 400 ),
		'widget_class'	=> array( 'type' => 'text', 'label' => 'Widget Class', 'default' => '' ),
//		'type'			=> array( 'type' => 'select', 'label' => 'Map Type',
//				'options' => array('listings' => 'listings', 'lifestyle' => 'lifestyle', 'lifestyle_polygon' => 'lifestyle_polygon' ),
//				'default' => '' ),
	);

	protected static $template = array(
		'css'			=> array( 'type' => 'textarea', 'label' => 'CSS', 
			'default' => '
/* sample div used to wrap the map plus any addiitonal html */
.my-map {
	float: left;
	border: 1px solid #000;
	padding: 10px;
}
/* line up the drop lists */
.my-map label {
	display: block;
	float: left;
	width: 10em;
}',
			'prompt'	=> '
You can use any valid CSS in this field to customize your HTML, which will also inherit the CSS from the theme.' ),

		'before_widget'	=> array( 'type' => 'textarea', 'label' => 'Add content before the map', 'default' => '<div class="my-map">',
			'prompt'	=> '
You can use any valid HTML in this field and it will appear before the map.
For example, you can wrap the whole map with a <div> element to apply borders, etc, by placing the opening <div> tag in this field and the closing </div> tag in the following field.' ),

		'after_widget'	=> array( 'type' => 'textarea', 'label' => 'Add content after the map', 'default' => '</div>',
			'prompt'	=> '
You can use any valid HTML in this field and it will appear after the map.' ),
	);
}

PL_Map_CPT::init(__CLASS__);
