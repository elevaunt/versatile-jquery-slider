# Versitile jQuery Slider

Set up an easy, versatile, responsive slider with images or any HTML content.  Powered by jQuery Cycle2.

## Description

The Versatile jQuery Slider helps you set up an easy, versatile, responsive slider with images or any HTML content.  Powered by [jQuery Cycle2](http://jquery.malsup.com/cycle2).

I’ve often looked for a good plugin that would allow me to quickly and easily add the jQuery Cycle2 plugin to a site, but I couldn’t find any good ones… so I built this.  Basically, the Versatile jQuery Slider (VJS Slider) is a wrapper that pulls in most of the available options into a shortcode for easy use. So you’ll want to check out the [jQuery Cycle2 options](http://jquery.malsup.com/cycle2/api) to know what is available.

The nice part is, the jQuery Cycle2 scripts are only loaded on the pages that they are used on, and only the necessary scripts are loaded.  So if you need the carousel plugin, it will automatically be added in if the `fx` attribute is set `carousel`.  You need to center vertically?  Set the `center-vert` attribute to `true`.

Easy as that!


### Demos =
Check out the [demos page](http://elevaunt.com/plugins/versatile-jquery-slider/demos).

### Parameters =
VJS Slider has some unique paramaters that jQuery Cycle2 doesn't have.  Also there are a some changes to a few of the jQuery Cycle2 parameters.  [Check them out](http://elevaunt.com/plugins/versatile-jquery-slider).


## Installation

1. Install the plugin through the WordPress plugins screen directly by searching for Versatile jQuery Slider, or upload the plugin files to the `/wp-content/plugins/versatile-jquery-slider` directory
1. Activate the plugin through the 'Plugins' screen in WordPress


### Usage
To use the VJS Slider, you'll use the shortcode `[[vjs_slider] your slide code here [/vjs_slider]]`, then you're all set for the basic, default usage.

If you want to get fancy, follow along with the [jQuery Cycle2 demos](http://jquery.malsup.com/cycle2/demo), and wherever `data-cycle-attribute` is used, drop `data-cycle-` and all the rest is the same (in most cases).

I'm not going to list out all the options here because they are all very well documented on the [jQuery Cycle2 site](http://jquery.malsup.com/cycle2).  Check it all out over there, then make some cool stuff with the VJS Slider!


### Important Differences =
There are a couple important changes that had to be made because they wouldn't work with the shortcode.  The following attributes are affected:

* **slides**
If you use the `slide` attribute, don't add `>`, it will automatically be assumed.  If you use ' If you use `>` like the demos on the jQuery Cycle2 site show, then it will mess up the shortcode and your slider won't work.

* **next** and **prev**
If you want to set your own selectors for next and prev, you'll need to add your own CSS.
***Note:*** if the navigation elements are inside the slider container they will be hidden by default. (see `navs `attribute below).

* **slide-css**
This attribute is not used because it doesn't work reliably inside the shortcode. If you want slide specific CSS, just add your own class to your slide and add your own CSS.

* **swipe**
Swipe is turned on and the necessary js added automatically because let's face it, who doesn't want that?

### VJS Slider Specific Attributes =
VJS Slider has a few attribute unique to the plugin that are designed to help you out.

 * **id**
By default, the VJS Slider will have `id="vjs-slider"`. If you want to change it, use the `id` attribute. 
***Note:*** if you have more than one slider on the same page, make sure they all have a different id.

 * **class**
Give your slider a class and style to your heart's content.  By default all sliders will have the class `vjs-slider`. If you set one here, it will be in addition to that class.

 * **css**
VJS Slider comes with some very basic CSS.  If you don't want to use it, set the `css` attribute to `false`. Then you can use your own without having to override anything.

 * **ie-fade**
Set to `true` to include the fade/fadeout plugin for old versions of IE. This plugin corrects issues that arise when cleartype is used with opacity. See the [jQuery Cycle2 docs](http://jquery.malsup.com/cycle2/download/).
 * **navs**
This will enable next and prev navigation links. Set to `inside` for the links to live inside the slider container. Set to `outside` for the links to live outside the slider container. 
***Note:*** If set to `outside`, you'll need to add your own CSS to make things look right.

 * **nav-next**
When **navs** are enabled, the default will create a right arrow link. Use this attribute to change it to something else. It will accept plain text, `img` tag, or any html.

 * **nav-prev**
When **navs** are enabled, the default will create a left arrow link. Use this attribute to change it to something else. It will accept plain text, `img` tag, or any html.

 * **nav-selector**
Give the navigation wrapper a class or id so that you can style as you wish.

 * **theme-fix**
Sometimes a theme includes a version of jQuery Cycle (usually it's an older version). When this happens, it will create a conflict with VJS Slider. Set this attribute to `true` to fix the conflict.

 * **width**
By default, the slider container will expand the full width of it's parent container. You can set your own width with this attribute .


## Frequently Asked Questions

### Where can I find detailed instructions =

You can view the docs at the [Versatile jQuery Slider plugin homepage](http://elevaunt.com/plugins/versatile-jquery-slider).  There you'll find an overview of how to use the shortcode.  For details regarding all the available parameters, please see the [jQuery Cycle2 plugin options page](http://jquery.malsup.com/cycle2/api).

### My HTML slides aren't working =

Make sure you've included the `slides` parameter and correctly set it's value to the element of each slide (e.g. `div` or `span`).  Also make sure you did not include `>`, the VJS Slider will take care of that part for you.

### The slider looks like it works, but then it just breaks =

First double checked that you don't have any typos (missing quotes, etc).

Next, make sure that you've structured everything inside the shortcode correctly (see the [VJS Slider demos](http://elevaunt.com/plugins/versatile-jquery-slider) and the [jQuery Cycle2 demos](http://jquery.malsup.com/cycle2/demo)).

If you're still having problems, there's a chance that your theme includes a version of jQuery Cycle2.  Try adding `theme-fix="true"` as a parameter and that should do the trick.
