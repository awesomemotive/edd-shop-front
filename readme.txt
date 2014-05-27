Shop Front
http://sumobi.com/shop/shop-front/

A Simple, responsive & easily extensible theme for the Easy Digital Downloads plugin. It also functions perfectly without the plugin as a standard WordPress blog. A free child theme for modifications can be downloaded from sumobi.com as well as other free and paid add-ons to enhance the functionality and styling.


== Making Modifications ==

Download the free Child Theme from http://sumobi.com/shop/shop-front-child-theme/

This will allow you to easily make modifications to the Shop Front parent theme without worrying about your changes being overridden when the parent theme is updated.

== Licensing ==

All bundled resources (including images and fonts) and licensed under GPL.

== Documentation ==

http://sumobi.com/docs/shop-front-theme/


== Changelog ==

= 1.1.4: May 27, 2014 =
* Fix: tag name not displaying properly on tag archive pages
* New: Added next/previous page navigation to search page
* Tweak: better translation of shopfront_download_button() function
* Tweak: removed redundant shopfront_show_added_to_cart_messages() function


= 1.1.3: January 30th, 2014 =

* Tweak: shopfront_modify_edd_show_has_purchased_item_message() function removed.
* New: shopfront_galery_enabled() filter for disabling the built in gallery modifications if you intend to use jetpack carousel


= 1.1.2: August 15th, 2013 =

* Fix: Second purchase button appearing when the page is loading initially
* Fix: Logo uploaded to header was not responsive in some browsers
* Tweak: Minor shortcode styling
* Tweak: Minor CSS styling changes
* New: shopfront_download_icon filter for changing the default download icon when no featured image exists
* New: shopfront_post_thumbnail and shopfront_post_thumbnail_medium filter hooks for images in the download grid


= 1.1.1: July 27, 2013 =

* Fix: Title tags were not displaying correctly on anchor tags
* Fix: Downloads were not showing correct styling when using downloads shortcode
* Fix: Downloads showing on custom post type archive page
* Fix: Styling where downloads are shown via [downloads] shortcode


= 1.1: July 27, 2013 =

* Fix: Replaced the_title() with the proper the_title_attribute() in title attributes
* Tweak: Improved checkout styling
* Tweak: Updated translation strings
* Tweak: Removed .mo file which isn't needed, provided just .pot file for translations


= 1.0.9: July 21, 2013 =

* Tweak: Replaced some of the icons with brand new icons to be GPL compatible 
* New: Theme is now available from WordPress.org
* Tweak: Adjusted CSS styling, ready for EDD 1.7


= 1.0.8: July 18, 2013 =

* Fix: Removed redundant wp_enqueue_script call from header.php
* Fix: Purchase/go to checkout buttons after EDD 1.7 update
* Tweak: Adjusted CSS styling, ready for EDD 1.7


= 1.0.7: July 17, 2013 =

* Fix: Untranslated text strings
* New: author.php for displaying author profiles
* New: image.php for display image attachments


= 1.0.6: July 10, 2013 =

* Fix: The "View Our Downloads" button now links correctly to the custom post type archive page when pretty permalinks are not enabled
* Fix: Custom coming soon text from EDD Coming Soon plugin is now shown correctly
* Tweak: Changed Made the default text for the button that appears on the homepage "View all" to better match the theme customizer's default text for this button
* Tweak: Completely removed theme updater code. Automatic theme updates are now handled via WordPress.org so there is no need for a license key for this theme 


= 1.0.5: July 7, 2013 =

* Tweak: Removed "home-featured image" size from shopfront_setup()
* Tweak: Removed "download-image" image size which is the same as the "featured-image" size
* Fix: Downloads not showing on tag archive pages
* Fix: Incorrect closing HTML tags on category and tag archive pages


= 1.0.4: July 1, 2013 =

Important: There is no longer a contact page template, please download the Shop Front Contact plugin from sumobi.com

* New: Added new shopfront_index hook for the index page
* New: shopfront_single_content_end hook
* New: shopfront_single_download_image hook
* Tweak: Items on index.php are now added via new hook for greater flexibility
* Tweak: Optimized CSS/removed unused code
* Tweak: The contact form page template has been removed to adhere to WordPress Theme Review guidelines. If you need this functionality back, download the Shop Front Contact plugin from this website.
* Tweak: Theme Customizer class names have been prefixed with the theme name to adhere to WordPress coding standards
* Tweak: Added CSS styling to small select menus such as the credit card expiry date
* Tweak: Cart icon is now fired on an action hook. This will allow it to be removed or repositioned easily
* Tweak: Made buttons look more consistent by removing box-shadow effect on some button hovers. If you preferred the old effect, a CSS file has been provided in the child theme's "style" folder that will put this back to how it was. This file will show up in the Theme Customizer under "Styling"
* Tweak: The download image on single-download.php has now been moved to the new shopfront_single_download_image hook
* Tweak: Typography improvements
* Tweak: Various other CSS improvements to adhere to the WordPress Theme Unit Test Data
* Fix: 1 column layouts not displaying correctly
* Fix: PHP Notice caused by $post->ID on action hook in header.php
* Fix: Entering 0 did not disable featured downloads on homepage
* Fix: Menu is now open by default when Javascript is disabled and menu icon is hidden
* Fix: Read more links on blog were not showing up unless theme customizer had been saved for the first time
* Fix: PHP Notices when Easy Digital Downloads was not installed.


= 1.0.3: May 29, 2013 =

* New: You can now choose between a cart or basket icon, or just text. You also have control over icon's alignment. Text is updated in other areas of the theme also.
* New: Added cart icon. You will need to copy the fonts folder and override the one in your child theme (which you should be using) to see the new icon/s.
* Fix: Incorrect text domains.
* Tweak: Updated translation strings.
* Tweak: Editor stylesheet.


= 1.0.2: May 28, 2013 =

* New: Added support in theme customizer for background_image and static_front_page. Background support needs add_theme_support( 'custom-background' ); in child theme.
* New: Custom typography stylesheet has been added to the child theme which shows a basic example of modifying the navigation.
* New: Added hook to sidebar-download.php - shopfront_single_download_aside
* Fix: Download titles now have the correct CSS class name.
* Tweak: Minor CSS changes.
* Tweak: Navigation is no longer uppercase to make design cleaner. If you need uppercase navigation, select the custom typography file in the theme customizer.
* Tweak: If for whatever reason a stylesheet cannot be found in the theme customizer stylesheet dropdown, the default style.css is loaded as a fallback.
* Tweak: Moved shopfront_download_button() function to new shopfront_single_download_aside hook. This is so it can be removed/repositioned as needed. 
* Tweak: Moved shopfront_download_meta() function to new shopfront_single_download_aside hook. This is so it can be removed/repositioned as needed. 


= 1.0.1: May 23, 2013 =

* Fix: PHP Notices showing in Theme Customizer when Easy Digital Downloads is not installed
* Tweak: Made shopfront_edd_fd_featured_downloads_html() pluggable so HTML can be modified from child theme
* Tweak: Removed unused CSS animation code
* New: Typography stylesheets can be added to the child theme's 'typography' folder and will appear in the theme customizer


= 1.0: May 16, 2013 =

* Initial release


