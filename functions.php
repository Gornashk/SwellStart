<?php
/************* CUSTOM WP LOGIN FORM *****************/

function my_custom_login() { 
	$logo = get_field('site_logo', 'options'); ?>
    <style type="text/css">
        body.login div#login h1 a {
            background: url("<?php echo $logo['sizes']['medium']; ?>") no-repeat center center !important;
			width:100%;
            padding-bottom: 50px;
        }
        body.login {}
		body.login div#login {}
		body.login div#login h1 {}
		body.login div#login h1 a {}
		body.login div#login form#loginform {}
		body.login div#login form#loginform p {}
		body.login div#login form#loginform p label {}
		body.login div#login form#loginform input {}
		body.login div#login form#loginform input#user_login {}
		body.login div#login form#loginform input#user_pass {}
		body.login div#login form#loginform p.forgetmenot {}
		body.login div#login form#loginform p.forgetmenot input#rememberme {}
		body.login div#login form#loginform p.submit {}
		body.login div#login form#loginform p.submit input#wp-submit {
			background-image: none;
			-webkit-box-shadow: none;
			-moz-box-shadow: none;
			box-shadow: none;
			background: #0079c2;
		}
		body.login div#login form#loginform p.submit input#wp-submit:hover {
			background-color: #636363;
		}
		body.login div#login p#nav {
			color: #0079c2 !important;
		}
		body.login div#login p#nav a {
			color: #0079c2 !important;
		}
		body.login div#login p#nav a:hover {
			color: #636363 !important;
		}
		body.login div#login p#backtoblog {}
		body.login div#login p#backtoblog a {
			color: #0079c2 !important;
		}
		body.login div#login p#backtoblog a:hover {
			color: #636363 !important;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_custom_login' );

//Change Login Logo URL

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'A Classic Party Rental';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

// Add styles to the WYSIWYG editor 
add_editor_style('css/admin.css');

add_filter( 'mce_buttons_2', 'fb_mce_editor_buttons' );
function fb_mce_editor_buttons( $buttons ) {

    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

function wpa_45815($arr){
    $arr['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    return $arr;
  }
add_filter('tiny_mce_before_init', 'wpa_45815');

/**
 * Add styles/classes to the "Styles" drop-down
 */ 
add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );

function fb_mce_before_init( $settings ) {

    $style_formats = array(
        array(
            'title' => 'Intro Text',
            'selector' => 'p',
            'classes' => 'intro',
        ),
		array(
			'title' => 'Button',
			'selector' => 'a',
			'classes' => 'btn',
		),
		/*
        array(
            'title' => 'AlertBox',
            'block' => 'div',
            'classes' => 'alert_box',
            'wrapper' => true
        ),
		
        array(
            'title' => 'Red Uppercase Text',
            'inline' => 'span',
            'styles' => array(
                'color'         => 'red', // or hex value #ff0000
                'fontWeight'    => 'bold',
                'textTransform' => 'uppercase'
            )
        )
		*/
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

// Enable Featured Image
if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}

// custom post types and icons
function register_custom_posts() { 

	// replace 'replace_this' with the custom post type information
	register_post_type( 'post_type', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		 	// let's now add all the options for this post type
			array('labels' => array(
				'name' => __('Post Types'), /* This is the Title of the Group */
				'singular_name' => __('Post Type'), /* This is the individual type */
				'all_items' => __('All Post Types'), /* the all items menu item */
				'add_new' => __('Add New'), /* The add new menu item */
				'add_new_item' => __('Add New Post Type'), /* Add New Display Title */
				'edit' => __( 'Edit' ), /* Edit Dialog */
				'edit_item' => __('Edit Post Type'), /* Edit Display Title */
				'new_item' => __('New Post Type'), /* New Display Title */
				'view_item' => __('View Post Type'), /* View Display Title */
				'search_items' => __('Search Post Types'), /* Search Custom Type Title */ 
				'not_found' =>  __('No Post Types Found.'), /* This displays if there are no entries yet */ 
				'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
				), /* end of arrays */
				'description' => __( 'The Post Types.' ), /* Custom Type Description */
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => '', /* this is what order you want it to appear in on the left hand side menu */ 
				'menu_icon' => get_stylesheet_directory_uri() . '/img/wp-icon-clients-16.png', /* 16px x 16px */
				'rewrite'	=> array( 'slug' => 'clients', 'with_front' => true ), /* you can specify its url slug */
				'has_archive' => 'clients-archive', /* you can rename the slug here */
				'capability_type' => 'post',
				'hierarchical' => false,
				/* the next one is important, it tells what's enabled in the post editor */
				'supports' => array('title') // all of the post capabilities
		 	) /* end of options */
	); /* end of register post type */

}
add_action( 'init', 'register_custom_posts');

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();	
}
if( function_exists('acf_add_options_sub_page') )
{
    acf_add_options_sub_page( 'General Options' );
}

// Add function is_tree to use (such as if(is_tree(7));
function is_tree($pid) { // $pid = The ID of the page we’re looking for pages underneath
global $post; // load details about this page
$anc = get_post_ancestors( $post->ID );
foreach($anc as $ancestor) {
if(is_page() && $ancestor == $pid) {
return true;
}
}
if(is_page()&&(is_page($pid)))
return true; // we’re at the page or at a sub page
else
return false; // we’re elsewhere
};

// Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

// Limit Excerpt Length Option
// Use: echo limit_words(get_the_excerpt(), '35');
function limit_words($string, $word_limit) {
 
	// creates an array of words from $string (this will be our excerpt)
	// explode divides the excerpt up by using a space character
 
	$words = explode(' ', $string);
 
	// this next bit chops the $words array and sticks it back together
	// starting at the first word '0' and ending at the $word_limit
	// the $word_limit which is passed in the function will be the number
	// of words we want to use
	// implode glues the chopped up array back together using a space character
 
	return implode(' ', array_slice($words, 0, $word_limit));
 
}

// Excerpt More Link
function new_excerpt_more($more) {
       global $post;
	return '...<br><br><a class="more-link" href="'. get_permalink($post->ID) . '">Read More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

if ( ! function_exists( 'underscores_starter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function underscores_starter_setup() {


	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'main-menu' => __( 'Main Menu', 'underscores_starter' ),
		'footer-menu' => __( 'Footer Menu', 'underscores_starter' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // underscores_starter_setup
add_action( 'after_setup_theme', 'underscores_starter_setup' );



/**
 * Register widgetized area and update sidebar with default widgets
 */
function underscores_starter_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'underscores_starter' ),
		'id'            => 'main-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'underscores_starter_widgets_init' );

// Add Jquery
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

/**
 * Enqueue scripts and styles
 */
function underscores_starter_scripts() {
	wp_enqueue_style( 'style-less', get_template_directory_uri() . '/less/style.less' );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '', false );
  wp_enqueue_script( 'vue-js', get_template_directory_uri() . '/js/vue.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array('jquery', 'vue-js'), '', true );



}
add_action( 'wp_enqueue_scripts', 'underscores_starter_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


// Custom WordPress Admin Footer
function remove_footer_admin () {
	echo 'Website Development by Springboard Marketing';
}
add_filter('admin_footer_text', 'remove_footer_admin');

//Remove unneccsary Dashboard widgets
function remove_dashboard_widgets(){
  global$wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); 
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');


//Remove comments count from Edit Pages and Edit Posts
function custom_post_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}

add_filter('manage_posts_columns', 'custom_post_columns');

function custom_pages_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}

add_filter('manage_pages_columns', 'custom_pages_columns');


/**********************
Start a new session if one doesn't already exist
**********************/
function register_my_session()
{
	if( !session_id() ) {
		session_start();
	}
}

add_action('init', 'register_my_session');

//Custom PHP Helper function to add <pre></pre> tags around any print_r() when called as printr();
function printr($data)
{
    echo "<pre>";
    echo print_r($data, true); // or var_dump($data);
    echo "</pre>";
}

// Remove the Wordpress Admin Bar for all users except for Administrators
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}

?>