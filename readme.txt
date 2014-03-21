=== Plugin Name ===
Contributors: sdavis2702
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=52HQDSEUA542S
Tags: series, course, lesson, taxonomy
Requires at least: 3.8
Tested up to: 3.9
Stable tag: /trunk/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily create, output, and manage post series with the "course" taxonomy.

== Description ==

Simple Course Creator is designed to easily link posts together in a series and output that series list in the content of each included post. A post can only be assigned to one course that way it can display the rest of the posts in its series.

Output can be displayed above the post content, below, or both. There's also an option to display the posts as a number list, bullet list, or with no list indicator.

== Installation ==

1. Upload `simple-course-creator` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create a an unlimitied number of courses under the WordPress 'Posts' menu
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
* scc_list_item
* scc_below_list
* scc_container_bottom
* scc_after_container

The course display toggle link is also filtered. Use the following filter to change its text.

* course_toggle

-- The second way is to override the plugin display files in your active theme.

You'd create a directory in the ROOT of your active theme called `scc_templates` and in it, copy any of the files from the `includes/scc_templates` directory of the plugin. Your new theme files will override the plugin files. 

Only use this method if you know your way around PHP, HTML, CSS, and JS.

-- Lastly, for minimal display tweaks, simply write CSS in your active theme that overrides the default plugin CSS, which is minimal.