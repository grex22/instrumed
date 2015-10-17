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
