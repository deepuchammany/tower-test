<?php
/**
 * Tower functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Tower
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
function tower_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Tower, use a find and replace
		* to change 'tower' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'tower', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'tower' ),
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
			'tower_custom_background_args',
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
add_action( 'after_setup_theme', 'tower_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tower_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tower_content_width', 640 );
}
add_action( 'after_setup_theme', 'tower_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tower_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'tower' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'tower' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'tower_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tower_scripts() {
	wp_enqueue_style( 'tower-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'tower-style', 'rtl', 'replace' );

	wp_enqueue_script( 'tower-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tower_scripts' );

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

function insurance_policy_init() {
    $labels = array(
        'name' => 'Insurance Policy',
        'singular_name' => 'Insurance',
        'add_new' => 'Add New Policy',
        'add_new_item' => 'Add New Policy',
        'edit_item' => 'Edit Policy',
        'new_item' => 'New Policy',
        'all_items' => 'All Policies',
        'view_item' => 'View Policy',
        'search_items' => 'Search Policies',
        'not_found' =>  'No Policy Found',
        'not_found_in_trash' => 'No Policy found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Insurance Policies',
    );
    
    // register post type
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'insurance-policy'),
        'query_var' => true,
        'menu_icon' => 'dashicons-admin-site',
		'show_in_rest' => true,
		'rest_base' => 'insurance-policy',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports' => array(
            'title'
        )
    );
    register_post_type( 'insurance-policy', $args );
    
    // register taxonomy
    register_taxonomy(
        'insurance-policy-category', 
        'insurance-policy', 
        array(
            'hierarchical' => true, 
            'label' => 'Insurance Policy Category', 
            'query_var' => true, 
            'rewrite' => array( 'slug' => 'insurance-policy-category' )
        )
    );
}
add_action( 'init', 'insurance_policy_init' );

function insurance_policy_meta( ) {
	global $wp_meta_boxes;
	add_meta_box('policy-details', 'Policy Details', 'policy_details', 'insurance-policy', 'normal', 'high');
}
add_action( 'add_meta_boxes_insurance-policy', 'insurance_policy_meta' );

function policy_details()
{
	global $post;
	$custom = get_post_custom($post->ID);
	$policy_id = isset($custom["policy_id"][0])?$custom["policy_id"][0]:'';
	$live_date = isset($custom["live_date"][0])?$custom["live_date"][0]:'';
	$description = isset($custom["description"][0])?$custom["description"][0]:'';
?>
	<div class="form-group">
		<label>Policy ID : </label><input name="policy_id" type="number" value="<?php echo $policy_id; ?>" required>
	</div><br>
	<div class="form-group">
		<label>Live Date : </label><input name="live_date" type="date" value="<?php echo $live_date; ?>" required>
	</div><br>
	<div class="form-group">
		<label for="description">Description:</label>
		<textarea class="form-control" name="description" id="description"><?php echo $description; ?></textarea>
	</div>
<?php
}

function change_default_title( $title ){
	$screen = get_current_screen();
	if  ( 'insurance-policy' == $screen->post_type ) {
		 $title = 'Enter Policy Name';
	}
	if  ( 'insurance-claim' == $screen->post_type ) {
		 $title = 'Enter Name';
	}
	return $title;
}
add_filter( 'enter_title_here', 'change_default_title' );

function insurance_policy_save_post()
{
    if(empty($_POST)) return; //why is insurance_policy_save_post triggered by add new? 
    global $post;
    update_post_meta($post->ID, "policy_id", $_POST["policy_id"]);
    update_post_meta($post->ID, "live_date", $_POST["live_date"]);
    update_post_meta($post->ID, "description", $_POST["description"]);
}   

add_action( 'save_post_insurance-policy', 'insurance_policy_save_post' );

// Load custom scripts
function load_custom_scripts() {
	
	if ( 'insurance-policy' == get_post_type() ) {
		wp_enqueue_script( 'admin_scripts', get_template_directory_uri() . '/assets/js/custom-insurance.js', array( 'jquery' ) );
	}

	if ( 'insurance-claim' == get_post_type() ) {
		wp_enqueue_script( 'admin_scripts', get_template_directory_uri() . '/assets/js/custom-claim.js', array( 'jquery' ) );
	}

}
add_action( 'admin_enqueue_scripts', 'load_custom_scripts' );

function insurance_claim_init() {
    $labels = array(
        'name' => 'Insurance Claim',
        'singular_name' => 'Insurance',
        'add_new' => 'Add New Claim',
        'add_new_item' => 'Add New Claim',
        'edit_item' => 'Edit Claim',
        'new_item' => 'New Claim',
        'all_items' => 'All Claims',
        'view_item' => 'View Claim',
        'search_items' => 'Search Claims',
        'not_found' =>  'No Claims Found',
        'not_found_in_trash' => 'No Claims found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Insurance Claims',
    );
    
    // register post type
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'insurance-claim'),
        'query_var' => true,
        'menu_icon' => 'dashicons-admin-site',
		'show_in_rest' => true,
		'rest_base' => 'insurance-claim',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports' => array(
            'title'
        )
    );
    register_post_type( 'insurance-claim', $args );
    
    // register taxonomy
    register_taxonomy(
        'insurance-claim-category', 
        'insurance-claim', 
        array(
            'hierarchical' => true, 
            'label' => 'Insurance Claim Category', 
            'query_var' => true, 
            'rewrite' => array( 'slug' => 'insurance-claim-category' )
        )
    );
}
add_action( 'init', 'insurance_claim_init' );

function insurance_claim_meta() {
	global $wp_meta_boxes;
	add_meta_box('claim-details', 'Claim Details', 'claim_details', 'insurance-claim', 'normal', 'high');
}
add_action( 'add_meta_boxes_insurance-claim', 'insurance_claim_meta' );

function claim_details()
{
	global $post;
	$custom = get_post_custom($post->ID);
	$policy_id = isset($custom["policy_id"][0])?$custom["policy_id"][0]:'';
	$email = isset($custom["email"][0])?$custom["email"][0]:'';
?>
	<div class="form-group">
		<label>Policy ID : </label><input name="policy_id" type="number" value="<?php echo $policy_id; ?>" required>
	</div><br>
	<div class="form-group">
		<label>Email : </label><input name="email" type="email" value="<?php echo $email; ?>" required>
	</div>
<?php
}

function insurance_claim_save_post()
{
    if(empty($_POST)) return; //why is insurance_policy_save_post triggered by add new? 
    global $post;
    update_post_meta($post->ID, "policy_id", $_POST["policy_id"]);
    update_post_meta($post->ID, "email", $_POST["email"]);
}   

add_action( 'save_post_insurance-claim', 'insurance_claim_save_post' );
