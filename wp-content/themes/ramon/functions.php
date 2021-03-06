<?php
/**
 * ramon functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ramon
 */

if ( ! function_exists( 'ramon_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ramon_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ramon, use a find and replace
	 * to change 'ramon' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ramon',get_template_directory().'/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(array(
		'primary'   => esc_html__( 'Primary', 'ramon' ),
		'secondary' => esc_html__( 'Secondary', 'ramon' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ramon_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'ramon_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ramon_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ramon_content_width', 640 );
}
add_action( 'after_setup_theme', 'ramon_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ramon_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ramon' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ramon' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ramon_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ramon_scripts() {
	wp_enqueue_style( 'ramon-style', get_stylesheet_uri() );
	wp_enqueue_script( 'ramon-navigation', get_template_directory_uri() . '/assets/js/underscores/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'ramon-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/underscores/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'ramon-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ramon_scripts' );

/* Remove default top margin from html tag */
/* ======================================= */
add_action( 'get_header', 'remove_admin_login_header' );
function remove_admin_login_header() {
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
}

/* Add active class to current navigation link */
/* =========================================== */
add_filter( 'nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class( $classes, $item ) {
    if (in_array( 'current-menu-item', $classes ) ){
        $classes[] = 'active ';
    }
    return $classes;
}

/* Remove 'No Term' on Radio Button for Taxonomies */
/* =============================================== */
// add_filter( 'radio-buttons-for-taxonomies-no-term-taxonomy_name', '__return_FALSE' );


/* Initialize all the things */
/* ========================= */
require get_stylesheet_directory() . '/inc/init.php';
