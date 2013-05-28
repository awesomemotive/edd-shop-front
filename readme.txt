Shop Front
http://sumobi.com/shop/shop-front/

Shop Front was designed to be simple, responsive and lightweight. It has only the bare essentials, making it the perfect starting point for your next digital e-commerce store. It’s also easily extensible with a growing collection of add-ons to enhance the functionality and styling.

== Changelog ==

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


