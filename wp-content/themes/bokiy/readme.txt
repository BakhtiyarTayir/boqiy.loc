=== Boss. ===
Contributors: BuddyBoss
Requires at least: 3.8
Tested up to: 5.4.2
Version: 2.5.7
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==

Boss is a responsive WordPress/BuddyPress theme that provides a whole new way of visualizing BuddyPress.

== Installation ==

1. Make sure BuddyPress is activated.
2. Visit 'Appearance > Themes'
3. Click 'Add New'
4. Upload the file 'boss.zip'
5. Upload the file 'boss-child.zip'
6. Activate 'Boss Child Theme' from your Themes page.

== Changelog ==

= 2.5.7 =
* Fix - Elementor Stretch section width issue in theme
* Fix - Fatal error on group creation steps
* Fix - BadgeOS points are not showing on profile page
* Fix - Broken layout on groups page with BuddyPress Docs plugin
* Fix - Missing 'bp-legacy-css' warning in query monitor
* Fix - Topic title, Forum Title changes after bbPress update
* Fix - When Extended profiles are disabled, Profile photo has 404 on click 

= 2.5.6 =
* Fix - Login screen layout issue after WordPress 5.3 update
* Fix - Some Notice after WordPress 5.3 update
* Fix - Private Message page styling due to plugins update
* Fix -	Fatal Error due to buddyboss_media() function
* Fix - Site Notice section looks broken after BP update
* Fix - Improved Styling on Registration page
* Fix - Some options are not available in Customizer after page loads
* Fix - LearnDash Matrix Sort Quiz not scrolling when dragging to bottom on Boss Theme
* Fix - Fix BuddyBoss product changelog issue- updated link of release notes page.

= 2.5.5 =
* Fix - Notification,Members,My Friends counts were not coming with span element.
* Fix - Improved styling of BuddyPress Docs pages
* Fix - Member Menu items having blank bubbles in Mobile
* Fix - Styled Tabs coming short code
* Fix - Display Cart Icon for Mobile screen

= 2.5.4 =
* Fix - Spacing/positioning issues with elements in desktop titlebar
* Fix - Crop ratio for logo uploaded as SVG

= 2.5.3 =
* Fix - Course Grid 1.5.4 version is breaking the Boss theme's layout
* Fix -	Elements styling on Course Activity page

= 2.5.2 =
* Fix - Notification bubble issues with profile dropdown menu in WordPress 5.2
* Fix - WordPress default categories widget issues with Select2 dropdowns
* Fix - Profile photo cover disabled when xProfile is not active
* Fix - Activtity auto loading function changes
* Fix - rtMedia plugin not showing updates in activity filters
* Fix - Left panel dropdown on mobile not working correctly sometimes
* Fix - Issue with menu icons on profile links

= 2.5.1 =
* Fix - Missing Profile menu in mobile with WordPress 5.1

= 2.5.0 =
* Fix - Updated Modernizr library
* Fix - Undefined variable error
* Fix - Fixed events manager template override issue
* Fix - Same Id is being used twice to create the search form
* Fix - Search scroll on mobile creates a lot of blank space at the end of the page
* Fix - Geodirectory plugin conflict with Font Awesome icons.
* Fix - Left Buddypanel menu not working on a mobile device on click
* Fix - Buddypanel icons broken on Boxed layout.
* Fix - Improve style of group manage page elements
* Fix - The icons applied on titlebar menus do not work on mobile device.

= 2.4.9 =
* Fix - Pagination design changes for learndash pages and widgets
* Fix - LearnDash - course progress widget fixed
* Fix - Navigation menu supports multiple classes
* Fix - Font Awesome icon family removed and used default family for all icons
* Fix - BuddyPanel- counts position in close state of buddypanel
* Fix - Theme Styling color setting was not getting applied on fontawesome icons

= 2.4.8 =
* Fix - Missing Login/Logout icons in the mobile layout
* Fix - some icons were not appearing after fontawesome update
* Fix - Social media icons loading issue
* Fix - Search Box getting overlapped on Insert Link tab of message content editor
* Fix - Design improvement on the register page
* Fix - Group cover photo change cover photo missing icons
* Tweak - Improved pagination styling on friends listing page
* Tweak - Alignment of elements on the group setting page
* Tweak - BuddyPress message username area having extra height

= 2.4.7 =
* Tweak - Override buddyboss-wall entry.php template
* Tweak - Fontawesome 5.0 upgrade
* Fix - The submenu is unable to show menu icons if we set BuddyPress menu items to be as a submenu
* Fix - Media and Wall plugin style improvements
* Fix - Boss theme changes the login form with disabled custom login styling
* Fix - When a normal user of a hidden group try to add new doc, The new doc page looks messy
* Fix - Avatar style glitch in activity comment
* Fix - BuddyPress nav menu items visibility issue on profile page
* Fix - Social Media Link does not save without http/https
* Fix - Fitvids script re-start the running video from the beginning on a heartbeat
* Fix - VC issue with Stretch Row in the Boss theme, CSS code adds margin to the left side
* Fix - Added missing closing bracket on login page inline style
* Fix - Search result types icons are not displaying properly in mobile
* Fix - Various PHP and Javascript warning/error fix

= 2.4.6 =
* Fix - Declared BuddyPress legacy template pack support
* Fix - Member profile page display Fatal error if Extended Profile component disable
* Fix - Fixed live notification update not updating the Message count
* Fix - Check unread notifications count before sending notifications content
* Fix - Improved styling of Members and Activity directories
* Fix - Change cover image redirect to 404 page when profile slug translated
* Fix - Ensure is_plugin_active function is loaded
* Fix - Site home menu missing in admin bar for the non-admin users
* Fix - Social Learner - Learndash pagination style added
* Fix - Removed deprecated WooCommerce function calls
* Fix - Various PHP warning/notices fixed

= 2.4.5 =
* New - LearnDash pagination button style added
* Fix - Fatal error on member profile page if activity component is disabled
* Fix - JavaScript error in old browsers due to use of es6 function

= 2.4.4 =
* New - Better support for WP Job Manger plugin
* Performance - Removed admin-init.php loading on the frontend.
* Tweak - Display category description on category archive page
* Tweak - Change BuddyPress Docs templates textdomain
* Tweak - BuddyPress 3.0 Retire Legacy Forums
* Tweak - BuddyBoss Media's Album selection box styling fix on the activity page
* Fix - The "See all" link in member cover is showing badges earned by logged in user instead of displayed users
* Fix - Slider disappears while switching to RTL language
* Fix - Various Javascript errors
* Fix - Header not appearing properly in RTL language
* Fix - BuddyView's Verified badge not showing on member header profile cover
* Fix - Typography setting does not have an effect on Page title
* Fix - Remove "See All" link from member's header cover if BadgeOS community add-on is not active
* Fix - Fixed Redux theme options styling glitch
* Fix - Display site title above login form
* Fix - Duplicate description field on the members profile edit page
* Fix - Profile menu items disappears due to white backgrounnd and white text color in some color preset
* Fix - Last menu item is not visible when wpadminbar is visible and buddypanel is fix
* Fix - Submenu not appearing if it has many tabs and BuddyPanel has fixed position
* Fix - Reposition profile sub menu wrap overflow to pop on top instead of on the bottom part
* Fix - Redux setting options style glitch fix
* Fix - Cropped Members adminbar/my-account menu fix
* Fix - Wrap long links in the message tread so it does not bust out of container
* Fix - Category widget Broken when having a sub categories
* Fix - Admin bar is showing up for all users when it enabled from Boss theme settings
* Fix - Ability to exclude selectbox from injecting custom markup
* Fix - Visual Composer stretched row content going beneath BuddyPane and Sidebar
* Fix - Better styling for smaller devices
* Fix - Redux textdomain conflict when loco translate plugin is active
* Fix - Fix blurred featured cover image on the single blog post

= 2.4.3 =
* Fix - Country field layout on checkout page
* Fix - Conflict between Select2 and Boss theme responsive dropdown
* Fix - Backwards compatibility for inline search form

= 2.4.2 =
* Fix - New message are not appearing in the header notification from the homepage
* Fix - Body Font Color theme setting option not appearing
* Fix - Display post category on the next line in Recent Posts widgets
* Fix - BuddyPress Docs history tab is throwing fatal error if buddypress groups component is disabled
* Fix - Remove duplicate close icon from the buddypress notice
* Fix - Difficult to click profile photo upload button or cover photo upload button on iPhone
* Fix - BuddyPanel color settings also influence body background
* Fix - The arrow icons in the BuddyPanel should be right angled
* Fix - 3rd level menu is not appearing on profile navigation menu
* Fix - BuddyBoss Inbox styling improvements
* Fix - Moved cart icon from the subheader to the main header
* Fix - Strip shortcodes from the post content in recent post widgets
* Fix - Blurred group profile picture even when uploaded photo is larger than the 400 X 400
* Fix - Many smaller styling improvements
* Fix - Comments appear twice for BuddyPress Docs

= 2.4.1 =
* Fix - RTL support issue fixed
* Fix - Link option available in editor only when we reply for an message but not available while composing a message
* Fix - RTL fixes for Pagination arrow
* Fix - Course name fixes for font size in progress widget
* Fix - Mobile Nav menu Fixes
* fix - Styling issues on Course page
* Fix - Group sidebar scroll fix
* Fix - First post of members/user blog post is not appearing on iPhone5

= 2.4.0 =
* Fix - Notifications bell icon is not working
* Fix - New update enables toolbar, disabling toolbar from BuddyPress setting hides login/register button at frontend
* Fix - Blurred profile images inside groups -> manage -> members when trying to change from admin dashboard
* Fix - WPGlobus support issue
* Fix - Header title color changes
* Fix - When using Badge OS BB displays badges that are marked hidden to users
* Fix - Buddypress Docs comments not displaying
* Fix - Shopping cart disappears on mobiles
* Fix - Old version of swiper
* Fix - Conflict with ACF / Events Manager and Boss theme
* Fix - Message not showing when show_admin_bar set false
* Fix - User avatar when WooCommerce activated
* Fix - WooCommerce styling tweaks
* Fix - Profile menu scroll bar issue
* Fix - Notification dropdown menu scroll ba
* Fix - Global search php notice fix


= 2.3.3 =
* Fix - Woo 3.0 Select2 support

= 2.3.2 =
* Tweak - Better compatibility with Learndash 2.4
* Fix - Compatibility issue with "Subscribe to Comments"
* Fix - Group Forum Text Formatting and some spacing issue

= 2.3.1 =
* Tweak - Better compatibility with Locations for BuddyPress

= 2.3.0 =
* New - Added German translations
* New - Added Spanish translations
* Fix - Updated FontAwesome to v4.7
* Fix - Button Style in Group cover photo page
* Fix - BP Notification icon issue
* Fix - Logo/Titlebar Spacing and Height issues
* Fix - Following and Followers not displaying on a mobile phone
* Fix - Cover photo recommended size corrected helper text
* Fix - Cover photo issue on BuddyPress Docs page
* Fix - Messages profile page on iPad Landscape Broken
* Fix - Group title meta changed after Boss 2.2 update
* Fix - Styling issues on mobile with layer slider
* Fix - Javascript conflict with Beaver Builder
* Fix - "Select Your File" button under change profile cover not working on Edge browser
* Fix - Multiline Profile Field in Boss Theme not completely displaying Rich Text
* Fix - bbPress single reply page formatting
* Fix - Support for the custom Front Pages for your users profiles (BP 2.6 compatibility)
* Fix - Profile dropdown does not work properly on iPads with desktop version
* Fix - When uploading Big size cover photo to group it shows error message
* Fix - Titlebar 3rd level menu is not appearing on mobile devices
* Fix - When Masonry view is enabled on global photos page, Edit tab looks broken
* Fix - Homepage margin formatting
* Fix - Boxed layout formatting
* Fix - BuddyPanel stacking 2 FontAwesome icons on one another not working
* Fix - Create group button is missing on Group directory page
* Fix - BuddyBoss menu item created in main site of multi-site
* Fix - No titlebar menus when you go to the site from Twitter
* Fix - Theme options styling settings
* Fix - Error/warning when trying to disable/enable BuddyPress
* Fix - Bug in image resize function
* Fix - Error 'Uncaught ReferenceError'
* Fix - PHP warning when composing new message with BuddyBoss Inbox

= 2.2.2 =
* Fix - Logo spacing in Social Learner
* Fix - Color preset gets lost over time on ajax save
* Fix - Getting  "Array Array Array" error in notifications
* Fix - Better compatibility with rtMedia
* Fix - Group cover photo issue

= 2.2.1 =
* Fix - Compatibility with BuddyPress 2.6 navigation APIs
* Fix - After BuddyPress 2.6 update, tabs became misaligned on BP messaging page
* Fix - Dropdown broken on starred messaging tab
* Fix - Tabbed feature not showing nicely with WooCommerce 2.6 update

= 2.2.0 =
* Fix - BuddyPress Docs Integration Issues
* Fix - HTTPS Mixed Content issue with redux
* Fix - Cover photos not visible to visitors
* Fix - Cover photo issue on Events Manager related profile pages
* Fix - Footer Navigation styling issues in Mobile/Responsive
* Fix - Cart Styling issues on Mobile
* Fix - WangGuard CSS fix for buttons
* Fix - Blog Featured Image upload size issue
* Fix - Profile User Dropdown text is white on white
* Fix - Conflicts with GD bbPress Toolbox (re-test)
* Fix - Add support for WPML translation plugin on Image slider
* Fix - Tumbler icon missing on Social Login
* Fix - Add support for "WooCommerce for BuddyPress" plugin
* Fix - rtMedia issue with Profile cover photo
* Fix - Issues with "Group Email Subscription" plugin
* Fix - Minor issue with Yoast SEO
* Tweak - Add topic title to the page html title
* Tweak - Rename "Slides" in wp-admin
* Tweak - Scroll back up after loading next page or other page index pages

= 2.1.8 =
* Fix - Homepage CSS when using Page Builder
* Localization - French translations updated, credits to Jean-Pierre Michaud

= 2.1.7 =
* Fix - Random cover photo option, remapped to BuddyPress core method
* Fix - Cover photo duplicates in media library
* Fix - Show default cover image instantly after removing
* Fix - Update cover photo, redirecting to 404
* Fix - BuddyBoss Inbox plugin, message draft thread-star column removed
* Fix - BP Edit Activity plugin, media button style
* Fix - PHP notices
* Fix - Display default supported social site icon

= 2.1.6 =
* Fix - Titlebar formatting, with Boss for Sensei disabled
* Fix - Boss for Sensei filters
* Fix - Login button alignment

= 2.1.5 =
* Fix - Restored Social Icon settings in admin, from older releases

= 2.1.4 =
* Fix - Social Icons on profile interface and back compatibility
* Fix - PHP notice with Events Manager plugin
* Fix - PHP notice with BuddyPress User Blog plugin
* Fix - Added missing translation strings
* Fix - Social Learner, Course Progress widget styling

= 2.1.3 =
* Fix - Titles in BuddyPress pages
* Fix - Tab icon positioning

= 2.1.2 =
* Fix - Logo area colors

= 2.1.1 =
* Tweak - Social Learner compatibility (no child theme needed anymore)
* Tweak - Better method for loading FontAwesome
* Fix - Titlebar links hover color setting is not working
* Fix - Forum titles need space from left
* Fix - Single forum topic, button positioning
* Fix - Group delete warning color
* Fix - Auto suggestion of username color
* Fix - Child dropdown menu styling
* Fix - Right dropdown is not working on notification URL
* Fix - Notification radio buttons are not visible
* Fix - In Boxed layout, Group title and info need extra margin from left
* Fix - Visual error when making a status update
* Fix - WooCommerce notice styling
* Fix - Member header button styling
* Fix - Social Articles plugin compatibility
* Fix - Group Cover images look broken in Boxed layout
* Fix - Social fields compatibility with Gravity Forms
* Fix - Group Cover Image improvements
* Fix - RTL (right to left) fixes
* Fix - Code cleanup
* Fix - PHP notices
* Various CSS fixes

= 2.1.0 =
* Fix - Support older versions of PHP

= 2.0.9 =
* New - Slider shortcode option for alternative slider plugins (credits to Jean-Pierre Michaud)
* Fix - After post updates on activity page, What's New section is overlapping
* Fix - Single post header image
* Fix - Single Event Page when Event Manager is not active
* Fix - Group Cover Image
* Fix - Duplicate Profile Fields
* Fix - SiteOrigin shortcode popup

= 2.0.8 =
* Tweak - Compatibility with BuddyPress User Blog
* Fix - Archive template, standard title output

= 2.0.7 =
* Fix - Social Learner "No BuddyPanel" dropdown highlights

= 2.0.6 =
* Fix - slider transition between desktop and mobile
* Fix - "No BuddyPanel" dropdown highlights
* Various CSS fixes

= 2.0.5 =
* Fix - faster font loading
* Fix - icon sizes on mobile titlebar

= 2.0.4 =
* Fix - post button compatibility with BuddyPress 2.4.0
* Fix - slider image crop issues
* CSS updates for BuddyPress Docs
* CSS updates for invite lists
* Screenreader text

= 2.0.3 =
* Improved compatibility with BuddyPress Docs
* Improved compatibility with WooCommerce
* Front page template fix
* Activity fixes
* Directory page fixes
* Boxed layout fixes
* Fixed Visibility issue BuddyPress item-nav dropdown

= 2.0.2 =
* Improved compatibility with WordPress Social Login
* Improved compatibility with Paid Memberships Pro
* Improved compatibility with BuddyPress Docs
* Improved compatibility with BuddyPress Groups Heirarchy
* Improved compatibility with Gravity Forms
* Fixed error with BuddyPress disabled
* Fixed slider responsive content issue
* Boxed layout improvements
* RTL fixes
* Widget login fixes
* Various CSS fixes

= 2.0.1 =
* Enabled comment form for logged out users
* Fixed updating "Body" font size in Boss options
* Fixed Slider issues
* Fixed xProfile fields showing duplicated on some sites
* Fixed input formatting when Javascript is disabled
* Fixed notices and errors
* Added modular footer
* Linked current logged-in user Avatar with Edit Profile Photo link
* BuddyPanel displays in fixed position again
* Showing logout link on mobile navigation
* Updated Recommended plugins list
* Fixed BuddyBoss Media path in support list
* Various CSS fixes

= 2.0.0 =
* New - Overhauled admin options using Redux framework
* New - Import/Export admin options
* New - "Boxed" layout option
* New - Huge typography selection from Google font library
* New - Custom Admin Login styling and logo options
* New - Default photo option for cover photos
* New - Remove/refresh cover photos on front-end
* New - Edit footer text option
* New - Custom CSS, JavaScript, Tracking Code options
* New - Optimization options for minifying CSS and JavaScript
* New - View and activate recommended plugins options
* New - Upload favicon from Customizer
* New - Watch tutorial videos in admin
* Improved titlebar menu script
* Improved slider script
* Improved support for BuddyPress Documents
* Disable shortcodes when Visual Composer is enabled
* Fixes for iOS
* Fixes for Android
* Various CSS fixes

= 1.2.2 =
* Switched to new Updater system
* Standard readme.txt format
* New - Support for RTL (Right to Left) languages
* New - Remove/Refresh cover photo buttons
* Improved support for BuddyForms
* Improved support for BuddyPress Documents
* 'the_excerpt' is now only used within search pages, per WP standards
* Undefined function fix
* Fixed PHP notices
* Disable shortcodes when Visual Composer is enabled
* Fixed Messages checkboxes
* Fixed Error if BuddyPress is not Active
* Fixed two blog post titles showing for single post
* Fixed for iOS9
* Various CSS fixes

= 1.2.1 =
* Enhanced support for BP Group Hierarchy
* Enhanced support for BP Group Hierarchy Propagate
* Enhanced support for BuddyBoss Inbox
* Enhanced support for BuddyPress Docs
* Enhanced support for BuddyPress Groups Extras
* Enhanced support for BuddyPress Docs Wiki add-on
* Enhanced support for GD bbPress Attachments
* Enhanced support for Invite Anyone
* Improved WooCommerce styling on mobile
* Improved selectbox styling
* Better cover image notice placement
* Fixed issues with stock Android
* Fixed issues with minimum logo height
* Various CSS fixes

= 1.2.0 =
* Fixed mobile header height with adminbar
* Fixed My Profile menu location for mobile
* Fixed styling for mobile profile menu
* Fixed bulk edit saving issue for slides
* Fixed deprecated constructor method for WP_Widget
* Better plugin compatibility with BuddyForms
* Better plugin compatibility with WooCommerce

= 1.1.9 =
* Option to display WordPress toolbar for admins, at Appearance > Customize > Layout Options
* Fixed issues with cover photo upload icon disappearing
* Fixed profile error message when Friends Component is disabled
* Fixed selectbox styles
* Fixed group image uploads for iOS
* Better plugin compatibility with WooCommerce
* Better plugin compatibility with rtMedia
* Better plugin compatibility with BuddyPress Activity Privacy
* Better plugin compatibility with our upcoming BuddyBoss Inbox plugin
* Various CSS fixes

= 1.1.8 =
* Compressed images, saves 1.7mb of space
* LearnDash compatibility
* Improved documentation
* Fixed front-page post pagination
* Fixed issues with cover photo cropping
* Fixed comment padding
* Fixed PHP errors with notifications off
* Fixed extra links in profile dropdown

= 1.1.7 =
* Better compatibility with WooCommerce
* Better compatibility with WooThemes Sensei
* Fixed paragraph spacing in comments and messages
* Fixed spacing between first level replies in activity
* Fixed "Search Messages" text visibility
* Friend vs Friend(s) logic added to profile header
* Accept jpeg filetype for Cover Photo
* Starred messages compatibility for BuddyPress 2.3
* "Change Profile Photo" compatibility for BuddyPress 2.3
* Faster loading of filter styles
* Fixed PHP error "Notice: Undefined offset: 1"

= 1.1.6 =
* Default button on profiles is now "Private Message", instead of "Cancel Friendship"
* Improved activity post-form layout
* Allow users to select default Accordion item in shortcode
* Added Customizer option for mobile titlebar color
* Added French language translations, credits to Jean-Pierre Michaud
* Selectbox fixes
* Filter fixes
* Video embed width fixes
* Logo height fixes
* Search fixes
* Social links fixes
* Improved panel scrolling
* Better WooCommerce CSS compatibility
* Better rtMedia compatibility
* Better Form Maker compatibility

= 1.1.5 =
* CSS compatibility with new Privacy feature in BuddyBoss Wall plugin
* Fixed mobile panels not opening after rotation
* Fixed mobile titlebar icon selection
* Fixed mobile messages width
* Fixed mobile WooCommerce coupon code layout

= 1.1.4 =
* Social Icons in footer, set in Customizer
* Improved WooCommerce styling
* Better mobile support for WooCommerce
* Display profile links to Subscribers with WooCommerce enabled
* Fixed mobile device Cover Photo uploading
* Message template updated for latest BuddyPress compatibility
* Improved dialogs in WordPress admin
* Fixed Social fields code errors
* CSS fixes for Firefox

= 1.1.3 =
* Search color for No BuddyPanel template
* Customizer selection for Body font
* Customizer selection for Body text color
* Customizer selection for Footer bottom text color
* Customizer selection for titlebar
* Directory content fixes

= 1.1.2 =
* Improved WooCommerce plugin styling
* Better support for Sensei plugin
* Fixed theme updates losing customizations (removed options.css)
* Fixed issues with video embed sizing
* Fixed padding above profile avatar on mobile panel
* Fixed Blog index widget/sidebar logic
* Fixed desktop header logo showing on mobile
* Mobile CSS fixes

= 1.1.1 =
* Improved support for WooCommerce plugin
* Improved support for BP Profile Search plugin
* Admin option to enable/disable Activity infinite scrolling
* Fixed error when paginating in your Friends list
* Fixed Sensei plugin notice bug
* Fixed Slider notice bug
* Datebox CSS fix

= 1.1.0 =
* CSS fixes for mobile header
* CSS fixes for flickering on Activity

= 1.0.9 =
* Added mobile device detection, with media query fallback
* Added button to manually switch between Mobile or Desktop layout
* Added Infinite Scroll for activity
* Added Customizer color options for "No BuddyPanel" template
* Re-organized Customizer, to handle new options
* Added Charset options for better font handling
* Support for Sensei plugin
* Improved CSS and JS for tables
* Fixed Blog template showing sidebar with no widgets added
* Fixed Notification tables
* Fixed menu header sublists
* Better font previewing in Customizer

= 1.0.8 =
* Fixed PHP error causing white screen on Bluehost

= 1.0.7 =
* Changed cover photo icon to Camera, more intuitive
* Fixed gray square when updating cover photo
* Fixed live preview of all fonts
* Improved font loading

= 1.0.6 =
* Fixed theme updating breaking Customizer settings in options.css
* Better compatibility with plugins Gravity Forms and Formidable PRO
* Correct "Page" icons for titlebar links added to mobile panel
* Fixed CSS issues on bbPress forums
* Added missing translation strings for bbPress
* Font loading fixes
* CSS, JS, and PHP cleanup

= 1.0.5 =
* Load only selected fonts on front-end
* Global Search dropdown hover
* Fixes for "No BuddyPanel" full screen template
* Avatars added to child theme now take over
* Mobile search fixes
* Better CSS for plugin BP Group Documents
* Better CSS for plugin Gravity Forms

= 1.0.4 =
* Option to hide BuddyPanel from logged out users
* New page template to hide BuddyPanel
* Option to display search in mobile titlebar
* Added missing language translations
* Fixed duplicate notification counter in desktop right panel

= 1.0.3 =
* Added notification counters to relevant BuddyPanel links
* Fixed bug preventing subscriber-level users from changing group cover photo

= 1.0.2 =
* Added more font options: Ubuntu, Montserrat, Raleway, Cabin, PT+Sans
* Fixed Group Invitations layout
* Improved profile header alignment
* Displaying Homepage Slider buttons on mobile layout

= 1.0.1 =
* Compatibility with upcoming BuddyPress 2.2
* Minor UI improvements

= 1.0.0 =
* Initial public release
