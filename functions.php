<?php
/**
 * JM-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package JM-theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jm_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on JM-theme, use a find and replace
		* to change 'jm-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'jm-theme', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'jm-theme' ),
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
			'jm_theme_custom_background_args',
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
add_action( 'after_setup_theme', 'jm_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jm_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jm_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'jm_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jm_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'jm-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'jm-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'jm_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jm_theme_scripts() {
	// Enqueue the main stylesheet
	wp_enqueue_style( 'jm-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'jm-theme-style', 'rtl', 'replace' );

	// Enqueue the navigation script
	wp_enqueue_script( 'jm-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	// Enqueue the comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue the infinite scroll script
	wp_enqueue_script( 'infinite-scroll', get_template_directory_uri() . '/js/infinite-scroll.js', array('jquery'), null, true );

	// Localize the script to pass AJAX URL
	wp_localize_script( 'infinite-scroll', 'ajax_url', array(
		'url' => admin_url( 'admin-ajax.php' )
	));

	// Enqueue the infinite scroll CSS
	wp_enqueue_style( 'jm-theme-infinite-scroll', get_template_directory_uri() . '/css/style.css', array(), _S_VERSION );
}
add_action( 'wp_enqueue_scripts', 'jm_theme_scripts' );

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


// AJAX more load
function jm_load_more_posts() {
    $paged = $_POST['page'];

    $query = new WP_Query(array(
        'post_type' => 'post', 
        'paged' => $paged, 
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', get_post_format());
        }
    }

    wp_reset_postdata();

    die(); 
}

// Register the AJAX action for logged-in and non-logged-in users
add_action('wp_ajax_load_more_posts', 'jm_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'jm_load_more_posts');









// Add Font Color Setting for given task
function jm_customize_register($wp_customize) {
    
    $wp_customize->add_section('jm_font_color_section', array(
        'title'    => __('Font Color JM by Adeel', 'jm-theme'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('jm_font_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'jm_font_color', array(
        'label'    => __('Font Color', 'jm-theme'),
        'section'  => 'jm_font_color_section',
        'settings' => 'jm_font_color',
    )));
}
add_action('customize_register', 'jm_customize_register');

function jm_customize_css() {
    ?>
    <style type="text/css">
        body {
            color: <?php echo esc_attr(get_theme_mod('jm_font_color', '#000000')); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'jm_customize_css');



// adding logo option in wp customizer
function jm_custom_logo_register($wp_customize) {
    $wp_customize->add_section('jm_logo_section', array(
        'title'    => __('Custom Logo JM by Adeel', 'jm-theme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('jm_custom_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'jm_custom_logo',
        array(
            'label'    => __('Upload Custom Logo JM', 'jm-theme'),
            'section'  => 'jm_logo_section',
            'settings' => 'jm_custom_logo',
        )
    ));
	
}
add_action('customize_register', 'jm_custom_logo_register');



// custom page rating functionality

// registering meta box
function add_rating_meta_box() {
    add_meta_box(
        'page_rating', 
        __('Page Rating', 'jm-theme'),
        'render_rating_meta_box', 
        'page',
        'side', 
        'high' 
    );
}
add_action('add_meta_boxes', 'add_rating_meta_box');

// rendring
function render_rating_meta_box($post) {
    $rating = get_post_meta($post->ID, '_page_rating', true);

    wp_nonce_field('save_rating_meta_box', 'rating_meta_box_nonce');

    ?>
    <label for="page_rating"><?php _e('Set Rating (1-5):', 'jm-theme'); ?></label>
    <select name="page_rating" id="page_rating">
        <option value=""><?php _e('Select Rating', 'jm-theme'); ?></option>
        <?php for ($i = 1; $i <= 5; $i++) : ?>
            <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
    <?php
}

//saving
function save_rating_meta_box($post_id) {
    if (!isset($_POST['rating_meta_box_nonce']) || !wp_verify_nonce($_POST['rating_meta_box_nonce'], 'save_rating_meta_box')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['page_rating']) && in_array($_POST['page_rating'], range(1, 5))) {
        update_post_meta($post_id, '_page_rating', intval($_POST['page_rating']));
    } else {
        delete_post_meta($post_id, '_page_rating'); 
    }
}
add_action('save_post', 'save_rating_meta_box');


