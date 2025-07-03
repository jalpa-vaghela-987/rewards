=== Esotera ===

Contributors: Cryout Creations
Requires at least: 4.5
Tested up to: 5.6.2
Stable tag: 1.2.4
Requires PHP: 5.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Copyright 2019-21 Cryout Creations
https://www.cryoutcreations.eu/

== Description ==
 Colorful, clean and beautifully animated, Esotera is a highly customizable, multi-purpose responsive theme that’s perfect for your blog, portfolio, photography or business website. Demo: https://demos.cryoutcreations.eu/wp/esotera

== License ==

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see http://www.gnu.org/copyleft/gpl.html


== Third Party Resources ==

Esotera WordPress Theme bundles the following third-party libraries and resources:

TGM Plugin Activation
Copyright Thomas Griffin, Gary Jones, Juliette Reinders Folmer
License: GPL-2.0 or later license
Source: https://github.com/TGMPA/TGM-Plugin-Activation

HTML5Shiv
Copyright Alexander Farkas (aFarkas)
License: Dual licensed under the terms of the GPL (https://www.gnu.org/licenses/gpl-3.0.en.html) and MIT (https://opensource.org/licenses/MIT) licenses
Source: https://github.com/aFarkas/html5shiv/

FitVids
Copyright Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
License: WTFPLlicense
Source: http://fitvidsjs.com/

prepareTransition
Copyright Jonathan Snook
License: MIT license
Source: https://snook.ca/archives/javascript/preparetransition-jquery-plugin

== Bundled Fonts ==

Icomoon icons, Copyright Keyamoon.com
Licensed under the terms of the GPL license
Source: https://icomoon.io/#icons-icomoon

Entypo+ icons, Copyright Daniel Bruce
Licensed under the terms of the CC BY-SA 4.0 license
Source: http://www.entypo.com/faq.php

Feather icons, Copyright Cole Bemis
License: MIT license, https://opensource.org/licenses/MIT
Source: https://feathericons.com/

Zocial CSS social buttons, Copyright Sam Collins
Licensed under the terms of the MIT license
Source: https://github.com/smcllns/css-social-buttons

== Bundled Images ==

The following bundled images are released into the public domain under Creative Commons CC0:

Header images:
https://www.nicepik.com/nikon-sunset-smile-jean-jacket-denim-blonde-camera-pier-ocean-beach-portrait-woman-free-photo-1304826
https://www.nicepik.com/closeup-shot-of-light-bulbs-various-technology-electric-lamp-lighting-equipment-illuminated-free-photo-403707

The rest of the bundled images are created by Cryout Creations and released with the theme under GPLv3


== Changelog ==

= 1.2.4 =
*Release date - 2021.02.26

* Added configuration hint for header image when the theme's slider / banner image is active on the homepage
* Updated to Cryout Framework 0.8.5.7
	* Expanded hint control styling to apply in the Site Identity panel

= 1.2.3.1 =
*Release date - 2021.02.11

* Really fixed mobile menu search creating an extra focusable item

= 1.2.3 =
*Release date - 2021.02.05

* Removed lazy loading functionality from featured images as it sometimes interferes with image sizes
* Fixed leftover border on main navigation
* Fixed mobile menu and sticky top bar z-index issues
* Fixed mobile menu search creating an extra focusable item
* Fixed breadcrumbs on one-column layouts on mobile
* Fixed breadcrumbs padding on mobile
* Fixed search widgets in footer
* Fixed author section border on single pages on resolutions between 800px and 1024px
* Fixed multiple RTL issues
* Added click-navigation to target panels in header content and site identity hints
* Changed preloader failsafe auto hide time
* Changed banner caption title animation option to toggle control and renamed/relocated for clarity

= 1.2.2 =
*Release date - 2021.01.13*

* Added lazy loading for featured images and landing page elements
* Optimized frontend.js structure
* Improved preloader handling when JavaScript is broken on the site or disabled in browser
* Fixed social icons in side-menu not being accessible with keyboard navigation
* Fixed header title animation support for HTML entities and special characters
* Fixed landing page blocks layout with 2/4 columns
* Fixed landing page blocks borders
* Fixed block editor galleries layout
* Fixed back to top button animation styling when using child themes

= 1.2.1 =
*Release Date - 2020.12.29*

* Improved comment placeholder/label option functionality
* Renamed landing page 'static image' element to 'banner image' for clarity
* Removed all padding/margins from before/after content and top/bottom inner widget areas
* Fixed header titles support for HTML entities and special characters
* Fixed header widget area sometimes overlapping interactive content
* Fixed block editor font sizes using the incorrect 'regular' slug
* Fixed site title overlapping mobile menu toggler on certain configurations
* Fixed left sidebar navigation not being displayed when there are no widgets assigned
* Fixed incorrect scroll position after closing mobile menu on Firefox since v1.2.0
* Updated to Cryout Framework 0.8.5.6:
	* Fixed issues with font families that contain multiple words

= 1.2.0 =
*Release Date - 2020.12.16*

* Added accessibility for mobile menu
* Added 'Tested up to' and 'Requires PHP' header fields in style.css
* Improved handling of font weights
* Improved visibility of featured boxes images when no images are present
* Code cleanup and sanitization improvements according to the theme sniffer rules
	* Fixed empty else statements in core.php, landing-page.php, styles.php
	* Added extra sanitization in includes/landing-page.php, includes/meta.php, includes/core.php, admin/main.php
* Cleaned up and optimized frontend scripts, including for WordPress 5.5/5.6 jQuery updates
* Renamed content/author-bio.php file to content/user-bio.php to avoid name collision with WordPress' templating system
* Fixed plural forms in comments count for more complex languages - https://codex.wordpress.org/I18n_for_WordPress_Developers#Plurals
* Fixed non-prefixed global variables in content.php and comments.php
* Fixed logo using incorrect height after assignment in the customize preview
* Fixed accessibility for side menu
* Fixed malfunctioning preloader, header image and content animations with WordPress 5.6
* Fixed (hopefully) printing on Chrome prints the side menu background over the site content
* Fixed "Inherit General Font" option not working as expected
* Fixed team members photos having a weird aspect ratio after Team Members plugin update
* Updated to Cryout Framework 0.8.5.5:
	* Improved JS code to remove jQuery deprecation notices since WordPress 5.6
	* Changed custom post type label in breadcrumbs from singular_name to name
	* Added echo parameters to cryout_schema_microdata() and cryout_font_select() functions
	* Fixed color selector malfunction since WordPress 5.3
	* Fixed Select2 selectors no longer working with WordPress 5.6 on Firefox
	* Additional sanitization and even more sanitization changes to comply with current wp.org requirements

= 1.1.1 =
*Release Date - 2019.10.11*

* Fixed extra top margin on body when no header image is used
* Improved fixed mobile menu functionality to only execute when fixed menu option is enabled
* Fixed mobile side menu close button not usable in some instances since 1.1.0
* Fixed some landing page elements missing effects on older Edge releases due to :focus-within changes in 1.1.0

= 1.1.0 =
*Release Date - 2019.10.02*

* Fixed paragraphs indentation option not working
* Fixed boxes ratio issue
* Added 'esotera_header_image' and 'esotera_header_image_url' filters to allow custom control over featured images in header functionality
* Fixed breadcrumbs missing link on home icon on WooCommerce pages
* Added option to disable default pages navigation and improved mobile menu functionality to hide toggler when main navigation is empty
* Fixed 'wp_body_open' action hook support for WordPress versions older than 5.2
* Improved main navigation usability on tables by adding the option to force the mobile menu activation
* Fixed Gutenberg lists displaying bullets outside of content on landing page sections
* Improved list bullets styling in landing page text areas
* Improved dark color schemes support for HTML select elements
* Added visibility on scroll functionality on the fixed menu on mobile devices
* Improved mobile menu dark color schemes support by using non-link texts to use the configured menu text color
* Updated fixed menu styling to account for WordPress admin bar responsiveness breakpoints changes
* Improved keyboard navigation accessibility:
	* Added 'skip to content' link
	* Added focus support for post featured images, landing page featured boxes, landing page portfolio, main navigation search form
	* Converted menu close element to button
* Added support for future official child themes
* Updated to Cryout Framework 0.8.4.1:
	* Optimized options migration check to reduce calls
	* (Finally?) fixed 'Too few arguments' warning in breadcrumbs on Polylang multi-lingual sites
	* Removed news feed from theme's about page per TRT requirements - https://themes.trac.wordpress.org/ticket/73150#comment:3

= 1.0.0 =
*Release Date - 2019.07.04*

* Added option to enable/disable the static slider title animation
* Fixed sub-submenus under-menu indicators being always visible on the right margin
* Fixed sub-submenus having an extra bottom border
* Fixed items with sub-menus having no right padding
* Fixed hamburger menu button in the main navigation not being clickable in some cases
* Updated style.css description

= 0.9.1 =
*Release Date - 2019.06.23*

* Fixed submenus having wrong background color on IE11 and Edge
* Fixed Site Title not being vertically aligned on some rare occasions on Chrome
* Fixed Site Title size on mobile on Chrome
* Scaled down menu items size on mobile
* Fixed dot character being inside link in footer link

= 0.9 =
*Release Date - 2019.06.21*

* First Esotera release
