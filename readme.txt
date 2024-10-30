=== Plugin Name ===
Contributors: mcosx
Donate link: 
Tags: collapsing,links,blogroll
Requires at least: 2.5
Tested up to: 2.8
Stable tag: 0.3.1

Collabpsing Blogroll allows you to put your blogroll on a page or in a post. The categories can be collapsed.

== Description ==

Collapsing Blogroll allows you to put your built-in blogroll on a page or in a post. Just put 
[collroll] in the place where it should appear. The categories can be collapsed. No extra
database table is needed. You can add new links as you did it in the past.


== Installation ==

1. Copy plugin contents to /wp-content/plugins/collroll.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Put [collroll] in your post or on a page where the blogroll should appear.

== Frequently Asked Questions ==

= How to insert the blogroll in a page or in a post? =

Just put [collroll] in it.

= Can this plugin be used in the sidebar? =

No. The reason is that there's already a plugin for this. Take a look at *Related plugins*.

== Screenshots ==

1. Collapsing Blogroll in a post.
2. Admin page

== Compatibility ==

The plugin *Link Summarizer* isn't compatible to *Collapsing Blogroll*. If you want to use both 
plugins on your blog you have to disable the link summarizer in the post or page using Collapsing
Blogroll. Create a new custom field named *lnsum_show* and set the value to 0 to disable it or to 1
to enable it.

== Older wordpress versions ==

Collroll is only tested with Wordpress versions from 2.5 to 2.7. I don't test my code with older versions. 
It doesn't make sense to drive your old *Trabi* (an old German car) when you could have a Ferrari for free ;-)

== Related plugins ==

* [Collapsing Links](http://wordpress.org/extend/plugins/collapsing-links/)

== Other plugins ==

* [Link Summarizer](http://wordpress.org/extend/plugins/link-summarizer/)

== HISTORY ==
* 0.3.1: (2009 Mar 15)
	* Bug-fix

* 0.3: (2009 Mar 15)
  * New options added
  * Added translations
  * Use of [collroll] instead of `<!--collroll-->`
  * Code cleanup

* 0.2.1: (2009 Feb 24)
  * Fixed a bug of the update notification.

* 0.2: (2009 Feb 24)
  * Considering the user defined order for the categories and links.
  * The width is adjustable now.

* 0.1 (2009 Jan 25)
	* Initial Release. A color picker is shown in the admin panel.
