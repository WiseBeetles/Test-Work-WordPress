<?php
/**
 * TestTheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package TestTheme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'testtheme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function testtheme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on TestTheme, use a find and replace
		 * to change 'testtheme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'testtheme', get_template_directory() . '/languages' );

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
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'testtheme' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'testtheme_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'testtheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function testtheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'testtheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'testtheme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function testtheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'testtheme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'testtheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'testtheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function testtheme_scripts() {
	wp_enqueue_style( 'testtheme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'testtheme-style_layout', get_template_directory_uri().'/css/layout.css', array(), _S_VERSION );
	wp_enqueue_style( 'testtheme-style_media', get_template_directory_uri().'/css/media-queries.css', array(), _S_VERSION );


	wp_style_add_data( 'testtheme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'testtheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'main_script', get_template_directory_uri() . '/js/my_script.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'testtheme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


function wws_adding_scripts() {
	// wp_register_script('my_amazing_script', get_template_directory_uri() . '/js/my_script.js', array('jquery'));
	// wp_enqueue_script('my_amazing_script');
	}
	add_action( 'wp_enqueue_scripts', 'wws_adding_scripts' );

	add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
	function my_scripts_method() {
		// отменяем зарегистрированный jQuery
		// вместо "jquery-core", можно вписать "jquery", тогда будет отменен еще и jquery-migrate
		wp_deregister_script( 'jquery-core' );
		wp_register_script( 'jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
		wp_enqueue_script( 'jquery' );
}




// Hook our custom function to the pre_get_posts action hook
add_action( 'pre_get_posts', 'add_reviews_to_frontpage' );
 
// Alter the main query
function add_reviews_to_frontpage( $query ) {
    if ( is_home() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'bet' ) );
    }
    return $query;}






/*--------------------Test AJAX--------------------------*/



add_action("wp_ajax_my_ajax_action", "k_ajax_my_ajax_action");// для фронтенда 
add_action("wp_ajax_nopriv_my_ajax_action", "k_ajax_my_ajax_action");// для админки
function k_ajax_my_ajax_action(){ 
  
  $x = $_POST['descript'];
  $x = apply_filters( 'my_filter', $x );
  $post_data = array(
	'post_title'    => $_POST['title'],
	'post_status' => 'publish',
	'post_type' => 'bet',
	'post_content'  => $x,
	'comment_status' => 'closed',
	'tax_input'      => array( 'type_bet' => array( $_POST['sel_bet'] ) ),
);

// Вставляем запись в базу данных
$post_id = wp_insert_post( $post_data );
  wp_die();
 }


add_action("wp_ajax_add_meta", "k_ajax_add_meta");// для фронтенда 
add_action("wp_ajax_nopriv_add_meta", "k_ajax_add_meta");// для админки


function k_ajax_add_meta(){ 
  
  	
	add_post_meta( $_POST['id_post'], 'bet_vote', $_POST['stavka'], true );
 }


//Фильтр 
function filter_function( $x ) {
	$x = 'Описание ставки: ' . $x;
	return $x; 
}
 
add_filter( 'my_filter', 'filter_function' );