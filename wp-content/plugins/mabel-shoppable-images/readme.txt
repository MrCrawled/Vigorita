=== Shoppable Images ===
Contributors: studiowombat,maartenbelmans
Tags: shoppable images,image hotspots,woocommerce,click to buy,tag image
Requires at least: 4.5
Tested up to: 5.5.1
Stable tag: 1.3.0
Requires PHP: 5.6

== Description ==

The pro version of the plugin.

== Changelog ==

= version 1.3.0 =
 * Update: rewrote styling of the popups to modern CSS resulting in smaller frontend code.
 * Fix: some UI enhancements on mobile.
 * Fix: removed some redundent code, making the codebase smaller.
 * Fix: improved license manager, resulting in less requests to our external server.
 * Other: minimum required WC & WP versions changed. We'll guarantee backward compatibility for 3 more updates. Also added PHP version tag.

= version 1.2.8 =
 * Fix: fixed a unicode escaping bug.

= version 1.2.7 =
 * Fix: fixed a bug where non-WooCommerce shoppable image weren't editable.

= version 1.2.6 =
 * Completely remove older code (which was deprecated in PHP 7.2)

= version 1.2.5 =
 * Fix: fixed an issue with data "icon" attributes.
 * Fix: CSS issue with images that are not going full width in the parent.

= version 1.2.4 =
 * Update: added WooCommerce "tested upto" tags.

= version 1.2.3 =
 * Update: added a few filters to make the plugin extendable for developers.

= version 1.2.2 =
 * Fix: fixed issue with opening the popups on hover.
 * Fix: popup wasn't closing when clicking outside the image.

= version 1.2.1 =
 * Added: option to open the popup while hovering the tag instead of clicking.
 * Update: the displayed price now takes into account sales price and WooCommerce currency settings.
 * Update: ability to change the WordPress capability to edit the plugin settings.
 * Fix: cleaned up some outdated CSS.
 * Fix: fixed issue with range sliders in the backend.

= version 1.2.0 =
 * Update: "add to cart" fragments are now reloaded when a product was added to cart.
 * Fix: fixed a bug where the color picker wasn't loading on the admin settings screen.
 * Fix: fixed a bug where the button foreground color wasn't set.
 * Update: minor CSS additions for theme compatibility.

= version 1.1.1 =
 * Fix: fixed bug where in some cases images aren't editable in backend.

= version 1.1.0 =
 * Added: ability to add product straight to cart (via ajax).
 * Added: animations for smoother UX.
 * Added: support for variable products.
 * Added: more design options.
 * Update: performance improvements.
 * Fix: CSS fixes.

= version 1.0.5 =
 * Update: updated image sizes.
 * Add: added option to select prefered image size for the shoppable cards.
 * Update: check Woo 3.5+ compatibility.


= version 1.0.4 =
 * Enhancement: if a product doesn't exist anymore, it won't be loaded when editing an image in the backend.

= version 1.0.3 =
 * Enhancement: Better loading of Woo products on the backend.

= version 1.0.2 =
 * Fix: Small mobile enhancement.

= version 1.0.1 =
 * Fix: Remove get_display_price in favor of get_price.

= version 1.0.0 =
 * Initial version.