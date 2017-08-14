<?php
/*
Plugin Name: OCWP Tooltip Animations
Plugin URI: https://github.com/jeffreyzinn/ocwp-tooltip-animations
Description: A plugin to incorporate Tooltips Animations from codrops.com into WordPress
Version: 1.0
Author: Pixel Jar
Author URI: https://pixeljar.com
License: GPL v3
License URI: https://www.gnu.org/licenses/quick-guide-gplv3.en.html
*/

// include necessary styles and scripts
function tta_enqueue_scripts() {

	$plugin_url = plugin_dir_url( __FILE__ );

	wp_register_style( 'tta-normalize-style', $plugin_url . "/css/normalize.css", false, '1', 'all' );
	wp_enqueue_style( 'tta-normalize-style' );

	wp_register_style( 'tta-demo-style', $plugin_url . "/css/demo.css", false, '1', 'all' );
	wp_enqueue_style( 'tta-demo-style' );

	wp_register_style( 'tta-component-style', $plugin_url . "/css/component.css", false, '1', 'all' );
	wp_enqueue_style( 'tta-component-style' );
	
	wp_register_script( 'tta-anime-script', $plugin_url . "/js/anime.min.js", false, '1', true );
	wp_enqueue_script( 'tta-anime-script' );

	wp_register_script( 'tta-charming-script', $plugin_url . "/js/charming.min.js", false, '1', true );
	wp_enqueue_script( 'tta-charming-script' );

	wp_register_script( 'tta-main-script', $plugin_url . "/js/main.js", false, '1', true );
	wp_enqueue_script( 'tta-main-script' );

}
add_action( 'wp_enqueue_scripts', 'tta_enqueue_scripts' );

// add a shortcode to include a tooltip in the WordPress editor
function tta_tooltip( $atts ) {

	// shortcode format:
	// [tta-tooltip style="{style}" trigger="{text to trigger tooltip}" tooltip="{tooltip message}"]
	
	// set default shortcode values
	$atts = shortcode_atts( array(
		'style' => 'cora', // cora, smaug, uldor, dori, gram, indis, walda, narvi, amras, hador, malva, sadoc
		'trigger' => 'trigger', // text that triggers the tooltip
		'tooltip' => 'this is the tooltip message', // the actual tooltip text
	), $atts, 'tta-tooltip' );

	// set array for all path options
	$paths = array(
		'cora' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300"><path d="M 199,21.9 C 152,22.2 109,35.7 78.8,57.4 48,79.1 29,109 29,142 29,172 45.9,201 73.6,222 101,243 140,258 183,260 189,270 200,282 200,282 200,282 211,270 217,260 261,258 299,243 327,222 354,201 371,172 371,142 371,109 352,78.7 321,57 290,35.3 247,21.9 199,21.9 Z"/></svg>',
		'smaug' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300"><path d="M 314,100 C 313,100 312,100 311,100 L 89.5,100 C 55.9,100 29.1,121 29.1,150 29.1,178 53.1,201 89.5,201 L 184,201 200,223 217,201 311,201 C 344,201 371,178 371,150 371,122 346,99 314,100 Z"/></svg>',
		'uldor' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300"><path d="M 79.5,66 C 79.5,66 128,106 202,105 276,104 321,66 321,66 321,66 287,84 288,155 289,226 318,232 318,232 318,232 258,198 200,198 142,198 80.5,230 80.5,230 80.5,230 112,222 111,152 110,82 79.5,66 79.5,66 Z"/></svg>',
		'dori' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300"><path d="M 22,108 22,236 C 22,236 64,216 103,212 142,208 184,212 184,212 L 200,229 216,212 C 216,212 258,207 297,212 336,217 378,236 378,236 L 378,108 C 378,108 318,83.7 200,83.7 82,83.7 22,108 22,108 Z"/></svg>',
		'gram' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300"><path d="M 92.4,79 C 136,79 154,115 200,116 246,117 263,80.4 308,79 353,77.6 381,111 381,150 381,189 346,220 308,221 270,222 236,188 200,188 164,188 130,222 92.4,221 54.4,220 19,189 19,150 19,111 48.6,79 92.4,79 Z"/></svg>',
		'indis' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300"><path d="M 44.5,24 C 138,4.47 246,-6.47 356,24 367,26.9 376,32.9 376,44 L 376,256 C 376,267 367,279 356,276 231,240 168,241 44.5,276 33.8,279 24.5,267 24.5,256 L 24.5,44 C 24.5,32.9 33.6,26.3 44.5,24 Z"/></svg>',
		'walda' => '<div class="tooltip__deco"></div>',
		'narvi' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300"><path class="path-narvi" d="M 307,150 199,212 92.5,274 92.7,150 92.5,26.2 200,88.4 Z"/></svg>',
		'amras' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300">
	<path class="path-amras-2" d="M 293,106 A 90.1,90.1 0 0 1 203,197 90.1,90.1 0 0 1 112,106 90.1,90.1 0 0 1 203,16.2 90.1,90.1 0 0 1 293,106 Z"/>
	<path class="path-amras-3" d="M 324,66.2 A 46.9,46.9 0 0 1 277,113 46.9,46.9 0 0 1 230,66.2 46.9,46.9 0 0 1 277,19.3 46.9,46.9 0 0 1 324,66.2 Z"/>
	<path class="path-amras-1" d="M 180,111 A 67.2,67.2 0 0 1 112,178 67.2,67.2 0 0 1 45.9,111 67.2,67.2 0 0 1 112,43.5 67.2,67.2 0 0 1 180,111 Z"/>
	<path class="path-amras-4" d="M 371,98.6 A 52.7,52.7 0 0 1 318,152 52.7,52.7 0 0 1 266,98.6 52.7,52.7 0 0 1 318,45.9 52.7,52.7 0 0 1 371,98.6 Z"/>
	<path class="path-amras-9" d="M 375,167 A 66.8,55.1 0 0 1 308,222 66.8,55.1 0 0 1 241,167 66.8,55.1 0 0 1 308,112 66.8,55.1 0 0 1 375,167 Z"/>
	<path class="path-amras-5" d="M 187,199 A 52,52 0 0 1 136,251 52,52 0 0 1 84.1,199 52,52 0 0 1 136,147 52,52 0 0 1 187,199 Z"/>
	<path class="path-amras-6" d="M 287,217 A 66.8,66.8 0 0 1 221,284 66.8,66.8 0 0 1 154,217 66.8,66.8 0 0 1 221,150 66.8,66.8 0 0 1 287,217 Z"/>
	<path class="path-amras-7" d="M 132,168 A 53.9,53.9 0 0 1 78.7,222 53.9,53.9 0 0 1 24.8,168 53.9,53.9 0 0 1 78.7,114 53.9,53.9 0 0 1 132,168 Z"/>
	<path class="path-amras-8" d="M 343,211 A 48.7,48.7 0 0 1 295,260 48.7,48.7 0 0 1 246,211 48.7,48.7 0 0 1 295,163 48.7,48.7 0 0 1 343,211 Z"/>
</svg>',
		'hador' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300">
	<path class="path-hador-1" d="M 154,283 A 6.12,6.12 0 0 1 149,290 6.12,6.12 0 0 1 142,286 6.12,6.12 0 0 1 146,278 6.12,6.12 0 0 1 154,283 Z"/>
	<path class="path-hador-2" d="M 167,265 A 7.83,7.83 0 0 1 162,276 7.83,7.83 0 0 1 152,270 7.83,7.83 0 0 1 157,261 7.83,7.83 0 0 1 167,265 Z"/>
	<path class="path-hador-3" d="M 183,244 A 11.9,11.9 0 0 1 174,258 11.9,11.9 0 0 1 160,250 11.9,11.9 0 0 1 168,235 11.9,11.9 0 0 1 183,244 Z"/>
	<path class="path-hador-4" d="M 327,120 A 127,111 0 0 1 200,231 127,111 0 0 1 72.9,120 127,111 0 0 1 200,9.44 127,111 0 0 1 327,120 Z"/>
</svg>',
		'malva' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300">
	<path d="M 94.9,90.2 101,30.7 163,72.3 229,17.7 263,68.2 319,55.9 315,102 375,144 316,175 340,228 265,220 251,263 180,233 143,282 98.9,218 57.5,236 82,189 25,170 82.8,141 48.7,93.7 Z"/>
</svg>',
		'sadoc' => '<svg class="tooltip__shape" width="100%" height="100%" viewBox="0 0 400 300">
	<path d="M 32.1,42.7 54.5,257 185,257 193,269 200,282 207,269 214,257 342,257 368,23.9 Z"/>
</svg>',
	);

	// establish base output formatting; "tta-tooltip" class added from original source
	$format = '<div class="tta-tooltip tooltip tooltip--%1$s" data-type="%1$s">
	<div class="tooltip__trigger" role="tooltip" aria-describedby="info-%1$s">
		<span class="tooltip__trigger-text">%2$s</span>
	</div>
	<div class="tooltip__base">
		<svg class="tooltip__shape" width="100%%" height="100%%" viewBox="0 0 400 300">%4$s</svg>
		<div class="tooltip__content" id="info-%1$s">%3$s</div>
	</div><!-- /tooltip__base -->
</div><!-- / tooltip -->';
	
	// return completed formatted markup
	return sprintf( $format, 
		esc_attr( $atts['style'] ), 
		esc_attr( $atts['trigger'] ), 
		esc_attr( $atts['tooltip'] ),
		$paths[$atts['style']]
	);
}
add_shortcode( 'tta-tooltip', 'tta_tooltip' );
