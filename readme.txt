=== Better Page Comments ===
Contributors: swiftninjapro
Tags: comments, query, strip-html, anti-spam, shortcode
Requires at least: 3.0.1
Tested up to: 5.5
Stable tag: 5.5
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://buymeacoffee.swiftninjapro.com

Comments that Strip away HTML, but allow basic fonts in another way. Also includes some basic spam control options.

== Description ==

Comments that Strip away HTML, but allow basic fonts in another way. Also includes some basic spam control options.

Comments will attempt to remove html and still allow users to add built-in non-html tags (made by the plugin) for bold, italic, ect. text.

The plugins built-in non-html tags will only run on the front end, which can help protect the backend from getting hijacked.

Plugin will include your old comments and use the same database.

Disables default wordpress comments on any page with the shortcode.

Plugin Includes Some Spam Control Options.

Comments can Optionally be made specific to a query var in the url, so one post can show comments specific to that query.

You can change the background, text, and button colors of comments to better match your theme.

== Installation ==
 
1. Upload plugin to the /wp-content/plugins
2. Activate the plugin through the "Plugins" menu in WordPress
3. Go to this plugins Settings and Check "Plugin Enabled" To Enable the plugin
4. Edit any other settings to your preference
5. Click Save and Enjoy

== Frequently Asked Questions ==

= Can this plugin show my old comments? =
yes, the plugin uses the same comment database as wordpress.

= Do all the query vars have to be exact? =
no, only the one query var you put in the shortcode needs to match.
If you do not put a query, than the query vars will be ignored, and it will run like regular wordpress comments would per post.

= can users add bold/italic text and embed images? =
users can add custom tags that the plugin reads to make text bold and add images and urls.
as an admin, you can disable image and url embeds in the plugin settings.
the user adds tags like "[b][/b]", and the plugin replaces it with "<strong></strong>" only if it is on the front end.
the tags get stored as "[b][/b]" to prevent html from running on the backend.

== Screenshots ==
1. example of basic use and different colors
2. example of what posting comments looks like
3. example of settings page
4. query specific example of code
5. query specific example of comments
6. query specific example of comments
7. an example of me hacking my own website with the plugin (html gets blocked)
8. an example of me hacking my own website without the plugin (html gets run)

== Changelog ==

= 1.4 =
added character maximum to comments

= 1.3 =
added wordpress thanslate to comments

= 1.2 =
comments now auto-unapprove if they contain html tags
you can still see the users IP and the sanitized(html removed) comment in the backend
if you see a lot of "&" signs followed by letters, numbers, and ";", that could be blocked html tags(ex: &amp;lt;a href=&amp;quot;/&amp;quot;&amp;gt;Test&amp;lt;/a&amp;gt;).
Note: if you see a small amount of blocked html & signs(ex: &amp;lt;), it could be a false positive

= 1.1 =
comments look cleaner in backend
admins now have the option(in plugin settings) to require users be signed in, to post comments

= 1.0.2 =
shortcode now hides when the plugin is disabled in it's plugin settings

= 1.0 =
First Version

== Upgrade Notice ==

= 1.4 =
added character maximum to comments

= 1.3 =
added wordpress thanslate to comments

= 1.2 =
comments now auto-unapprove if they contain html tags
you can still see the users IP and the sanitized(html removed) comment in the backend
if you see a lot of "&" signs followed by letters, numbers, and ";", that could be blocked html tags(ex: &amp;lt;a href=&amp;quot;/&amp;quot;&amp;gt;Test&amp;lt;/a&amp;gt;).
Note: if you see a small amount of blocked html & signs(ex: &amp;lt;), it could be a false positive

= 1.1 =
comments look cleaner in backend
admins now have the option(in plugin settings) to require users be signed in, to post comments

= 1.0.2 =
shortcode now hides when the plugin is disabled in it's plugin settings

= 1.0 =
First Version
