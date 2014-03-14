<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );
	register_nav_menus( array(
		'mobile' => __( 'Mobile Navigation', 'twentyten' ),
	) );
	register_nav_menus( array(
		'footer-column-1' => __( 'Footer Navigation Column 1', 'twentyten' ),
	) );
	register_nav_menus( array(
		'footer-column-2' => __( 'Footer Navigation Column 2', 'twentyten' ),
	) );
	register_nav_menus( array(
		'footer-column-3' => __( 'Footer Navigation Column 3', 'twentyten' ),
	) );
	register_nav_menus( array(
		'footer-column-4' => __( 'Footer Navigation Column 4', 'twentyten' ),
	) );
	register_nav_menus( array(
		'footer-column-5' => __( 'Footer Navigation Column 5', 'twentyten' ),
	) );
	register_nav_menus( array(
		'hp-services-drop-down' => __( 'Homepage: Our Services drop down', 'twentyten' ),
	) );
	register_nav_menus( array(
		'hp-product-links' => __( 'Homepage: Product links', 'twentyten' ),
	) );
	register_nav_menus( array(
		'hp-about-links' => __( 'Homepage: About links', 'twentyten' ),
	) );
	register_nav_menus( array(
		'product-overview-nav' => __( 'Product Overview - mobile', 'twentyten' ),
	) );
	class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
	    function start_lvl(&$output, $depth){
	      $indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
	    }
	
	    function end_lvl(&$output, $depth){
	      $indent = str_repeat("\t", $depth); // don't output children closing tag
	    }
	
	    function start_el(&$output, $item, $depth, $args){
	      // add spacing to the title based on the depth
	      $item->title = str_repeat("&nbsp;", $depth * 4).$item->title;
	
	
	    //CHANGED FROM THIS ON 12-13-13 after their site went down. I think it had something to do with the update of PHP 5.4 - Seth
	    //parent::start_el(&$output, $item, $depth, $args);
	
	      parent::start_el($output, $item, $depth, $args);
	
	      // no point redefining this method too, we just replace the li tag...
	      $output = str_replace('<li', '<option', $output);
	    }
	
	    function end_el(&$output, $item, $depth){
	      $output .= "</option>\n"; // replace closing </li> with the option tag
	    }
	}
	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
	add_custom_image_header( '', 'twentyten_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/starkers.png',
			'thumbnail_url' => '%s/images/headers/starkers-thumbnail.png',
			/* translators: header image description */
			'description' => __( 'Starkers', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Makes some changes to the <title> tag, by filtering the output of wp_title().
 *
 * If we have a site description and we're viewing the home page or a blog posts
 * page (when using a static front page), then we will add the site description.
 *
 * If we're viewing a search result, then we're going to recreate the title entirely.
 * We're going to add page numbers to all titles as well, to the middle of a search
 * result title and the end of all other titles.
 *
 * The site title also gets added to all titles.
 *
 * @since Twenty Ten 1.0
 *
 * @param string $title Title generated by wp_title()
 * @param string $separator The separator passed to wp_title(). Twenty Ten uses a
 * 	vertical bar, "|", as a separator in header.php.
 * @return string The new title, ready for the <title> tag.
 */
function twentyten_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'twentyten' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'twentyten' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'twentyten_filter_wp_title', 10, 2 );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <br /> <a href="'. get_permalink() . '">' . __( 'Read More <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'Global and Miscellaneous', 'twentyten' ),
		'id' => 'global-misc-widget-area',
		'description' => __( 'The Global and Miscellaneous widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '<div class="divider"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Products', 'twentyten' ),
		'id' => 'products-widget-area',
		'description' => __( 'The Products widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '<div class="divider"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Services', 'twentyten' ),
		'id' => 'services-widget-area',
		'description' => __( 'The Services widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '<div class="divider"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Resources', 'twentyten' ),
		'id' => 'resources-widget-area',
		'description' => __( 'The Resources widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '<div class="divider"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Industries', 'twentyten' ),
		'id' => 'industries-widget-area',
		'description' => __( 'The Industries widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '<div class="divider"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Success Stories', 'twentyten' ),
		'id' => 'success-stories-widget-area',
		'description' => __( 'The Success Stories widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '<div class="divider"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Who We Are', 'twentyten' ),
		'id' => 'who-we-are-widget-area',
		'description' => __( 'The Who We Are widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '<div class="divider"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Get In Touch', 'twentyten' ),
		'id' => 'get-in-touch-widget-area',
		'description' => __( 'The Get In Touch widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '<div class="divider"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
		/*
	register_sidebar( array(
			'name' => __( 'First Footer Widget Area', 'twentyten' ),
			'id' => 'first-footer-widget-area',
			'description' => __( 'The first footer widget area', 'twentyten' ),
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	*/

	// Area 4, located in the footer. Empty by default.
	/*
register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'twentyten' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
*/

	// Area 5, located in the footer. Empty by default.
	/*
register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'twentyten' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
*/

	// Area 6, located in the footer. Empty by default.
	/*
register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'twentyten' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
*/
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

if (function_exists('register_field') ) {
    register_field('Location_field', dirname(__FILE__) . '/custom-fields/location.php');
}
if (function_exists('register_field') ) {
register_field('Categories_field', dirname(__File__) . '/custom-fields/categories.php');
}

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
    add_menu_page( 'custom menu title', 'Products', 'manage_options', 'product-admin/product-admin.php', '', '', 21);
}
add_action('admin_menu', 'add_newsletter_extra_page');
function add_newsletter_extra_page(){
    add_submenu_page( 
        'product-admin/product-admin.php', 
        'Products', 
        'Product Images', 
        1, //$capability, 
        'product-admin/product-admin-images.php',
        '' );
    add_submenu_page(
        'product-admin/product-admin.php',
        'Products',
        'Missing Images',
        1, //$capability,
        'product-admin/product-admin-missin-images.php',
        '' );
}

/*=========================CUSTOM WYSIWYG SETTINGS=========================*/

/*
function custom_wysiwyg( $init ) {
    $init['theme_advanced_disable']=
    'formatselect,forecolor,|,underline,strikethrough,undo,redo,fullscreen,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,wp_fullscreen,wp_adv';
    return $init;
}
add_filter('tiny_mce_before_init', 'custom_wysiwyg');
*/

/*=========================PACKAGING GLOSSARY=========================*/
function glossary_filter() {
	$query1=mysql_query("SELECT distinct(filter_1) FROM packaging_glossary");
		echo "<div id='packaging-glossary'>";
		echo "<select id='filter_1'>";	
		echo "<option>Filter by Alphabet</option>";	
	while($row1 = mysql_fetch_array($query1)){ 
   	 $glossary_alpha_num_filter .= "<option value=" . $row1['filter_1'] . ">" . $row1['filter_1'] ."</option>";
    }
    echo $glossary_alpha_num_filter;
    echo "</select>";
    
    $query2=mysql_query("SELECT distinct(filter_2) FROM packaging_glossary");
		echo "<select id='filter_2'>";
		echo "<option>Filter by Category</option>";	
	while($row2 = mysql_fetch_array($query2)){ 
   	 $glossary_cat_filter .= "<option value=" . $row2['filter_2'] . ">" . $row2['filter_2'] ."</option>";
    }
    echo $glossary_cat_filter;
    echo "</select>";
    echo "<span class='reset-glossary'>Reset</span>";
}

function get_glossary() {
	
	//GET THE FILTERS
	$filter_1 = $_GET['filter_1'];
	$filter_2 = $_GET['filter_2'];
	
	if ( !($filter_1 == NULL) && !($filter_2 == NULL) ) { //if both filters are used
	
		$query=mysql_query("SELECT * FROM packaging_glossary WHERE filter_1 = '" . $filter_1 . "' AND (filter_2='" . $filter_2 . "' OR filter_3 = '" . $filter_2 . "' OR filter_4 = '" . $filter_2 . "' OR filter_5 = '" . $filter_2 . "' OR filter_6 = '" . $filter_2 . "' OR filter_7 = '" . $filter_2 . "')");
		
	} elseif ( !($filter_1 == NULL) && ($filter_2 == NULL) ) { //if only the alhpa/num filter is used
	
		$query=mysql_query("SELECT * FROM packaging_glossary WHERE filter_1 = '" . $filter_1 . "'");
		
	} elseif ( ($filter_1 == NULL) && !($filter_2 == NULL) ) { //if only the category filter is used
		
		$query=mysql_query("SELECT * FROM packaging_glossary WHERE filter_2='" . $filter_2 . "' OR filter_3 = '" . $filter_2 . "' OR filter_4 = '" . $filter_2 . "' OR filter_5 = '" . $filter_2 . "' OR filter_6 = '" . $filter_2 . "' OR filter_7 = '" . $filter_2 . "'");
		
	} else { //if no filter is used
	
		$query=mysql_query("SELECT * FROM packaging_glossary");
		
	}
	
	//DISPLAY THE CURRENT SEARCH FILTERS BEING USED
	if (!($filter_1 == NULL) && !($filter_2 == NULL)) {
	
		echo "<p><i>Currently viewing all of the terms that start with <b>\"" . $filter_1 . "\"</b> in the <b>\"" . $filter_2 . "\"</b> category.</i></p>";
	
	} elseif (!($filter_1 == NULL) && ($filter_2 == NULL)) {
	
		echo "<p><i>Currently viewing all of the terms that start with <b>\"" . $filter_1 . "\"</b>.</i></p>";
	
	} elseif (($filter_1 == NULL) && !($filter_2 == NULL)) {
	
		echo "<p><i>Currently viewing all of the terms in the <b>\"" . $filter_2 . "\"</b> category.</i></p>";
	
	} else {}
	
	//DISPLAY THE TABLE WITH RESULTS
	echo "<table id='general-table'><tbody>";
	while($row = mysql_fetch_array($query)){ 
	    $glossary_entry .= "<tr>
	    					<td>" . $row['term'] ."</td>
	    					<td>" . $row['definition'] . "</td></tr>";
    }
    echo $glossary_entry;
    echo "</tbody></table>";
    echo "</div>";	
   /*
 if (!$query) { // add this check.
	    die('Invalid query: ' . mysql_error());
	}
*/
}
/*=========================CUSTOM SHORTCODES=========================*/

function add_divider( $atts ){
 return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'add_divider' );

function packaging_glossary(){
	echo glossary_filter();
	echo get_glossary();
}
add_shortcode( 'packaging_glossary', 'packaging_glossary' );



/*=========================PRODUCT FILTER=========================*/

function search_for_products(){
	session_start();

  // Gather input
  $productLineId = $_POST['productLineId'];  
  $filter = filter_contraints();
  $briefcase_ids = $_SESSION['briefcase'];

  // Do Work
  $query = mysql_query(sprintf("SELECT *, products.id AS product_id FROM products JOIN product_lines ON product_lines.id=products.product_line_id where product_line_id = '%s' ", mysql_real_escape_string($productLineId)).$filter." LIMIT 50");

  $normal_header = "<table class='product-filter-table span_16'><thead><tr><th class='thumbnail-cell'>Thumbnail</th><th>Capacity</th><th>Material</th><th colspan='2'>Style</th><th>Color</th><th class='more-info-cell'>Details</th><th class='add-to-briefcase-cell'>Add to Briefcase</th></tr></thead><tbody>";
  $cans_header = "<table class='product-filter-table span_16'><thead><tr><th class='thumbnail-cell'>Thumbnail</th><th>Capacity</th><th>Material</th><th colspan='2'>Style</th><th>Shape</th><th class='more-info-cell'>Details</th><th class='add-to-briefcase-cell'>Add to Briefcase</th></tr></thead><tbody>";
  $closings_header = "<table class='product-filter-table span_16'><thead><tr><th class='thumbnail-cell'>Thumbnail</th><th colspan='4'>Material</th><th>Fittings</th><th class='more-info-cell'>Details</th><th class='add-to-briefcase-cell'>Add to Briefcase</th></tr></thead><tbody>";
  $closures_header = "<table class='product-filter-table span_16'><thead><tr><th class='thumbnail-cell'>Thumbnail</th><th>Material</th><th>Style</th><th>Color</th><th>Lining</th><th>Finish</th><th class='more-info-cell'>Details</th><th class='add-to-briefcase-cell'>Add to Briefcase</th></tr></thead><tbody>";
  $liner_header = "<table class='product-filter-table span_16'><thead><tr><th class='thumbnail-cell'>Thumbnail</th><th colspan='2'>Capacity</th><th colspan='3'>Material</th><th class='more-info-cell'>Details</th><th class='add-to-briefcase-cell'>Add to Briefcase</th></tr></thead><tbody>";
  $pails_header = "<table class='product-filter-table span_16'><thead><tr><th class='thumbnail-cell'>Thumbnail</th><th>Capacity</th><th>Gauge</th><th>Un</th><th colspan='2'>Lining</th><th class='more-info-cell'>Details</th><th class='add-to-briefcase-cell'>Add to Briefcase</th></tr></thead><tbody>";
  $tubes_header = "<table class='product-filter-table span_16'><thead><tr><th class='thumbnail-cell'>Thumbnail</th><th colspan='2'>Material</th><th colspan='3'>Finish</th><th class='more-info-cell'>Details</th><th class='add-to-briefcase-cell'>Add to Briefcase</th></tr></thead><tbody>";

  switch ($productLineId) {
    case 1:
			  $products .= $normal_header;        
        break;
    case 2:
        $products .= $cans_header;        
        break;
    case 3:
				$products .= $closings_header;        
        break;
		case 4:
				$products .= $closures_header;        
        break;
		case 5:
				$products .= $normal_header;        
        break;
		case 6:
				$products .= $liner_header;        
        break;
		case 7:
				$products .= $pails_header;        
        break;
		case 8:
				$products .= $tubes_header;        
        break;
		default:
				$products .= $normal_header;        
	}
  
  // Handle errors
  if ( mysql_num_rows($query) == 0 ) 
  {
    $products .= "<tr><td colspan='8' align='center'><h2>There were no results.</h2></td></tr>";
  } 
  else
  {

  // Return results
    while($row = mysql_fetch_array($query))
    {    	
			if (in_array($row['product_id'], $briefcase_ids)) {
				$briefcase_link = "<a href='#' id='bl".$row['product_id']."' onclick='remove_product_from_briefcase(\"".$row['product_id']."\"); return false;' class='button-link red'>Remove</a>";
				$briefcase = "<td><a href='#' id='b".$row['product_id']."' onclick='remove_product_from_briefcase(\"".$row['product_id']."\"); return false;'><span class='icon-span my-briefcase'><i class='icon-trash icon-large'></i></span>Remove from my briefcase</a></td>";
			} else {
				$briefcase_link = "<a href='#' id='bl".$row['product_id']."' onclick='add_product_to_briefcase(\"".$row['product_id']."\"); return false;' class='button-link yellow'>Add</a>";
				$briefcase = "<td><a href='#' id='b".$row['product_id']."' onclick='add_product_to_briefcase(\"".$row['product_id']."\"); return false;'><span class='icon-span my-briefcase'><i class='icon-briefcase icon-large'></i></span>Add to my briefcase</a></td>";
			}

			$image_url = product_image($row['product_line_id'], $row['image_name']);
    	
    	$normal_row = "<tr><td class='thumbnail-cell'><img src='".$image_url."' /></td><td>".$row['capacity']."</td><td>".$row['material']."</td><td colspan='2'>".$row['style']."</td><td>".$row['color']."</td><td class='more-info-cell'><a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next(\"tr\").fadeIn();return false;'>Details</a></td><td class='add-to-briefcase-cell'>".$briefcase_link."</td></tr>";    	
    	$cans_row = "<tr><td class='thumbnail-cell'><img src='".$image_url."' /></td><td>".$row['capacity']."</td><td>".$row['material']."</td><td colspan='2'>".$row['style']."</td><td>".$row['shape']."</td><td class='more-info-cell'><a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next(\"tr\").fadeIn();return false;'>Details</a></td><td class='add-to-briefcase-cell'>".$briefcase_link."</td></tr>";    	
    	$closings_row = "<tr><td class='thumbnail-cell'><img src='".$image_url."' /></td><td colspan='4'>".$row['material']."</td><td>".$row['fittings']."</td><td class='more-info-cell'><a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next(\"tr\").fadeIn();return false;'>Details</a></td><td class='add-to-briefcase-cell'>".$briefcase_link."</td></tr>";    	
    	$closures_row = "<tr><td class='thumbnail-cell'><img src='".$image_url."' /></td><td>".$row['material']."</td><td>".$row['style']."</td><td>".$row['color']."</td><td>".$row['lining']."</td><td>".$row['finish']."</td><td class='more-info-cell'><a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next(\"tr\").fadeIn();return false;'>Details</a></td><td class='add-to-briefcase-cell'>".$briefcase_link."</td></tr>";    	
    	$liner_row = "<tr><td class='thumbnail-cell'><img src='".$image_url."' /></td><td colspan='2'>".$row['capacity']."</td><td colspan='3'>".$row['material']."</td><td class='more-info-cell'><a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next(\"tr\").fadeIn();return false;'>Details</a></td><td class='add-to-briefcase-cell'>".$briefcase_link."</td></tr>";    	
    	$pails_row = "<tr><td class='thumbnail-cell'><img src='".$image_url."' /></td><td>".$row['capacity']."</td><td>".$row['gauge']."</td><td>".$row['un']."</td><td colspan='2'>".$row['lining']."</td><td class='more-info-cell'><a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next(\"tr\").fadeIn();return false;'>Details</a></td><td class='add-to-briefcase-cell'>".$briefcase_link."</td></tr>";    	
    	$tubes_row = "<tr><td class='thumbnail-cell'><img src='".$image_url."' /></td><td colspan='2'>".$row['material']."</td><td colspan='3'>".$row['finish']."</td><td class='more-info-cell'><a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next(\"tr\").fadeIn();return false;'>Details</a></td><td class='add-to-briefcase-cell'>".$briefcase_link."</td></tr>";    	
		  
		  switch ($productLineId) {
		    case 1:
					  $products .= $normal_row;        
		        break;
		    case 2:
		        $products .= $cans_row;        
		        break;
		    case 3:
						$products .= $closings_row;        
		        break;
				case 4:
						$products .= $closures_row;        
		        break;
				case 5:
						$products .= $normal_row;        
		        break;
				case 6:
						$products .= $liner_row;        
		        break;
				case 7:
						$products .= $pails_row;        
		        break;
				case 8:
						$products .= $tubes_row;        
		        break;
				default:
						$products .= $normal_row;
			}      			

      $products .= "<tr class='modalShow' style='display: none;'>
      					<td colspan='8' class='product-filter-item-detail'>
      					
  					  <table class='span_16 col detail-actions-list-container'>
	  					  <tr>
	                        ".$briefcase."
	                        <td><a href='/who-we-are/territory-map/'><span class='icon-span see-locations'><i class='icon-map-marker icon-large'></i></span>Find a customer service representative</a></td>
	                        <td><span class='icon-span phone'><i class='icon-phone icon-large'></i></span><span class='text-span'>Call for availability - 1.877.242.1880</span></td>
	                        <td valign='middle' class='close-cell'><a href='#' class='close-link' onclick='jQuery(this).parent().parent().parent().parent().parent().parent().fadeOut(); return false;'><span class='icon-span close'><i class='icon-remove'></i></span>Close</a></td>
	                      </tr>
	                  </table>
	                      <span class='span_6 col detail-img'><img src='".$image_url."' /></span>
	                      <span class='span_10 col detail-product'>
		                      	<table class='moreInfo'>
			                        <tr>
			                        	<td class='span_4'><b>Product Line:</b></td>
			                        	<td class='span_12'> ".$row['name']."</td>
			                        </tr>";
			                      $attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'closures', 'product_type', 'fittings', 'gauge', 'comments', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length', 'product_attributes');
			                        foreach ($attributes as &$attribute) {
														    if ($row[$attribute] != '') {
														    	$pretty_word = str_replace('product_type', 'type', $attribute);
														    	$pretty_word = str_replace('anti_state', 'anti_static', $pretty_word);
														    	$pretty_word = str_replace('_', '-', $pretty_word);
														    	$pretty_word = ucwords($pretty_word);
														    	$pretty_word = str_replace('Un', 'UN', $pretty_word);
															    
															    $products .=
					                        "<tr>
					                        	<td><b>".$pretty_word.":</b></td>
					                        	<td> ".$row[$attribute]."</td>
					                        </tr>";
					                      }
															}
			                      $products .= 
		                        "</table>
		                        <p class='view-your-briefcase'><a href='/products/my-briefcase' class='button-link yellow'>View Your Briefcase</a></p>
	                      </span>
                    </td></tr>";
    }
  }
  
  $products .= "</tbody></table>";

  echo($products);
}

function create_filter_dropdown() {
	$filter_attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'closures', 'product_type', 'fittings', 'gauge', 'comments', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length', 'product_attributes'); 

	if ($_POST['productLineId']) {
		$productLineId = $_POST['productLineId'];
	} else {
		$productLineId = set_params_from($_SERVER["REQUEST_URI"]);
	}

	$query = filter_contraints();

  $dropDown = "<h3 class='widget-title'>Refine Your Search</h3><form class='customSearch' action='create_filter_dropdown' method='post'><input type='hidden' id='productLine' name='productLineId' value='".$productLineId."' />";
  $dropDown .= "<div id='prod_collection' style='display: block;'>";

  foreach ($filter_attributes as &$attribute) {

		$pretty_word = str_replace('product_type', 'type', $attribute);
  	$pretty_word = str_replace('anti_state', 'anti_static', $pretty_word);
  	$pretty_word = str_replace('_', '-', $pretty_word);
  	$pretty_word = ucwords($pretty_word);
  	$pretty_word = str_replace('Un', 'UN', $pretty_word);

		$attr_query = mysql_query("SELECT distinct($attribute) FROM products where product_line_id = '$productLineId' and $attribute != 'NULL'".$query." order by $attribute");

		if ( mysql_num_rows($attr_query) > 0 ) {
	    $dropDown .=  "<div class='select-filter-container'><label>$pretty_word</label><span class='clearfix'><select class='filter-select' name='$attribute'><option value=''></option>";
	      while($row_stock = mysql_fetch_array($attr_query))
	      {				   
	         $dropDown .= "<option ";
	         if($row_stock[$attribute] == $_POST[$attribute]) {
	         	$dropDown .= "selected='selected' ";
	         }
	         $dropDown .= "value=\"$row_stock[$attribute]\">$row_stock[$attribute]</option>";
	      }                       
		   $dropDown .= "</select><a href='#' class='resetLinker' onclick=\"reset_my('$attribute'); return false;\">Reset</a></span></div>";
	  }
	}

  $dropDown .= "<a href='#' onclick='jQuery(\"form.customSearch\").clearForm(); jQuery(\"form.customSearch select\").trigger(\"change\");return false;'>START OVER</a>";
  $dropDown .= "</div><div class='divider'></div></form>";

  echo($dropDown);
}

// Set params functions
$host = $_SERVER['HTTP_HOST']; 
if ($host == "www.boondockstaging.com" or $host == "boondockstaging.com") {
	function set_params_from($url) {
		if ($url == "/pipeline/products/bottles-cubitainers-and-jars/") {
		  $product_line_id = 1;
		} else if ($url == "/pipeline/products/cans/") {
		  $product_line_id = 2;
		} else if ($url == "/pipeline/products/closing-tools/") {
		  $product_line_id = 3;
		} else if ($url == "/pipeline/products/closures/") {
		  $product_line_id = 4;
		} else if ($url == "/pipeline/products/drums-and-totes/") {
		  $product_line_id = 5;
		} else if ($url == "/pipeline/products/liners/") {
		  $product_line_id = 6;
		} else if ($url == "/pipeline/products/pails-and-tubs/") {
		  $product_line_id = 7;
		} else if ($url == "/pipeline/products/tubes/") {
		  $product_line_id = 8;
		}
		return $product_line_id;
	}
} else {
	function set_params_from($url) {
		if ($url == "/products/bottles-cubitainers-and-jars/") {
		  $product_line_id = 1;
		} else if ($url == "/products/cans/") {
		  $product_line_id = 2;
		} else if ($url == "/products/closing-tools/") {
		  $product_line_id = 3;
		} else if ($url == "/products/closures/") {
		  $product_line_id = 4;
		} else if ($url == "/products/drums-and-totes/") {
		  $product_line_id = 5;
		} else if ($url == "/products/liners/") {
		  $product_line_id = 6;
		} else if ($url == "/products/pails-and-tubs/") {
		  $product_line_id = 7;
		} else if ($url == "/products/tubes/") {
		  $product_line_id = 8;
		}
		return $product_line_id;
	}
}

// Filter Constraints
function filter_contraints() {
  $filter_attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'closures', 'product_type', 'fittings', 'gauge', 'comments', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length', 'product_attributes'); 

	foreach ($filter_attributes as &$attribute) {
		if ($_POST[$attribute] != NULL) {
	    $filter .= sprintf("AND $attribute LIKE '%s' ", mysql_real_escape_string($_POST[$attribute]));
	  }
	}

  return $filter;
}

function product_image($product_line_id, $image_name) {
	if ($image_name != NULL && $image_name != "image-coming-soon.jpg") {
	 switch ($product_line_id) {
		    case 1:
					  $product_image = '/product-images/Bottles-Jars-Cubetainers/'.$image_name;        
		        break;
		    case 2:
					  $product_image = '/product-images/Cans/'.$image_name;        
		        break;		    
				case 3:
					  $product_image = '/product-images/Closing-tools/'.$image_name;        
		        break;
				case 4:
					  $product_image = '/product-images/Closures/'.$image_name;        
		        break;
				case 5:
					  $product_image = '/product-images/Drums/'.$image_name;        
		        break;
				case 6:
					  $product_image = '/product-images/Liners/'.$image_name;        
		        break;
				case 7:
					  $product_image = '/product-images/Pails/'.$image_name;        						
		        break;				
				case 8:
					  $product_image = '/product-images/Tubes/'.$image_name;        						
		        break;
				default:
					  $product_image = '/product-images/image-coming-soon.jpg';        
			}   
	} else {
	  $product_image = '/product-images/image-coming-soon.jpg';
	}	

	return $product_image;   
}

function display_briefcase() {
	session_start();


	if ($_SESSION['notice'] != NULL) {
		$notice = "<div class='notice'><h3>".strip_tags($_SESSION['notice'])."</h3></div>";
	} else {
		$notice = "";
	}

	if ($_SESSION['errors'] != NULL) {
		$error_messages = "<div class='error_messages'>";
		$error_messages .= "<ul>Your email could not be sent due to the following errors:";
		$error_messages .= $_SESSION['errors'];
		$error_messages .= "</ul></div>";		
	} else {
		$error_messages = "";
	}

	if ($_SESSION['briefcase'] == NULL) {
		$products = "<h4 align='center'>Your briefcase is empty. You should <a href='/products/product-overview/'>fill it with products</a>.</h4>";
	} else {
	
	$products = $notice;

	$products .= "<form id='emailBriefcase' method='post' action='/wp-admin/admin-ajax.php' onsubmit='get_product_ids();'>
									<table class='product-filter-table span_16'>
									<thead>
									<tr><th><input type='checkbox' checked='checked' id='toggleCheckBoxes' /></th><th class='thumbnail-cell'>Thumbnail</th><th>Capacity</th><th>Material</th><th>Style</th><th>Color</th><th class='more-info-cell'>Details</th><th class='add-to-briefcase-cell'>Remove from Briefcase</th></tr></thead><tbody>";

	foreach($_SESSION['briefcase'] as $product_id) {
		$query = mysql_query(sprintf("SELECT *, products.id AS product_id FROM products JOIN product_lines ON products.product_line_id=product_lines.id where products.id = '%s' ", mysql_real_escape_string($product_id)));
		while($row = mysql_fetch_array($query))
      {

      	$image_url = product_image($row['product_line_id'], $row['image_name']);
    		
	    	$products .= "<tr><td><input class='product_id' type='checkbox' checked='checked' value='".$row['product_id']."' /></td><td class='thumbnail-cell'><img src='".$image_url."' /></td><td>".$row['capacity']."</td><td>".$row['material']."</td><td>".$row['style']."</td><td>".$row['color']."</td><td class='more-info-cell'><a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next(\"tr\").fadeIn();return false;'>Details</a></td><td class='add-to-briefcase-cell'><a href='#' id='removeLink".$row['product_id']."'onclick='remove_product_from_briefcase(\"".$row['product_id']."\"); return false;' class='button-link red'>Remove</a></td></tr>";
				$products .= "<tr class='modalShow' style='display: none;'>
      					<td colspan='8' class='product-filter-item-detail'>
      					
		  					  <table class='span_16 col detail-actions-list-container'>
			  					  <tr>
			                        <td><a href='#' onclick='remove_product_from_briefcase(\"".$row['product_id']."\");return false;'><span class='icon-span my-briefcase'><i class='icon-trash icon-large'></i></span>Remove from my briefcase</a></td>
			                        <td><a href='/who-we-are/territory-map/'><span class='icon-span see-locations'><i class='icon-map-marker icon-large'></i></span>Find a customer service representative</a></td>
			                        <td><span class='icon-span phone'><i class='icon-phone icon-large'></i></span><span class='text-span'>Call for availability - 1.877.242.1880</span></td>
			                        <td valign='middle' class='close-cell'><a href='#' class='close-link' onclick='jQuery(this).parent().parent().parent().parent().parent().parent().fadeOut(); return false;'><span class='icon-span close'><i class='icon-remove'></i></span>Close</a></td>
			                      </tr>
			                  </table>
			                      <span class='span_6 col detail-img'><img src='".$image_url."' /></span>
			                      <span class='span_10 col detail-product'>
				                      	<table class='moreInfo'>
					                        <tr>
					                        	<td class='span_4'><b>Product Line:</b></td>
					                        	<td class='span_12'> ".$row['name']."</td>
					                        </tr>";
					                     		$attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'closures', 'product_type', 'fittings', 'gauge', 'comments', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length', 'product_attributes');
					                        foreach ($attributes as &$attribute) {
																    if ($row[$attribute] != '') {
																    	$pretty_word = str_replace('product_type', 'type', $attribute);
																    	$pretty_word = str_replace('anti_state', 'anti_static', $pretty_word);
																    	$pretty_word = str_replace('_', '-', $pretty_word);
																    	$pretty_word = ucwords($pretty_word);
																    	$pretty_word = str_replace('Un', 'UN', $pretty_word);
															    
																	    $products .=
							                        "<tr>
							                        	<td><b>".$pretty_word.":</b></td>
							                        	<td> ".$row[$attribute]."</td>
							                        </tr>";
							                      }
																	}
					                      $products .= 
				                        "</table>				                        
			                      </span>
		                    </td></tr>";
		   
      }  
		}

  $products .= "</tbody></table>";
	$products .= "<p class='clearfix'><a href='#' class='button-link orange' onclick='empty_briefcase(); return false;'>clear briefcase</a></p>";
	$products .= $error_messages;
	$states = '<select id="state" name="state"><option value="" selected="selected"></option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option></select>';


	$products .= "<input type='hidden' name='action' id='send_briefcase_email' value='send_briefcase_email' />
								<input type='hidden' name='product_ids' id='product_ids' value='' />
								<p><b>Do You Have a Question...</b><br />...or need a quote on an item? Complete the form below and click Send Email. One of our People at the Core will be happy to contact you shortly to discuss your question and any other packaging needs.</p>
								<ul class='form-list briefcase-list'>
									<li class='clearfix'><label for='company'>Company:</label><input type='text' name='company' id='company' placeholder='Your Company's Name' /></li>
									<li class='clearfix'><label for='name'>Name:</label><input type='text' name='name' id='name' placeholder='First Last' /></li>
									<li class='clearfix'><label for='email'>Email:</label><input type='email' name='email' placeholder='email@example.com' /></li>
									<li class='clearfix'><label for='phone'>Phone:</label><input type='tel' name='phone' placeholder='(555) 123-4567' /></li>
									<li class='clearfix'><label for='state'>State:</label>".$states."</li>
									<li class='clearfix'><label for='comments'>Comments:</label><textarea style='background: #E1E1E1; border: none; border-radius: 3px;' rows='4' cols='10' name='comments' placeholder='Type your comments here.' ></textarea></li>
									<li class='clearfix'><label for='state'>Captcha: what is three plus seven?</label><input type='text' name='captcha' /></li>
									<li class='clearfix'><input class='button' style='border: none; padding: 16px;' name='commit' type='submit' value='Send Email'></li>
								</ul>
							</form>";
	}

	$_SESSION['errors'] = NULL;
	$_SESSION['notice'] = NULL;

	echo $products;
}

function set_briefcase_item() {
	session_start();
	if ($_SESSION['briefcase'] != NULL) {
		array_push( $_SESSION['briefcase'], $_POST['product_id'] );
		$_SESSION['briefcase'] = array_unique($_SESSION['briefcase']);
	} else {
		$_SESSION['briefcase'] = array($_POST['product_id']);
	}	
}

function remove_briefcase_item() {
	session_start();
	foreach($_SESSION['briefcase'] as $index => $product_id) {
		if ($product_id == $_POST['product_id']) {
			unset($_SESSION['briefcase'][$index]);
		}
	}
	return display_briefcase();
}

function clear_briefcase() {
	session_start();
	session_destroy();
	return display_briefcase();
}

function send_briefcase_email() {
	session_start();

	if ($_POST['product_ids'] == NULL || $_POST['company'] == NULL || $_POST['name'] == NULL || $_POST['phone'] == NULL || $_POST['email'] == NULL || $_POST['state'] == NULL || $_POST['captcha'] == NULL) {
		$_SESSION['errors'] = "";
		if ($_POST['product_ids'] == NULL) {
			$_SESSION['errors'] .= "<li>You must select at least one product!</li>";
		}
		if ($_POST['company'] == NULL) {
			$_SESSION['errors'] .= "<li>Company can't be blank.</li>";
		}
		if ($_POST['name'] == NULL) {			
			$_SESSION['errors'] .= "<li>Name can't be blank.</li>";
		} 
		if ($_POST['email'] == NULL) {
			$_SESSION['errors'] .= "<li>Email can't be blank.</li>";
		}
		if ($_POST['phone'] == NULL) {
			$_SESSION['errors'] .= "<li>Phone can't be blank.</li>";
		}
		if ($_POST['state'] == NULL) {
			$_SESSION['errors'] .= "<li>State can't be blank.</li>";
		}
		if ($_POST['captcha'] != 10) {
			$_SESSION['errors'] .= "<li>Captcha is wrong.</li>";
		}

		wp_redirect( "/products/my-briefcase/" );
	}	else {		
		$body = "<b>Company: </b>".strip_tags($_POST['company'])."<br />";
		$body .= "<b>Name:</b> ".strip_tags($_POST['name'])."<br />";
		$body .= "<b>Phone:</b> ".strip_tags($_POST['phone'])."<br />";
		$body .= "<b>Email:</b> ".strip_tags($_POST['email'])."<br />";
		$body .= "<b>State:</b> ".strip_tags($_POST['state'])."<br />";
		$body .= "<b>Comments:</b> ".strip_tags($_POST['comments'])."<br />";
		$body .= "<ol><h3>List of products from briefcase</h3>";

		$checked_briefcase_ids = explode(",", $_POST['product_ids']);

		foreach($checked_briefcase_ids as $index) {
			$query = mysql_query(sprintf("SELECT *, product_lines.name as product_line_name FROM products JOIN product_lines on products.product_line_id=product_lines.id where products.id = '%s' ", mysql_real_escape_string($index)));
			while($row = mysql_fetch_array($query)) {
				$body .= "<li><table>				
				     <tr>
              	<td class='span_4'><b>Product Line:</b></td>
              	<td class='span_12'> ".$row['product_line_name']."</td>
              </tr>";
            $attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'closures', 'product_type', 'fittings', 'gauge', 'comments', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length', 'product_attributes');
              foreach ($attributes as &$attribute) {
						    if ($row[$attribute] != '') {
						    	$pretty_word = str_replace('product_type', 'type', $attribute);
						    	$pretty_word = str_replace('anti_state', 'anti_static', $pretty_word);
						    	$pretty_word = str_replace('_', '-', $pretty_word);
						    	$pretty_word = ucwords($pretty_word);
						    	$pretty_word = str_replace('Un', 'UN', $pretty_word);
							    
							    $body .=
                  "<tr>
                  	<td><b>".$pretty_word.":</b></td>
                  	<td> ".$row[$attribute]."</td>
                  </tr>";
                }
							}
            $body .= "</table><hr style='border: none; border-top: 1px solid #DDD;' /></li>";
			}
		}
		$body .= "</ol>";

		$to = "lkirkland@pipelinepackaging.com, ssmith@pipelinepackaging.com";
		$subject = "Briefcase";
		$headers = "From: ".strip_tags($_POST['name'])." <".strip_tags($_POST['email']).">" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		if (wp_mail($to, $subject, $body, $headers)) {			
			$result = "Briefcase delivery was a success";
		} else {
			$result = "Briefcase delivery failed..";
		}

			$update_email_records = sprintf("INSERT INTO briefcase_email_records (product_ids, company_name, from_name, from_phone, from_email, from_state, from_comments) VALUES ('%s', '%s', '%s','%s','%s','%s','%s')",
																	    mysql_real_escape_string($_POST['product_ids']),
																	    mysql_real_escape_string($_POST['company']),
																	    mysql_real_escape_string($_POST['name']),
																	    mysql_real_escape_string($_POST['phone']),
																	    mysql_real_escape_string($_POST['email']),
																	    mysql_real_escape_string($_POST['state']),
																	    mysql_real_escape_string($_POST['comments']));
		mysql_query($update_email_records);
		$_SESSION['notice'] = "<h3>Thank you! Your email has been sent to us.</h3>";
		wp_redirect( "/products/my-briefcase/" );
	}
}

// Create the function to output the briefcase stats on our Dashboard Widget
function example_dashboard_widget_function() {
	// Display records from briefcase
	// Stats
	echo "<style>
	table#product_stats {
		border-top: 1px solid #DEDEDE;
		padding-top: 6px;
		border-collapse: collapse;
	}
	table#product_stats td, table#product_stats th {padding: 6px;}
	table#product_stats tr:nth-child(even) {background: #EEE;}
	</style>";
	$emails_sent = mysql_query("SELECT count(1) as total FROM briefcase_email_records");
	$emails_sent_by_state = mysql_query("SELECT from_state as state, count(1) as group_total FROM briefcase_email_records GROUP BY from_state");
	

	$products .= "<p style='color: #8f8f8f; font-size: 14px;'>Total number of emails received</p><table id='product_stats'><tr><th colspan='3'>State</th><th># emails received</th>";
	
	while($by_state = mysql_fetch_array($emails_sent_by_state)) {
		$products .= "<tr><td colspan='3'>".$by_state['state']."</td><td>".$by_state['group_total']."</td></tr>";
	}

	while($stat = mysql_fetch_array($emails_sent)) {
		$products .= "<tr><th colspan='3'>Total:</th><td>".$stat['total']."</td></tr>";
	}
	$products .= "</table>";

	echo $products;
} 

// Create the function use in the action hook

function add_briefcase_dashboard_widget() {
	wp_add_dashboard_widget('example_dashboard_widget', 'Product Briefcase Statistics', 'example_dashboard_widget_function');	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions

add_action('wp_dashboard_setup', 'add_briefcase_dashboard_widget' );

// create custom Ajax call for WordPress
add_action( 'wp_ajax_nopriv_search_for_products', 'search_for_products' );
add_action( 'wp_ajax_search_for_products', 'search_for_products' );

add_action( 'wp_ajax_nopriv_create_filter_dropdown', 'create_filter_dropdown' );
add_action( 'wp_ajax_create_filter_dropdown', 'create_filter_dropdown' );

add_action( 'wp_ajax_nopriv_set_briefcase_item', 'set_briefcase_item' );
add_action( 'wp_ajax_set_briefcase_item', 'set_briefcase_item' );

add_action( 'wp_ajax_nopriv_remove_briefcase_item', 'remove_briefcase_item' );
add_action( 'wp_ajax_remove_briefcase_item', 'remove_briefcase_item' );

add_action( 'wp_ajax_nopriv_clear_briefcase', 'clear_briefcase' );
add_action( 'wp_ajax_clear_briefcase', 'clear_briefcase' );

add_action( 'wp_ajax_nopriv_send_briefcase_email', 'send_briefcase_email' );
add_action( 'wp_ajax_send_briefcase_email', 'send_briefcase_email' );

?>
