=== Edit Author Slug ===
Contributors: cnorris23
Tags: author, author base, author slug, user nicename, nicename, permalink, permalinks, slug, users, user
Requires at least: 3.2.1
Tested up to: 3.4
Stable tag: 0.9.2

Allows an admin (or capable user) to edit the author slug of a user, and change the author base.

== Description ==

This plugin allows an Admin to change the author slug (a.k.a. - nicename), without having to actually enter the database. You can also change the Author Base (the '/author/' portion of the author URLs). Two new fields will be added to your Dashboard. The "Edit Author Slug" field can be found under Users > Your Profile or Users > Authors & Users (Users > Users in WP 3.0). The "Author Base" field can be found under Settings > Permalinks. This allows you to craft the perfect URL structure for you Author pages. For your convenience, an Author Slug column is added to make it easier to determine if one needs to change the Author Slug.

WordPress default structure
http://example.com/author/username/

Edit Author Slug allows for
http://example.com/ninja/master-ninja/

#### Translations Available
* Hebrew (he_IL)      - Yonat Sharon
* Belorussian (be_BY) - Marcis G.
* Polish (pl_PL)      - Kornel L.
* Dutch (nl_NL)       - Juliette Reinders Folmer

You can also visit the plugin's homepage at http://brandonallen.org/wordpress/plugins/edit-author-slug/

== Installation ==

1. Upload `edit-author-slug` folder to your WordPress plugins directory (typically 'wp-content/plugins')
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Users > Your Profile, or Users > All Users > (username), and edit the author slug.
1. Click "Update Profile" or "Update User"
1. Go to Settings > Edit Author Slug to edit settings
1. Click "Save Changes"

== Screenshots ==

1. Edit Author Slug screenshot
2. Author Base screenshot

== Frequently Asked Questions ==

= Why can't I edit my Author Slug? =

Make sure you are an admin, or have been assigned the `edit_users` or `edit_author_slug` capability.

== Changelog ==

= 0.9.2 =
* Fix issue where any profile information other than the Author Slug could not be updated
* Minor code improvement

= 0.9.1 =
* Add 'Settings' link to plugins list table

= 0.9.0 =
* Allow Author Slug to be automatically created/updated based on a defined structure
* Switched to using the Settings API, which also means that all options moved to the Settings > Edit Author Slug page
* Various code improvements/optimizations

= 0.8.1 =
* Fix a bug that prevented non-admin users from updating their profile

= 0.8.0 =
* Drastically improved error handling and feedback for author slug editing.
* Restore duplicate author slug check as old method could alter the slug without any sort of warning.
* Further improve the logic for flushing rewrite rules.
* Introduce ba_eas_can_edit_author_slug() and matching filter to make it even easier to give users the ability to update their own author slug.
* Add message in plugins list warning users of WP less than 3.2 that 0.8 is the last update they'll receive.

= 0.7.2 =
* Remove overzealous cap check.

= 0.7.1 =
* Fix some unfortunate errors I missed before tagging 0.7.

= 0.7 =
* Significant code refactoring.
* Added custom capability to give site admins the ability to add author slug access to other roles.
* Improvements/optimizations to code logic.
* Fixed an incorrect textdomain string.
* Removed filter added in 0.6 as it was messy. It's much easier to achieve the same result without the plugin.
* Got rid of wp_die() statement on duplicate author slugs in favor of WP's built-in duplicate author slug method.

= 0.6.1 =
* Added Dutch translation - props Juliette Reinders Folmer.
* Don't hard code the languages folder path.
* Improve class check/initialization.

= 0.6 =
* Some code cleanup.
* More security hardening.
* Added filter to allow for the complete removal of the Author Base (http://brandonallen.org/2010/11/03/how-to-remove-the-author-base-with-edit-author-slug/).
* Flush rewrite rules only when necessary instead of every page load.

= 0.5 =
* Added 'Author Slug' column to Users > Authors & Users (Users > Users in 3.0) page (props Yonat Sharon for the jumpstart).
* Ended support for the WP 2.8 branch. Most likely still works, but I will not support it.
* Various bug fixes.

= 0.4 =
* Added ability to change the Author Base.
* Updated documentation.
* Added some extra security via WP esc_* functions.
* Added Belorussian translation, props Marcis G.

= 0.3.1 =
* Added Hebrew Translation, props Yonat Sharon.

= 0.3 =
* Now localization friendly.

= 0.2.1 =
* Fixed a bug that prevented updating a user if the author slug did not change.

= 0.2 =
* Added a check to avoid duplicate slugs.
* Properly sanitize slug before comparison and database insertion.
* Updated plugin URI.

= 0.1.4 =
* Update tags to reflect WordPress 2.9.1 compatability.
* Update link to plugin homepage.

= 0.1.3 =
* Update tags to reflect WordPress 2.9 compatability.

= 0.1.2 =
* Fix version number issues.

= 0.1.1 =
* Remove extra debug functions left behind.
* Add screenshot.

= 0.1 =
* Initial release.

== Upgrade Notice ==

= 0.4 =
Adds ability to change the Author Base (not a required upgrade)

= 0.3 =
Edit Author Slug can now be localized. You can find edit-author-slug.pot in 'edit-author-slug/languages' to get you started.

= 0.2 =
Added a check to avoid duplicate duplicate author slugs, and better sanitization.

= TODO =
* Allow Author Slug editing of users from one centralized location