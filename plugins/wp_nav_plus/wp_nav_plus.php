<?php
/**
 * @package WP_Nav_Plus
 * @version 2.2.5
 */
/*
Plugin Name: WP Nav Plus
Plugin URI: http://mattkeys.me
Description: This plugin adds the ability to choose a starting depth when displaying a menu in your template. 
It is built upon the wp_nav_menu() function provided with wordpress. Credit and copyright for the wp_nav_menu 
function used here belong to Wordpress
Author: Matt Keys
Version: 2.2.5
Author URI: http://mattkeys.me
*/

/*  Copyright 2013  Matt Keys  (email : me@mattkeys.me)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function wp_nav_plus( $args = array() ) {
	static $menu_id_slugs = array();

	$defaults = array( 'menu' => '', 'container' => 'div', 'container_class' => '', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '',
	'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'start_depth' => 0, 'depth' => 0, 'category_id' => null, 'walker' => '', 'theme_location' => '' );

	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'wp_nav_menu_args', $args );
	$args = (object) $args;

	// Get the nav menu based on the requested menu
	$menu = wp_get_nav_menu_object( $args->menu );

	// Get the nav menu based on the theme_location
	if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
		$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );

	// get the first menu that has items if we still can't find a menu
	if ( ! $menu && !$args->theme_location ) {
		$menus = wp_get_nav_menus();
		foreach ( $menus as $menu_maybe ) {
			if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
				$menu = $menu_maybe;
				break;
			}
		}
	}

	// If the menu exists, get its items.
	if ( $menu && ! is_wp_error($menu) && !isset($menu_items) )
		$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

	/*
	 * If no menu was found:
	 *  - Fallback (if one was specified), or bail.
	 *
	 * If no menu items were found:
	 *  - Fallback, but only if no theme location was specified.
	 *  - Otherwise, bail.
	 */
	if ( ( !$menu || is_wp_error($menu) || ( isset($menu_items) && empty($menu_items) && !$args->theme_location ) )
		&& $args->fallback_cb && is_callable( $args->fallback_cb ) )
			return call_user_func( $args->fallback_cb, (array) $args );

	if ( !$menu || is_wp_error( $menu ) || empty( $menu_items ) )
		return false;

	$current_nav_menu_id = $menu->term_taxonomy_id;
	
	$nav_menu = $items = '';

	$show_container = false;
	if ( $args->container ) {
		$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
		if ( in_array( $args->container, $allowed_tags ) ) {
			$show_container = true;
			$class = $args->container_class ? ' class="' . esc_attr( $args->container_class ) . '"' : ' class="menu-'. $menu->slug .'-container"';
			$id = $args->container_id ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
			$nav_menu .= '<'. $args->container . $id . $class . '>';
		}
	}

	if($args->start_depth > 0) {
		$menu_items = wp_nav_plus_calculateStartDepth( $menu_items, $args->start_depth, $args->category_id, $current_nav_menu_id );
	} 

	// Set up the $menu_item variables
	_wp_menu_item_classes_by_context( $menu_items );

	$sorted_menu_items = array();
	foreach ( (array) $menu_items as $key => $menu_item )
		$sorted_menu_items[$menu_item->menu_order] = $menu_item;

	unset($menu_items);

	$sorted_menu_items = apply_filters( 'wp_nav_menu_objects', $sorted_menu_items, $args );

	$items .= walk_nav_menu_tree( $sorted_menu_items, $args->depth, $args );
	unset($sorted_menu_items);

	// Attributes
	if ( ! empty( $args->menu_id ) ) {
		$wrap_id = $args->menu_id;
	} else {
		$wrap_id = 'menu-' . $menu->slug;
		while ( in_array( $wrap_id, $menu_id_slugs ) ) {
			if ( preg_match( '#-(\d+)$#', $wrap_id, $matches ) )
				$wrap_id = preg_replace('#-(\d+)$#', '-' . ++$matches[1], $wrap_id );
			else
				$wrap_id = $wrap_id . '-1';
		}
	}
	$menu_id_slugs[] = $wrap_id;

	$wrap_class = $args->menu_class ? $args->menu_class : '';

	// Allow plugins to hook into the menu to add their own <li>'s
	$items = apply_filters( 'wp_nav_menu_items', $items, $args );
	$items = apply_filters( "wp_nav_menu_{$menu->slug}_items", $items, $args );

	$nav_menu .= sprintf( $args->items_wrap, esc_attr( $wrap_id ), esc_attr( $wrap_class ), $items );
	unset( $items );

	if ( $show_container )
		$nav_menu .= '</' . $args->container . '>';

	$nav_menu = apply_filters( 'wp_nav_menu', $nav_menu, $args );

	if ( $args->echo )
		echo $nav_menu;
	else
		return $nav_menu;
}

/**
 * If the start_depth argument is set, and the value is greater than 0, this function is called 
 * to do the filtering
 */
if (!function_exists('wp_nav_plus_calculateStartDepth')) {
	function wp_nav_plus_calculateStartDepth( $menu_items, $start_depth, $category_id = null, $current_nav_menu_id ) {

		global $wp_query;
		$start_depth = $start_depth-1;
		$current_object = $wp_query->get_queried_object();
		if(empty($current_object)) {
			return array();
		}

		// FIGURING OUT WHERE WE CURRENTLY ARE IN THE MENU SYSTEM

		$current_object_id = (int) $wp_query->queried_object_id;

		if((isset($wp_query->queried_object->post_type) && $wp_query->queried_object->post_type != 'post') || isset($wp_query->queried_object->cat_ID)) {

			if(isset($wp_query->queried_object->post_parent)) {
				$current_object_parent_id = (int) $wp_query->queried_object->post_parent;
			}
			
			$current_parent_menu_id = null;
			if(isset($current_object_parent_id) && $current_object_parent_id != 0) {
				$current_parent_ancestors = array_reverse(get_ancestors($current_object_parent_id, $wp_query->queried_object->post_type));
				$current_parent_menu_id = wp_nav_plus_calculateMenuID($current_object_parent_id, $current_nav_menu_id, $menu_items, false, null, $current_parent_ancestors, $start_depth);
			}

			$current_menu_id = wp_nav_plus_calculateMenuID($current_object_id, $current_nav_menu_id, $menu_items, false, $current_parent_menu_id);

			// This code is implemented to provide support for Gecka Submenu
			if(empty($current_menu_id)) {
				$current_menu_id = $current_parent_menu_id;
			}

			if(empty($current_menu_id)) {
				return array();
			}

		} else {
			$current_categories = get_the_category($current_object_id);
			$postspage_id = get_option('page_for_posts');
			if(count($current_categories) == 1) {
				$current_menu_id = wp_nav_plus_calculateMenuID($current_categories[0]->term_id, $current_nav_menu_id, $menu_items);
				if(empty($current_menu_id)) {
					$current_menu_id = wp_nav_plus_calculateMenuID($postspage_id, $current_nav_menu_id, $menu_items);
				}
			} else {
				if(!empty($category_id)) {
					$current_menu_id = wp_nav_plus_calculateMenuID($category_id, $current_nav_menu_id, $menu_items);
				} elseif(!empty($postspage_id)) {
					$current_menu_id = wp_nav_plus_calculateMenuID($postspage_id, $current_nav_menu_id, $menu_items);
				} elseif(isset($current_categories[0])) {
					$current_menu_id = wp_nav_plus_calculateMenuID($current_categories[0]->cat_ID, $current_nav_menu_id, $menu_items);
				}
			}

		}
		if(empty($current_menu_id)) {
			return array();
		}
		// WE KNOW WHERE WE ARE NOW, LETS FILTER OUT ALL THE MENU ITEMS THAT WE DON'T WANT TO SHOW

		$ancestors = wp_nav_plus_calculateAncestors($current_menu_id , $menu_items);


		if(isset($ancestors[$start_depth])) {
			$start_level = $ancestors[$start_depth];
		} else {
			$start_level = $current_menu_id;
		}
		$working_menu = $menu_items;
		foreach ( $menu_items as $key => $values) {

			if($values->menu_item_parent == 0) {
				unset($working_menu[$key]);
			} else {

				$this_ancestors = wp_nav_plus_calculateAncestors($values->ID , $menu_items);

				if(empty($this_ancestors[$start_depth])) {
					unset($working_menu[$key]);
				} elseif($this_ancestors[$start_depth] != $start_level) {
					unset($working_menu[$key]);
				}
			}
		}
		return $working_menu;
	}
}

/**
 * Function to get ancestors menu id's (not object ids!)
 */
if (!function_exists('wp_nav_plus_calculateAncestors')) {

	function wp_nav_plus_calculateAncestors($current_menu_id, $menu) {
		$ancestors = array();
		$last_menu_id = $current_menu_id;
		$found_all_ancestors = false;

	    do {
	        foreach ( $menu as $key => $values) {
	 
	            if($values->ID == $last_menu_id) {
	            	if($values->menu_item_parent != 0) {
						$ancestors[] = $values->menu_item_parent;
	            		$last_menu_id = $values->menu_item_parent;
	            	} else {
	            		$found_all_ancestors = true;
	            	}
	            }
	        }
	    } while ($found_all_ancestors == false);

	    return array_reverse($ancestors);

	}
}

/**
 * Retrieve the Menu ID based on the given Object ID
 */
if (!function_exists('wp_nav_plus_calculateMenuID')) {

	function wp_nav_plus_calculateMenuID($object_id, $current_nav_menu_id, $menu, $calc_ancestors = false, $current_parent_menu_id = null, $current_parent_ancestors = null, $start_depth = null) {
		global $wpdb;
		$postmeta = $wpdb->prefix . 'postmeta';
		$term_relationships = $wpdb->prefix . 'term_relationships';
		$post_ids = $wpdb->get_results( "
								SELECT post_id
								FROM $postmeta
								WHERE meta_value = $object_id
								AND meta_key = '_menu_item_object_id'");
		$x=0;
		foreach($post_ids as $val) {
			$post_id = $val->post_id;
			$thismeta = $wpdb->get_results("
									SELECT p.meta_key, p.meta_value, t.term_taxonomy_id
									FROM $postmeta as p, $term_relationships as t
									WHERE p.post_id = $post_id
									AND t.object_id = $post_id ");
			foreach($thismeta as $metavalue) {
				if($metavalue->term_taxonomy_id != $current_nav_menu_id) {
					unset($post_ids[$x]);
					$rekey_needed = true;
				} else {
					if($metavalue->meta_key == '_menu_item_menu_item_parent') {
						$post_ids[$x]->parent_id = $metavalue->meta_value;
					}
					if($metavalue->meta_key == '_menu_item_object_id') {
						$post_ids[$x]->object_id = $metavalue->meta_value;
					}
				}
			}
			$x++;
		}
		foreach($post_ids as $key => $val) {
			if(!property_exists($val, 'parent_id')) {
				unset($post_ids[$key]);
				$rekey_needed = true;
			}
		}
		if(!empty($rekey_needed)) {
			$post_ids = array_values($post_ids);
		}
		if(count($post_ids) == 1) {
			$current_menu_id = $post_ids[0]->post_id;
		} elseif(count($post_ids) > 1 && isset($current_parent_menu_id)) {
			foreach($post_ids as $key => $values) {
				if($values->parent_id == $current_parent_menu_id) {
					$current_menu_id = $values->post_id;
				}
				if(empty($current_menu_id)) {
					$this_ancestors = wp_nav_plus_calculateAncestors($values->parent_id, $menu);
					$this_ancestors = array_flip($this_ancestors);
					if(!empty($this_ancestors) && isset($this_ancestors[$current_parent_menu_id])) {
						$current_menu_id = $values->post_id;
					}
				}
				
			}
		} elseif(!empty($current_parent_ancestors)) {
			$current_menu_id = wp_nav_plus_calculateMenuID($current_parent_ancestors[0], $current_nav_menu_id, $menu);
		}
		if(empty($current_menu_id) && isset($post_ids[0])) {
			foreach($post_ids as $values) {
				if(isset($values->parent_id) && $values->parent_id == 0) {
					$current_menu_id = $values->post_id;
				}
			}
			if(empty($current_menu_id)) {
				$current_menu_id = $post_ids[0]->post_id;
			}
		}

		if(!empty($current_menu_id)) {
			return $current_menu_id;
		}
	}
}

/**
 * Widgetize WP Nav Plus functionality to make it easier to implement for non-developers
 */
class WPNavPlus_Widget extends WP_Widget {

	function WPNavPlus_Widget() {
		parent::__construct( 'wp_nav_plus', 'WP Nav Plus', array( 'description' => __( 'Easily display wordpress menus with a starting depth')) );
	}

	function widget( $args, $instance ) {
		$menu = wp_nav_plus(array('menu' => $instance['menu_term_id'], 'echo' => false, 'container' => false, 'items_wrap' => '%3$s', 'start_depth' => $instance['start_depth'], 'depth' => $instance['depth']));
		if($instance['title']) {
			if(!empty($menu)) { ?>
				<h3 class="wp_nav_plus_title"><?=$instance['title'];?></h3>
			<?php 
			}
		}
		if(!empty($menu)) {
			wp_nav_plus(array('menu' => $instance['menu_term_id'], 'start_depth' => $instance['start_depth'], 'depth' => $instance['depth']));
		}
	}

	function update( $new_instance, $old_instance ) {
		$old_instance['title'] = strip_tags($new_instance['title']);
		$old_instance['menu_term_id'] = strip_tags($new_instance['menu_term_id']);
		$old_instance['start_depth'] = strip_tags($new_instance['start_depth']);
		$old_instance['depth'] = strip_tags($new_instance['depth']);
		return $old_instance;
	}

	function form( $instance ) {
		$menus = get_terms('nav_menu');
		$instance = wp_parse_args((array) $instance, array('title' => '', 'menu_term_id' => '', 'start_depth' => 1, 'depth' => 1));?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title:'); ?></label>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($instance['title']);?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('menu_term_id'); ?>"> <?php _e('Menu Name:'); ?></label>
			<select name="<?php echo $this->get_field_name('menu_term_id'); ?>" id="<?php echo $this->get_field_id('menu_term_id'); ?>">
				<?php
				foreach($menus as $menu)
				{ ?>
					<option value="<?php echo $menu->term_id;?>" <?php selected($menu->term_id, $instance['menu_term_id']);?>><?php _e($menu->name); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('start_depth'); ?>"> <?php _e('Start Depth:'); ?></label>
			<select name="<?php echo $this->get_field_name('start_depth'); ?>" id="<?php echo $this->get_field_id('start_depth'); ?>">
				<?php
				for($x=0;$x<=10;$x++)
				{ ?>
					<option value="<?php echo $x;?>" <?php selected($x, $instance['start_depth']);?>><?php _e($x); ?></option>
				<?php } ?>
			</select>		
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('depth'); ?>"> <?php _e('Depth:'); ?></label>
			<select name="<?php echo $this->get_field_name('depth'); ?>" id="<?php echo $this->get_field_id('depth'); ?>">
				<?php
				for($x=0;$x<=10;$x++)
				{ ?>
					<option value="<?php echo $x;?>" <?php selected($x, $instance['depth']);?>><?php _e($x); ?></option>
				<?php } ?>
			</select>		
		</p>
		<?php
	}
}

function wpnavplus_register_widgets() {
	register_widget( 'WPNavPlus_Widget' );
}

add_action( 'widgets_init', 'wpnavplus_register_widgets' );


?>
