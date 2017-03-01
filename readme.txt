=== Just Post Preview Widget ===
Contributors: aprokopenko
Plugin Name: Just Post Preview Widget for for Wordpress
Author: JustCoded / Alex Prokopenko
Author URI: http://justcoded.com/
Tags: post preview, widget, layouts, developer
Requires at least: 4.0
Tested up to: 4.7.2
Stable tag: trunk
License: GNU General Public License v3

Widget to easy add any post content preview blocks with different layouts, specified in the theme.

== Description ==

This plugin is for developers who need easy to edit the complex layouts and insert different post tile blocks inside the layout,
sidebars or page builders. By default, it has 3 pre-defined layouts; you can rewrite them in your theme or register custom layouts.
Unfortunately the pre-defined layouts have no styles inside. (Because they will be overwritten in the theme 100% anyway).


= Template files =
To overwrite the pre-defined templates, you should create a folder with the name `“just-post-preview”` in the root
of your theme and copy required templates from the `/wp-content/plugins/just-post-preview/layous/` folder.

File names format: `jpp_layout_{layout key}.php`

You can find PHP comments on the top of the demo templates. They help your IDE to show you autocomplete boxes for available variables.

= Adding custom layout =
To add a custom layout, you need to add a new filter hook in your theme functions.php file:

`add_filter('jpp_post_preview_layouts', 'my_post_preview_layouts');
function my_post_preview_layouts($layouts){
	$layouts['my_layout_key'] = 'My custom layout';
	return $layouts;
}`

After that hook you will need to create a template file in the `/path/to/theme/just-post-preview` folder with the name `jpp_layout_my_layout_key.php`.

= That's all! =

FILL FREE TO CONTACT ME IF YOU FIND ANY BUGS/ISSUES!

**ISSUES TRACKER**
The project is also available on github. Please post your issues or feedbacks there.
https://github.com/aprokopenko/just-post-preview

== Installation ==

1. Download, unzip and upload to your WordPress plugins directory
2. Activate the plugin within you WordPress Administration Backend
3. That's it - you can add a new widget now

== Upgrade Notice ==

To upgrade remove the old plugin folder. After than follow the installation steps 1-2. All settings will be saved.

== Screenshots ==

1. Widget edit screenshot
2. Using widget inside the SiteOrigin Page builder plugin

== Changelog ==
= Version 1.1 =
	* New feature: Ability to search without specifying post type (beta)
	* Bug fix: PHP 7+ compatibility fix
= Version 1.0 =
	* Plugin base with 3 pre-defined layouts
	