<?php
global $pagenow, $shortcode_subpages, $submenu_file, $parent_file, $plugin_page;

$post_ID = (int)(!empty($_REQUEST['post'])?$_REQUEST['post']:0);
$post = get_post($post_ID);
$post_type = 'pl_general_widget';
if (!$post) {
  // creating
  $post = get_default_post_to_edit( $post_type, true );
}
if ( $post ) {
  $post_type_object = get_post_type_object( $post_type );
  $post_ID = $post->ID;
} 


$notice = '';
$message = '';
$form_link = 'post.php';
$form_action = 'editpost';
$nonce_action = 'update-post_' . $post_ID;


?>
<div class="wrap">
  <?php echo PL_Helper_Header::pl_subpages('placester_shortcodes', $shortcode_subpages, 'Shortcode Settings'); ?>
  <?php if ( $notice ) : ?>
  <div id="notice" class="error"><p><?php echo $notice ?></p></div>
  <?php endif; ?>
  <?php if ( $message ) : ?>
  <div id="message" class="updated"><p><?php echo $message; ?></p></div>
  <?php endif; ?>
  <form name="post" action="<?php echo $form_link?>" method="post" id="post"<?php do_action('post_edit_form_tag'); ?>>
    <?php wp_nonce_field($nonce_action); ?>
    <input type="hidden" id="hiddenaction" name="action" value="<?php echo esc_attr( $form_action ) ?>" />
    <input type="hidden" id="originalaction" name="originalaction" value="<?php echo esc_attr( $form_action ) ?>" />
    <input type="hidden" id="post_ID" name="post_ID" value="<?php echo esc_attr($post_ID) ?>" />
    <input type="hidden" id="post_type" name="post_type" value="pl_general_widget" />
    <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
        <div id="post-body-content">
          <div id="titlediv">
            <div id="titlewrap">
              <label class="screen-reader-text" id="title-prompt-text" for="title"><?php echo apply_filters( 'enter_title_here', __( 'Enter title here' ), $post ); ?></label>
              <input type="text" name="post_title" size="30" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
            </div>
            <div class="inside">
              <div id="edit-slug-box" class="hide-if-no-js">
              </div>
            </div>
            <?php wp_nonce_field( 'samplepermalink', 'samplepermalinknonce', false );?>
          </div><!-- /titlediv -->
          <div id="normal-sortables" class="meta-box-sortables">
            <?php PL_Router::load_builder_partial('shortcode-create-box.php', array('post'=>$post));?>
          </div>
        </div>
        <div id="postbox-container-1" class="postbox-container">
          <?php
          PL_Router::load_builder_partial('save-box-side.php', array('post'=>$post));
          PL_Router::load_builder_partial('shortcode-preview.php', array('post'=>$post));
          ?>
        </div>
      </div><!-- /post-body -->
    </div>
  </form>
  <div id="ajax-response"></div>
  <br class="clear" />
</div>