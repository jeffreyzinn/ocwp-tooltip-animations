# OCWP Tooltip Animations Plugin

This is a WordPress plugin to incorporate Tooltips Animations from codrops.com into a WordPress website. It was developed for the [Orange County WordPress Developer Meetup](https://www.meetup.com/OC-Wordpress-Group/) for August of 2017. The original question was "How can a developer incorporate generic code libraries into a WordPress site?" This example comes from [codrops](https://tympanus.net/codrops/). It is the [Playful Little Tooltip Ideas](https://tympanus.net/codrops/2017/05/31/playful-little-tooltip-ideas/) source material. 

Though incorporating a generic code library may have variations to this process, here are the basic steps to follow to incorporate the code base into your site:

1. **Create a plugin.** You'll want to use a plugin to keep the functionality independent of your theme so you can retain the functionality if you switch themes. In this case, I used the source directory and added a PHP file (`ocwp-tooltip-animations.php`) as the root of the plugin.

1. **Load styles and scripts.** Likely there will be a serices of CSS and JavaSript files with the codebase. Load those using the WordPress way - [enqueueing](https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts).

1. **Clean up referencing.** In the files assets may be referenced. Because the file structure is being moved into a plugin setting, references to images, fonts, files, etc. may need to be adjusted. Sweep the files and make adjustments as necessary.

1. **Make note of implementation.** Note how the coding is implemented in the demo code. Maybe this can be incorporated into a function or a [shortcode](https://codex.wordpress.org/Function_Reference/add_shortcode).

1. **Modify as necessary.** Tailor styling and functionality to your needs if the base code is not exactly what you require. And sometimes existing styling and scripting can conflict and will need to be addressed.

1. **Clean up files.** Delete anything no longer necessary and keep a clean directory. Combine Javascript files. Consolidate CSS files. Streamline where possible.

1. **Give back!** WordPress works and is so wonderful because of the community. Consider packing this plugin up and [sharing it on the WordPress repository](https://wordpress.org/plugins/developers/add/). But be sure to get the permission of the source before doing so, if appropriate. (Even if you found the source material for free, it is still cool to ask first.)

## Using the tooltip shortcode

`[tta-tooltip style="{style}" trigger="{text to trigger tooltip}" tooltip="{tooltip message}"]`

Style options are cora, smaug, uldor, dori, gram, indis, walda, narvi, amras, hador, malva, and sadoc. Reference [codrops site for examples](https://tympanus.net/Development/TooltipAnimations/). Also note that some custom styles have been added to the `component.css` to counteract Bootstrap styling used on the theme this code was developing using.
