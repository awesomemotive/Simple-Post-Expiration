=== Simple Post Expiration ===
Plugin URI: http://pippinsplugins.com/simple-post-expiration
Author URI: http://pippinsplugins.com
Contributors: mordauk, rzen
Donate link: http://pippinsplugins.com/support-the-site
Tags: expiration, posts, expire
Requires at least: 3.6
Tested up to: 4.7
Stable Tag: 1.0.1

A simple plugin that allows you to set an expiration date on posts. Once a post is expired, "Expired" will be prefixed to the post title.

== Description ==

A simple plugin that allows you to set an expiration date on posts. Once a post is expired, "Expired" will be prefixed to the post title.

You can show the expiration status of a post using the [expires] short code.

The [expires] short code accepts 5 optional parameters:

- expires_on - The text to be shown when a post has not yet expired. Default: `This item expires on: %s`

- expired - The text to be shown when a post is expired. Default: `This item expired on: %s`

- date_format - The format the expiration date should be displayed in

- class - The class or classes given to the DIV element

- id - The ID given to the DIV element

The `%s` will be replaced with the expiration date.

Have you found a bug or have a suggestion or improvement you'd like to submit? This plugin is available on [Github](https://github.com/pippinsplugins/Simple-Post-Expiration) and pull requests are welcome!


== Screenshots ==

1. Metabox added to each post / custom post type
2. Metabox with calendar showing
3. Expired post with modified title
4. Expired / Expiring Posts  widget

== Installation ==

1. Activate the plugin
2. Go to Settings > Reading and set the expired prefix
3. Add an expiration date to any post item that you wish to expire at a certain point in time
4. Optionally add the [expires] short code to the post content

== Changelog ==

= 1.0.1 =

* Fix: Notice with PHP 7
* New: Translation files for pt_PT

= 1.0 =

* First release!