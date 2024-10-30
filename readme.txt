=== Headline Replacement ===
Contributors: mariokostelac
Donate link: http://mariokostelac.com/
Tags: titles, headlines, replacements, image, upload
Requires at least: 2.9
Tested up to: 2.9.1
Stable tag: 0.1.2

Simple plugin allows replacing headlines by unique images. Just upload, no sIFR, no Cufon.

== Description ==

Simple plugin allows replacing headlines by unique images. Just upload, no sIFR, no Cufon. Plugin is based on http://wordpress.org/extend/plugins/headline-image/ plugin originally written by Pavol Klacansky.

Usability is one step above now. The fact that you must upload image and then go to Media tab to find the image in order to use it as a headline was annoying. Now it is past, upload and use! No unnecessary steps.

== Installation ==

1. Extract plugin to /wp-content/plugins

2. Activate plugin in administration

3. Add function call to template file in LOOP `<?php if (function_exists('headline_image_show')) headline_image_show(get_the_ID()); ?>`

For more information or if you have some problem related to use of plugin, please visit [plugin homepage](http://www.mariokostelac.com)

== Frequently Asked Questions ==

I you have some question, drop me a line on my mail or post a comment on www.mariokostelac.com

== Screenshots ==

1. Plugin box is positioned just below the post/page text
2. Replacing image is simple as clicking

== Upgrade Notice ==

No essential notices at the moment.

== Changelog ==

= 0.1.2 =
* Fixed .js ajaxComplete bug

= 0.1.1 =
* Removed facebook support
* Fixed repetition bug (on media and gallery tab)

= 0.1 =
Initial relase
