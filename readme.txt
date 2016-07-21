=== Just Post Preview Widget ===
Contributors: aprokopenko
Plugin Name: Just Post Preview Widget for for Wordpress
Author: JustCoded / Alex Prokopenko
Author URI: http://justcoded.com/
Tags: post preview, widget, layouts, developer
Requires at least: 4.0
Tested up to: 4.5.2
Stable tag: trunk
License: GNU General Public License v3

Widget to easy add any content preview block with different layouts, specified in the theme.

== Description ==

This plugin is for developers who need to easy edit complex layouts and insert different post tile blocks inside the layout, sidebars or page builders.
By default it has 3 pre-defined layouts, you can rewrite them in your theme or register custom layouts. Unfortunately pre-defined layouts has no styles inside. (Because they will be overwritten in the theme 100% anyway)

= Template files =
To overwrite pre-defined templates you should create folder with name `just-post-preview` in the root of your theme and copy required templates from the `/wp-content/plugins/just-post-preview/layous/` folder.

File names format: `jpp_layout_{layout key}.php`

You can find PHP comments on the top of the demo templates. They help your IDE to show you autocomplete boxes for available variables.

= Adding custom layout =
To add a custom layout you need to add a new filter hook in your theme `functions.php` file:

`add_filter('jpp_post_preview_layouts', 'my_post_preview_layouts');
function my_post_preview_layouts($layouts){
	$layouts['my_layout_key'] = 'My custom layout';
	return $layouts;
}`

After that hook you will need to create template file in folder: `/path/to/theme/just-post-preview` with name `jpp_layout_my_layout_key.php`.

= That's all! =

FILL FREE TO CONTACT ME IF YOU FIND ANY BUGS/ISSUES!

**ISSUES TRACKER**
I've setup github repo for this plugin. Git is great repo with many features i can use as branches and also it has nice issue tracker. 
Please post all issues there.
https://github.com/aprokopenko/just-post-preview

== Installation ==

1. Download, unzip and upload to your WordPress plugins directory
2. Activate the plugin within you WordPress Administration Backend
3. That's it - you can add new widget now

== Upgrade Notice ==
* Remove old plugin folder.
* Follow install steps 1-2. All settings will be saved.

== Screenshots ==

1. Widget edit screenshot
2. Using widget inside the SiteOrigin Page builder plugin

== Changelog ==
= Version 1.0 =
	* Plugin base with 3 pre-defined layouts
	