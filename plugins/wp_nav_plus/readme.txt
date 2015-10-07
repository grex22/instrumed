=== WP Nav Plus ===
Contributors: Matt Keys
Donate link: http://mattkeys.me/
Tags: menu, wp_nav_menu, start_depth, starting_depth, split menu, tertiary menu, secondary menu
Requires at least: 3.0.1
Tested up to: 3.5.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

WP Nav Plus builds upon the power of Wordpress's menu system, adding in the ability to specify a start depth for your menu. This makes it very easy to implement split menus / secondary menus. This plugin is designed to be useful both to non-developers and developers alike.

== Installation ==

Installation and usage video is available online: http://mattkeys.me/products/wp-nav-plus/

1) Install the plugin through the wordpress admin by navigating to: Plugins > click "Add New" at top > click "Upload" > Browse for and select the plugin's ZIP file.
2) Make sure to activate the plugin after installation!

Basic Functionality (using the widget):

* In your wordpress administration area, find the Widgets settings under "Appearance"
* Add the new WP Nav Plus widget into the desired sidebar area
* Select your Menu Name, Start Depth, and Depth. Default settings may already be what you need.

Advanced Functionality (using the function):

* Use the new wp_nav_plus() function wherever you would normally use wp_nav_menu(). For existing templates this is normally found in the header.php and sidebar.php areas.
* The plugin default settings are perfect for most peoples needs, just replace wp_nav_menu with wp_nav_plus in your template.
* If the plugin defaults are not what you need, you can specify your own start_depth like in the following example:

<?php
	wp_nav_plus(array('theme_location' => 'primary_navigation', 'start_depth' => 1, 'depth' => 1));
?>

This code would be used on an interior page and would start the menu off 1 level deep (ignoring the top-levl menu items).


== Changelog ==

= 2.2.5 =
* Fixed a bug that cause the menu to dissapear on post pages when only one category was assigned. In some cases this bug could also produce a PHP error.

= 2.2.4 =
* Set default start_depth to 0
* Fixed a bug that was causing an infinite loop in rare situations where the object id returned results in the postmeta that were not associated with any menu in wp_term_relationships

= 2.2.3 =
* Fixed a bug that was causing the menu to not show then the menu term_id did not match the term_taxonomy_id.

= 2.2.2 =
* Tweaked widget output to make sure that no menu container is shown on the screen when there are no menu items.

= 2.2.1 =
* Tweaked logic to support Gecka Submenu plugin functionality

= 2.2 =
* This release adds widget functionality to WP Nav Plus to make it much easier for non developers to use the power of WP Nav Plus!
* Advanced users can continue to use the wp_nav_plus function in their templates as always

= 2.1 =
* This release includes a couple of bug fixes related to some less common menu configurations, including: multiple menus showing duplicate content, and fixing a couple of PHP notices being shown when the menu was included on pages like the 404 page.
* Fixed bug causing menu not to show on multisite installations
* This release expands the logic/ability of WP Nav Plus to allow users to show 3+ split menu's on a page. Meaning you could have independent menus for 1st level links, 2nd level links, and 3rd level links, all on the same page at once.
* This release also expands the logic/ability of WP Nav Plus to continue showing the menu even after users click into a blog post (something I have not seen another solution do yet)

= 2.0 =
* This release is a complete rethinking and rewrite of WP Nav Plus. Versions 1.x were too dependant on the page structure configured in the wordpress pages admin area.
* Added support for persistant menu on blog post pages (where most other solutions would dissapear)

= 1.1 =
* Fixed a bug that was preventing Custom & Category menu item types from appearing

= 1.0 =
* This is the first public release