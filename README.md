Simple Post Expiration
======================

A simple plugin that allows you to set an expiration date on posts. Once a post is expired, "Expired" will be prefixed to the post title.

You can show the expiration status of a post using the [expires] short code.

The [expires] short code accepts 5 optional parameters:
- expires_on - The text to be shown when a post has not yet expired. Default: `This item expires on: %s`
- expired - The text to be shown when a post is expired. Default: `This item expired on: %s`
- date_format - The format the expiration date should be displayed in
- class - The class or classes given to the DIV element
- id - The ID given to the DIV element

The short code paramters can also be modified programatically using the `pw_spe_shortcode_atts` filter, which receives the array of parameters.

The `%s` will be replaced with the expiration date.