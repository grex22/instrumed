<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Config\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');



function more_table_classes_tinymce($settings) {
	$new_styles = array(
		array(
			'title' => 'None',
			'value'	=> 'table table-columnify'
		),
		array(
			'title'	=> 'Hover Table',
			'value'	=> 'table table-hover table-columnify',
		),
	);
	$settings['table_class_list'] = json_encode( $new_styles );
	return $settings;
}
add_filter('tiny_mce_before_init', __NAMESPACE__ . '\\more_table_classes_tinymce');


function supplier_survey($atts) {
	if(get_field('approved_supplier_survey','options')):
    return "<hr><h4><a href='".get_field('approved_supplier_survey','options')."' target='_blank'><i class='fa fa-file-pdf-o'></i> Download the Approved Supplier Survey &raquo;</a></h4><hr>";
  endif;
}
add_shortcode( 'suppliersurvey', __NAMESPACE__ . '\\supplier_survey' );



function my_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    ' . __( "<p>Our supplier survey is password protected. To gain access to this form, enter the password below. If you do not have this password, please contact your Instru-med representative.</p>" ) . '
    <p><label for="' . $label . '">' . __( "Password:" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
    </p></form>
    ';
    return $o;
}
add_filter( 'the_password_form', __NAMESPACE__ . '\\my_password_form' );


function the_title_trim($title) {
	$title = attribute_escape($title);
	$findthese = array(
		'#Protected:#',
		'#Private:#'
	);
	$replacewith = array(
		'', // What to replace "Protected:" with
		'' // What to replace "Private:" with
	);
	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}
add_filter('the_title', __NAMESPACE__ . '\\the_title_trim');
