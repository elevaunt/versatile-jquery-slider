<?php
/*
Plugin Name: Versatile jQuery Slider
Description: Set up an easy, versatile, responsive slider with images or any HTML content.  Powered by jQuery Cycle2.
Version: 1.0
Author: Lee Porter
Plugin URI:  http://www.elevaunt.com/plugins/versatile-jquery-slider
Author URI:  http://www.elevaunt.com
*/

/*
 
Shortcode for the jQuery Cycle2 plugin by malsup <a href="http://jquery.malsup.com/cycle2/">http://jquery.malsup.com/cycle2/</a>

License:     GPL2

Versatile jQuery Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Versatile jQuery Slider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Versatile jQuery Slider. If not, see {License URI}.

*/


function vjs_slider( $atts, $content = null ) {

  $vjs_settings = shortcode_atts( array(
    'class'         => '',
    'css'           => 'true',
    'id'            => 'vjs-slider',
    'ie-fade'        => '',
    'navs'          => '',
    'nav-next'      => '<img src="' . plugins_url( '/img/arrow-right.png', __FILE__ ) . '" >',
    'nav-prev'      => '<img src="' . plugins_url( '/img/arrow-left.png', __FILE__ ) . '" >',
    'nav-selector'  => '',
    'theme-fix'     => '',
    'width'         => '',
  ), $atts );

  $vjs_opts = shortcode_atts(array(
    // standard options
    'allow-wrap'          => '',  // Default is true
    'auto-height'         => '',  // Default is 0  // setting this option to false disables autoHeight logic
    'auto-selector'       => '',  // Default is '.cycle-slideshow[data-cycle-auto-init!=false]'
    'caption'             => '',  // Default is '> .cycle-caption'
    'caption-template'    => '',  // Default is '{{slideNum}} / {{slideCount}}'
    'delay'               => '',  // Default is 0
    'disabled-class'      => '',  // Default is 'disabled'
    'easing'              => '',  // Default is null
    'fx'                  => '',  // Default is 'fade'
    'hide-non-active'     => '',  // Default is true
    'loader'              => '',  // Default is false
    'loop'                => '',  // Default is 0
    'manual-fx'           => '',  // Default is undefined
    'manual-speed'        => '',  // Default is undefined
    'manual-trump'        => '',  // Default is true
    'next'                => '',  // Default is '> .cycle-next'
    'next-event'          => '',  // Default is 'click.cycle'
    'overlay'             => '',  // Default is '> .cycle-overlay'
    'overlay-template'    => '',  // Default is '<div>{{title}}</div><div>{{desc}}</div>'
    'pager'               => '',  // Default is > .cycle-pager
    'pager-active-class'  => '',  // Default is cycle-pager-active
    'pager-event'         => '',  // Default is click.cycle
    'pager-event-bubble'  => '',  // Default is undefined
    'pager-template'      => '',  // Default is '<span>&bull;</span>'
    'pause-on-hover'      => '',  // Default is false
    'prev'                => '',  // Default is '> .cycle-prev'
    'prev-event'          => '',  // Default is 'click.cycle'
    'progressive'         => '',  // Default is false
    'random'              => '',  // Default is false
    'reverse'             => '',  // Default is false
    'slide-active-class'  => '',  // Default is 'cycle-slide-active'
    'slide-class'         => '',  // Default is cycle-slide
    // 'slide-css'           => '',  // Default is { position: 'absolute', top: 0, left: 0 } -- Used on the slide element 
    'slides'              => '',  // Default is '> img'
    'speed'               => '',  // Default is 500
    'starting-slide'      => '',  // Default is 0
    'sync'                => '',  // Default is true
    'timeout'             => '',  // Default is 4000
    'tmpl-regex'          => '',  // Default is '{{((.)?.*?)}}'
    'update-view'         => '',  // Default is 0

    // carousel plugin
    // REQUIRES CAROUSEL PLUGIN
    'carousel-fluid'      => '',  // Default is false
    'carousel-vertical'   => '',  // Default is false
    'carousel-visible'    => '',  // Default is as many as will fit  // Number of slides visible

    // center slides plugin
    // REQUIRES CENTER PLUGIN
    'center-horz'         => '',  // Default is false
    'center-vert'         => '',  // Default is false

    // REQUIRES SWIPE PLUGIN IF NOT USING JQUERY MOBILE
    'swipe'               => 'true',  // Default is false

    // youtube plugin
    // REQUIRES YOUTUBE PLIGIN 
    'youtube'                   => '',  // Default is false
    'youtube-autostart'         => '',  // Default is false
    'youtube-autostop'          => '',  // Default is true
    'youtube-allow-full-screen' => '',  // Default is true

    // extras
    'log'                 => '',  // Default is true

  ), $atts);

  $vjs_id       = $vjs_settings['id'];
  $vjs_fix      = '';
  $vjs_fix_dir  = '';
  if ( $vjs_opts['slides'] ) {
    $vjs_opts['slides'] = '> ' . $vjs_opts['slides'];
  //   $vjs_id = str_replace('"', '', $vjs_id);
  }
  // echo $vjs_settings['css'] == 'true';

  // If user wants default navs, add in the defaults
  if ( $vjs_settings['navs'] ) {
    if ( empty( $vjs_opts['prev'] ) ) {
      $vjs_opts['prev'] = '.cycle-prev';
    }
    if ( empty( $vjs_opts['next'] ) ) {
      $vjs_opts['next'] = '.cycle-next';
    }
  }


  $vjs_opts_filter  = vjs_get_camel_case_opts_list($vjs_opts);

  $vjs_div = '<div id="'. $vjs_settings['id'] .'" class="vjs-slider'. $vjs_settings['class'] .'"';
  if ( $vjs_settings['width'] ) {
    $vjs_div .= ' style="width:'. $vjs_settings['width'] .';"';
  }
  $vjs_div .= '>';

  // Setup the nav links
  $vjs_navLinks = vjs_nav_setup( $vjs_settings, $vjs_opts );

  // Add in the nav links 
  if ( 'inside' == $vjs_settings['navs'] ) {
    $vjs_div .= do_shortcode( $content ) . $vjs_navLinks . '</div>';
  } elseif ( 'outside' == $vjs_settings['navs'] ) {
    $vjs_div .= do_shortcode( $content ) . '</div>' . $vjs_navLinks;
  } else {
    $vjs_div .= do_shortcode( $content ) . '</div>';
  }

  // Register the CSS and JavaScript only when the plugin is used
  vjs_register_scripts( $vjs_settings, $vjs_opts, $vjs_fix_dir, $vjs_fix );

  // Add slider initiation js
  vjs_slider_init_script( $vjs_opts_filter, $vjs_id, $vjs_settings );
    
  return $vjs_div;
}

add_shortcode( 'vjs_slider', 'vjs_slider' );




function vjs_get_camel_case_opts_list( $vjs_opts ) {
  $vjs_camel_case_list = '';
  foreach (array_filter($vjs_opts) as $key => $value) {
    
    $key = str_replace(' ', '', ucwords(str_replace('-', ' ', $key)));
    $key = lcfirst($key);

    $vjs_camel_case_list .= "$key:";

    if ( is_numeric($value) ) {
      $vjs_camel_case_list .= "$value,";
    } else {
      if ($value == 'true') {
        $vjs_camel_case_list .= "true,";
      } elseif ($value == 'false') {
        $vjs_camel_case_list .= "false,";
      } elseif ($value == 'div' || $value == 'span' || $value == 'a') {
        $vjs_camel_case_list .= "'> $value',";
      } 
      elseif ( strpos($value, '{') !== false ) {
        $vjs_camel_case_list .= "$value,";
      } 
      else {
        $vjs_camel_case_list .= "'$value',";
      }
    }
  }
  return $vjs_camel_case_list;
}



function vjs_nav_setup( $vjs_settings, $vjs_opts ) {

  $vjs_div = '';

  if ( $vjs_settings['navs'] ) {
    // Add div if user provided 'nav-selector'
    if ( ! empty( $vjs_settings['nav-selector'] ) ) {
      if ( strpos( $vjs_settings['nav-selector'], '.' ) !== false ) {
        $navSelector = 'class="'. str_replace( '.', '', $vjs_settings['nav-selector'] ) .'"';
      } else {
        $navSelector = 'id="'. str_replace( '#', '', $vjs_settings['nav-selector'] ) .'"';
      }
      if ( $vjs_opts['slides'] == '> div' ) {
        $vjs_div .= '<span ';
      } else {
        $vjs_div .= '<div ';
      }
      $vjs_div .= $navSelector .' style="visibility: visible;">';
    }
    

    if ( ! empty( $vjs_opts['prev'] ) ) {
      // Add the user provided class for the 'prev' link
      if ( strpos( $vjs_opts['prev'], '.' ) !== false ) {
        $prevSelector = 'class="'. str_replace( '.', '', $vjs_opts['prev'] ) .'"';
      } else {
        $prevSelector = 'id="'. str_replace( '#', '', $vjs_opts['prev'] ) .'"';
      }
    } else {
      $prevSelector = 'class="cycle-prev"';
    }
    $vjs_div .= '<span '. $prevSelector .'>' . $vjs_settings['nav-prev'] . '</span>';

    
    if ( ! empty( $vjs_opts['prev'] ) ) {
      // Add the user provided class for the 'next' link
      if ( strpos( $vjs_opts['next'], '.' ) !== false ) {
        $nextSelector = 'class="'. str_replace( '.', '', $vjs_opts['next'] ) .'"';
      } else {
        $nextSelector = 'id="'. str_replace( '#', '', $vjs_opts['next'] ) .'"';
      }
    } else {
      $nextSelector = 'class="cycle-next"';
    }
    $vjs_div .= '<span '. $nextSelector .'>' . $vjs_settings['nav-next'] . '</span>';

    // close up nav element when needed
    if ( ! empty( $vjs_settings['nav-selector'] ) ) {
      if ( $vjs_opts['slides'] == '> div' ) {
        $vjs_div .= '</span>';
      } else {
        $vjs_div .= '</div>';
      }
    }
  }

  return $vjs_div;
}


function vjs_slider_init_script( $vjs_opts_filter, $vjs_id, $vjs_settings ) {
  $vjs_fix = '';
  if ($vjs_settings['theme-fix']) {
    $vjs_fix = '2';
  }
  // initialize the vjs_slider for this specific slider
  $vjs_slider_script = 'jQuery(function($){';
  $vjs_slider_script .= 'jQuery("#' . $vjs_id . '").cycle' . $vjs_fix . '({ '. $vjs_opts_filter . ' });';
  $vjs_slider_script .= '});';

  wp_add_inline_script( 'vjs.cycle2', $vjs_slider_script, 'before' );
}

function vjs_register_scripts( $vjs_settings, $vjs_opts, $vjs_fix_dir, $vjs_fix ) {

  if ($vjs_settings['theme-fix']) {
    $vjs_fix = '.vjs-mod';
    $vjs_fix_dir = '-vjs';
  }
  /*
  * Register some very basic CSS
  */
  if ( 'true' == $vjs_settings['css'] ) { wp_enqueue_style( 'vjs-css',  plugins_url( '/css/vjs-slider.css', __FILE__ ) ); }

  /*
   * Register the jquery.cycle2 script
   */
  wp_enqueue_script('vjs.cycle2',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.min.js', __FILE__ ), 'jQuery', null, true );
  
  /*
   * Conditionally register the plugin scripts
   */
  // transition scripts
  if ( $vjs_opts['fx'] == 'carousel' ) { 
    wp_enqueue_script('vjs.cycle2.carousel',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.carousel.min.js', __FILE__ ), 'cycle2', null, true );
  } elseif ( $vjs_opts['fx'] == 'flipHorz' ) { 
    wp_enqueue_script('vjs.cycle2.flip',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.flip.min.js', __FILE__ ), 'cycle2', null, true );
  } elseif ( $vjs_opts['fx'] == 'scrollVert' ) { 
    wp_enqueue_script('vjs.cycle2.scrollVert',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.scrollVert.min.js', __FILE__ ), 'cycle2', null, true );
  } elseif ( $vjs_opts['fx'] == 'shuffle' ) { 
    wp_enqueue_script('vjs.cycle2.shuffle',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.shuffle.min.js', __FILE__ ), 'cycle2', null, true );
  } elseif ( $vjs_opts['fx'] == 'tileSlide' || $vjs_opts['fx'] == 'tileBlind' ) { 
    wp_enqueue_script('vjs.cycle2.tileSlide',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.tile.min.js', __FILE__ ), 'cycle2', null, true );
  }
  
  // swipe script
  if ( 'true' == $vjs_opts['swipe'] ) { wp_enqueue_script('vjs.cycle2.swipe',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.swipe.min.js', __FILE__ ), 'cycle2', null, true ); }
  
  // centering script
  if ( $vjs_opts['center-vert'] || $vjs_opts['center-horz'] ) { wp_enqueue_script( 'vjs.cycle2.center',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.center.min.js', __FILE__ ), 'cycle2', null, true ); }

  // youtube video script
  if ( $vjs_opts['youtube'] ) { wp_enqueue_script( 'vjs.cycle2.youtube',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.video.min.js', __FILE__ ), 'cycle2', null, true ); }

  // ie fade script
  if ( $vjs_settings['ie-fade'] ) { wp_enqueue_script( 'vjs.cycle2.ie-fade',  plugins_url( '/js/cycle2' . $vjs_fix_dir . '/jquery.cycle2' . $vjs_fix . '.ie-fade.min.js', __FILE__ ), 'cycle2', null, true ); }
}

?>
