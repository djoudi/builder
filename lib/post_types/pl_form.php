<?php

PL_Form_CPT::init();

class PL_Form_CPT {

	// Leverage the PL_Form class and it's fields format (and implement below)
	public static $fields = array(
				'field1' => array( 'type' => 'text', 'label' => 'Field 1' ),
				'field2' => array( 'type' => 'select', 'label' => 'Field 2', 'options' => array( 'one' => 'one', 'two' => 'two' ) ),
				'field3' => array( 'type' => 'checkbox', 'label' => 'Field 3' ),
			);

	public function init() {
		add_action( 'init', array( __CLASS__, 'pl_register_form_post_type' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'pl_forms_meta_box' ) );
		add_action( 'save_post', array( __CLASS__, 'pl_forms_meta_box_save' ) );
	}
	
	
	public static function pl_register_form_post_type() {
		$args = array(
				'labels' => array(
						'name' => __( 'Forms', 'pls' ),
						'singular_name' => __( 'pl_form', 'pls' ),
						'add_new_item' => __('Add New Form', 'pls'),
						'edit_item' => __('Edit Form', 'pls'),
						'new_item' => __('New Form', 'pls'),
						'all_items' => __('All Forms', 'pls'),
						'view_item' => __('View Forms', 'pls'),
						'search_items' => __('Search Forms', 'pls'),
						'not_found' =>  __('No forms found', 'pls'),
						'not_found_in_trash' => __('No forms found in Trash', 'pls')),
				'menu_icon' => trailingslashit(PL_IMG_URL) . 'featured.png',
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => false,
				'query_var' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title', 'editor'),
				'taxonomies' => array('category', 'post_tag')
		);
	
		register_post_type('pl_form', $args );
	}
	
	
	
	public static function pl_forms_meta_box() {
		add_meta_box( 'my-meta-box-id', 'Page Subtitle', array( __CLASS__, 'pl_forms_meta_box_cb' ), 'pl_form', 'normal', 'high' );
	}
	
	// add meta box for featured listings- adding custom fields
	public static function pl_forms_meta_box_cb( $post ) {
		$values = get_post_custom( $post->ID );
		
		// get meta values from custom fields
		foreach( self::$fields as $field => $arguments ) {
			$value = isset( $values[$field] ) ? $values[$field][0] : '';

			if( !empty( $value ) && empty( $_POST[$field] ) ) {
				$_POST[$field] = $value;
			}
			$label = empty( $arguments['label'] ) ? '' : $arguments['label'];
			
			echo PL_Form::item($field, array( 'label' => $label, 'type' => $arguments['type'] ), 'POST');
		}

		wp_nonce_field( 'pl_cpt_meta_box_nonce', 'meta_box_nonce' );
		
		PL_Snippet_Template::prepare_template(
				array(
						'codes' => array( 'search_form' ),
						'p_codes' => array(
								'search_form' => 'Search Form'
						)
				)
			);
	}
	
	public static function pl_forms_meta_box_save( $post_id ) {
		// Avoid autosaves
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
		// Verify nonces for ineffective calls
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'pl_cpt_meta_box_nonce' ) ) return;
	
		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;
	
		foreach( self::$fields as $field => $values ) {
			if( !empty( $_POST[$field] ) ) {
				update_post_meta( $post_id, $field, $_POST[$field] );
			}
		}
	}
}