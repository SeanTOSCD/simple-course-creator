=== Simple Course Creator ===
Contributors: sdavis2702, mattonomics
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=52HQDSEUA542S
Tags: series, course, lesson, taxonomy
Requires at least: 3.8
Tested up to: 3.9
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily create, output, and manage post series.

== Description ==

Simple Course Creator is designed to easily link posts together in a series and output that series list in the content of each included post. A post can only be assigned to one course that way it can display the rest of the posts in its series.

Output can be displayed above the post content, below, or both. There's also an option to display the posts as a number list, bullet list, or with no list indicator.

Extend the functionality of Simple Course Creator with these add-on plugins:

* [SCC Customizer](https://wordpress.org/plugins/simple-course-creator-customizer/) - Customizer the SCC output using the native WordPress customizer.
* [SCC Post Meta](https://wordpress.org/plugins/simple-course-creator-post-meta/) - Add author and published date to SCC post listing items.
* [SCC Front Display](https://wordpress.org/plugins/simple-course-creator-front-display/) - Indicate a post’s course on the blog home, archive pages, and search results.

== Installation ==

1. Upload `simple-course-creator` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create an unlimited number of courses under the WordPress 'Posts' menu
4. Add single posts to a course on the post edit screen or the manage posts screen

Follow Simple Course Creator on [Github](https://github.com/sdavis2702/simple-course-creator)

== Frequently Asked Questions ==

= Can a post be assigned to more than one course? =

No. A post can only be assign to one course that way it can display the rest of the course's posts within the content of said post. 

= Can I edit the course HTML output? =

Yes. When creating a new course, the description and course title fields are used to display an introduction to the course. If they are filled out, they will display.

From there, there are multiple ways to edit additional output. 

-- The first and easiest way is to use the built-in hooks and filter to customize the course box. You'd write your actions in your active theme functions file.

Here's a list of all the hook names you can use to insert custom content.

* scc_before_container
* scc_container_top
* scc_below_title
* scc_below_description
* scc_before_toggle
* scc_after_toggle
* scc_above_list
* scc_before_list_item
* scc_after_list_item
* scc_below_list
* scc_container_bottom
* scc_after_container

The course display toggle link is also filtered. Use the following filter to change its text.

* course_toggle

-- The second way is to override the plugin display files in your active theme.

You'd create a directory in the ROOT of your active theme called `scc_templates` and in it, copy any of the files from the `includes/scc_templates` directory of the plugin. Your new theme files will override the plugin files. 

Only use this method if you know your way around PHP, HTML, CSS, and JS.

-- Lastly, for minimal display tweaks, simply write CSS in your active theme that overrides the default plugin CSS, which is minimal.

== Screenshots ==

1. settings Page with output options
2. create a course just like categories and tags
3. assign a post to a course from edit post screen
4. filter course information from manage posts screen
5. course output collapsed
6. course output expanded

== Changelog ==

= 1.0.0 =
* first stable version