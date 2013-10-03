<?php
/**
 * Post type/Shortcode to display neighbourhood search form
 *
 */

class PL_Neighborhood_CPT extends PL_SC_Base {

	protected $pl_post_type = 'pl_neighborhood';

	protected $shortcode = 'search_neighborhood';

	protected $title = 'Neighborhood';

	protected $options = array(
		'context'			=> array( 'type' => 'select', 'label' => 'Template', 'default' => ''),
		'width'				=> array( 'type' => 'text', 'label' => 'Width', 'default' => 250, 'description' => '(px)' ),
		'height'			=> array( 'type' => 'text', 'label' => 'Height', 'default' => 250, 'description' => '(px)' ),
		'widget_class'		=> array( 'type' => 'text', 'label' => 'Widget Class', 'default' => '' ),
	);

	protected $subcodes = array(
		'nb_title'			=> array('help' => ''),
		'nb_featured_image'	=> array('help' => ''),
		'nb_description'	=> array('help' => ''),
		'nb_link'			=> array('help' => ''),
		'nb_map'			=> array('help' => '')
	);

	protected $template = array(
		'snippet_body'	=> array( 'type' => 'textarea', 'label' => 'HTML', 'css' => 'mime_html', 'default' => 'Put subcodes here to build your form...' ),
		'css'			=> array( 'type' => 'textarea', 'label' => 'CSS', 'css' => 'mime_css', 'default' => '' ),
		'before_widget'	=> array( 'type' => 'textarea', 'label' => 'Add content before the template', 'css' => 'mime_html', 'default' => '' ),
		'after_widget'	=> array( 'type' => 'textarea', 'label' => 'Add content after the template', 'css' => 'mime_html', 'default' => '' ),
	);




	public static function init() {
		parent::_init(__CLASS__);
	}

	public static function shortcode_handler($atts, $content) {
		$content = PL_Component_Entity::pl_neighborhood_entity($atts);

		return self::wrap('pl_neighborhood', $content);
	}
}

PL_Neighborhood_CPT::init();
