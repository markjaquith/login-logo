=== Login Logo ===
Contributors: markjaquith
Donate link: http://txfx.net/wordpress-plugins/donate
Tags: customize, login, login screen, logo, custom logo
Requires at least: 3.3
Tested up to: 3.4
Stable tag: 0.6

Customize the logo on the WP login screen by simply dropping a file named login-logo.png into your WP content directory. CSS is automatic!

== Description ==

This plugin allows you to customize the logo on the WordPress login screen. There is zero configuration. You just drop the logo file into your WordPress content directory, named `login-logo.png` and this plugin takes over.

Note that you should use a transparent background on the PNG image, crop it tightly (no padding pixels) and use a width of exactly 312 pixels for best results. Wider images will be downscaled in modern browsers, but it isn't recommended to rely on that.

This plugin also works in the `mu-plugins` directory.

== Installation ==

1. [Click here](http://coveredwebservices.com/wp-plugin-install/?plugin=login-logo) to install and activate.

2. Create a PNG image with a transparent background, tightly cropped, with a recommended width of 312 pixels.

3. Upload the PNG image to your WordPress content directory (`/wp-content/`, by default), and name the file `login-logo.png`.

4. If you have a multisite install with more than one network, you can also use `login-logo-network-{NETWORK ID}.png` to assign a different login logo to each network.

5. If you have a multisite install, you can also use `login-logo-site-{$blog_id}.png` to assign a different login logo to each site.

6. Done! The login screen will now use your logo.

== Screenshots ==

1. A login screen with a custom logo

2. A source image

== Frequently Asked Questions ==

= Why does my image look strange in IE or an outdated browser? =

Your image is probably too wide. Wide images are scaled down in IE 9 or other modern browsers, but not in older browsers. Use an image that is no more than 312 pixels wide.


== Changelog ==

= 0.6 =
* You can provide `login-logo-site-{$blog_id}.png` to have a different logo per multisite site.
* Support for WordPress 3.4
* Changed the ideal image width to 312 pixels, and instituted a tighter crop policy.

= 0.5 =
* Support for WordPress 3.3
* Fix a bug in CSS resizing of oversized images

= 0.4 =
* Use HTTPS if `is_ssl()` on the login page.

= 0.3 =
* The login logo now links to your site, instead of WordPress.org
* If you don't have a custom login logo, the plugin does nothing.
* You can provide `login-logo-network-{NETWORK ID}.png` to have a different logo per multisite network.

= 0.2 =
* Do not use `background-size` unless the image is more than 326 pixels

= 0.1 =
* Original version

== Upgrade Notice ==

= 0.6 =
Upgrade now for WordPress 3.4 support! Also adds the ability to set a custom logo per site on a network.

= 0.5 =
Upgrade immediately or the plugin will not work in WordPress 3.3!

= 0.4 =
Adds support for SSL

= 0.3 =
Makes the logo link to your site instead of WordPress.org! Support for per-network logos.

= 0.2 =
Upgrade now to avoid stretching small images.