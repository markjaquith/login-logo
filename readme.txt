=== Login Logo ===
Contributors: markjaquith
Donate link: http://txfx.net/wordpress-plugins/donate
Tags: customize, login, login screen, logo, custom logo
Requires at least: 3.0
Tested up to: 3.1
Stable tag: trunk

Customize the logo on the WP login screen by simply dropping a file named login-logo.png into your WP content directory. CSS is automatic!

== Description ==

This plugin allows you to customize the logo on the WordPress login screen. There is zero configuration. You just drop the logo file into your WordPress content directory, named `login-logo.png` and this plugin takes over.

Note that you should use a transparent background on the PNG image and keep the width below 326 pixels for best results. Larger images will be downsized in modern browsers, but it isn't recommended to rely on that.

This plugin also works in the `mu-plugins` directory.

== Installation ==

1. [Click here](http://coveredwebservices.com/wp-plugin-install/?plugin=login-logo) to install and activate.

2. Create a PNG image of less than 326 pixels wide, with a transparent background.

3. Upload the PNG image to your WordPress content directory (`/wp-content/`, by default), and name the file `login-logo.png`.

4. Done! The login screen will now use your logo.

== Screenshots ==

1. A login screen with a custom logo

2. A source image

== Frequently Asked Questions ==

= Why does my image look strange in IE or an outdated browser? =

Your image is probably too wide. Wide images are scaled down in IE 9 or other modern browsers, but not in older browsers. Use an image that is no more than 326 pixels wide.


== Changelog ==

= 0.1 =
* Original version

== Upgrade Notice ==

Upgrade now!