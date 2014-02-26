Simple Course Creator
=====================

This WordPress plugin is **still in its development stages** but is functional and safe to use.

Simple Course Creator is designed to easily link posts together in a series and output that series list in the content of each included post.

### How It Works

Once activated, a new taxonomy is added to your Posts menu called "Courses." Courses are created just like categories and tags.

When creating a new course, it's important to give the course a description as well as a title, which is a new field added by this plugin.

![Create New Course](http://seandavis.co/wp-content/uploads/2014/02/Screen-Shot-2014-02-24-at-2.44.16-PM.png)

Now with at least one course created, you have the ability to select which course a post belongs to from the edit post screen.

![Select Course](http://seandavis.co/wp-content/uploads/2014/02/Screen-Shot-2014-02-24-at-2.47.48-PM.png)

Once a course is selected and saved, a course listing will appear in the content of said post as long as it's not the only post in a course.

The course listing will display as a container that shows nothing but the course title and the course description, which is what you filled out when creating a new course.

The series of posts will be hidden until you click a subtle link for displaying them, at which point the container will gracefully expand to reveal all posts in said course. They will all be linked except for the current post.

![Course Description](http://seandavis.co/wp-content/uploads/2014/02/Screen-Shot-2014-02-24-at-2.54.45-PM.png)

![Course Listing](http://seandavis.co/wp-content/uploads/2014/02/Screen-Shot-2014-02-24-at-2.55.54-PM.png)

Styles are kept to a minimum so theme styles are inherited as much as possible.

### Theme Overrides

You are more than welcome to override the basic default styles or HTML template responsible for displaying the course container.

If you only want to **edit** CSS styles, you're better off using your own theme's stylesheet and simply writing strong CSS.

If you would like to override the actual CSS file as well as the template for displaying the course container, you can easily do so by creating a folder in the root of your theme called `scc_templates` and copying any of the files you'd like from the plugin's `inc/scc_templates` folder into your new theme folder. 

Your theme files will now completely override the plugin files.

Be sure to copy these files and not simply create new, empty ones. Even if they're empty, they'll still override.

### Bugs and Contributions

If you notice any mistakes, feel free to fork the repo and submit a pull request with your corrections. The same is true of any features you feel should be added or changes that can be made. 

### License

This plugin, like WordPress, is licensed under the GPL. Do what you want with it. I seriously don't care. 

### Developer

I'm Sean. I created the [Volatyl Framework](http://volatylthemes.com) for WordPress. I write stuff on my [personal site](http://seandavis.co) and [SDavis Media](http://sdavismedia.com). Follow me on the [Twitter](http://sdvs.me/twitter) machine.

Meanwhile, tell me... is this plugin useful to you? If so, consider buying me a box of "Tazo: Awake - English Breakfast Black Tea." I need ALL the energiez. Thanks. [Donate Black Tea](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=52HQDSEUA542S)
