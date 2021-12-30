<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

/**
 * Twenty Nineteen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

if ( ! function_exists( 'pdgmpro_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pdgmpro_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Nineteen, use a find and replace
		 * to change 'pdgmpro' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'pdgmpro', get_template_directory() . '/languages' );

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
		set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'pdgmpro' ),
				'footer' => __( 'Footer Menu', 'pdgmpro' ),
				'social' => __( 'Social Links Menu', 'pdgmpro' ),
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
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 190,
				'width'       => 190,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'pdgmpro' ),
					'shortName' => __( 'S', 'pdgmpro' ),
					'size'      => 19.5,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'pdgmpro' ),
					'shortName' => __( 'M', 'pdgmpro' ),
					'size'      => 22,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'pdgmpro' ),
					'shortName' => __( 'L', 'pdgmpro' ),
					'size'      => 36.5,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'pdgmpro' ),
					'shortName' => __( 'XL', 'pdgmpro' ),
					'size'      => 49.5,
					'slug'      => 'huge',
				),
			)
		);

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'pdgmpro' ),
					'slug'  => 'primary',
					'color' => pdgmpro_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 33 ),
				),
				array(
					'name'  => __( 'Secondary', 'pdgmpro' ),
					'slug'  => 'secondary',
					'color' => '#0F294F'
//					'color' => pdgmpro_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 23 ),
				),
				array(
					'name'  => __( 'Dark Gray', 'pdgmpro' ),
					'slug'  => 'dark-gray',
					'color' => '#DDDDDD',
				),
				array(
					'name'  => __( 'Blue', 'pdgmpro' ),
					'slug'  => 'blue',
					'color' => '#5FB7D1',
				),
				
				array(
					'name'  => __( 'Light Gray', 'pdgmpro' ),
					'slug'  => 'light-gray',
					'color' => '#F6F6F6',
				),
				array(
					'name'  => __( 'White', 'pdgmpro' ),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );		

    // quick hacks
    if (substr($_SERVER['REQUEST_URI'],0,9) == '/register' && is_user_logged_in()) { 
      wp_redirect('/report'); exit();
    } else if (substr($_SERVER['REQUEST_URI'],0,7) == '/report' && is_user_logged_in()!=1) {
      wp_redirect('/register'); exit();
    }

	}
endif;
add_action( 'after_setup_theme', 'pdgmpro_setup' );

include("inc/gutenberg-acf.php");
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pdgmpro_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'pdgmpro' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'pdgmpro' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	// GC adds for header
	register_sidebar(
		array(
			'name'          => __( 'Header', 'pdgmpro' ),
			'id'            => 'header-widgets',
			'description'   => __( 'Add widgets here to appear in your header.', 'pdgmpro' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	

}
add_action( 'widgets_init', 'pdgmpro_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function pdgmpro_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'pdgmpro_content_width', 640 );
}
add_action( 'after_setup_theme', 'pdgmpro_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function pdgmpro_scripts() {
	wp_enqueue_style( 'pdgmpro-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	wp_style_add_data( 'pdgmpro-style', 'rtl', 'replace' );

	if ( has_nav_menu( 'menu-1' ) ) {
//		wp_enqueue_script( 'pdgmpro-priority-menu', get_theme_file_uri( '/js/priority-menu.js' ), array(), '1.1', true );
		wp_enqueue_script( 'pdgmpro-touch-navigation', get_theme_file_uri( '/js/touch-keyboard-navigation.js' ), array(), '1.1', true );
	}

	wp_enqueue_style( 'pdgmpro-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pdgmpro_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function pdgmpro_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'pdgmpro_skip_link_focus_fix' );

/**
 * Enqueue supplemental block editor styles.
 */
function pdgmpro_editor_customizer_styles() {

	wp_enqueue_style( 'pdgmpro-editor-customizer-styles', get_theme_file_uri( '/style-editor-customizer.css' ), false, '1.1', 'all' );

	if ( 'custom' === get_theme_mod( 'primary_color' ) ) {
		// Include color patterns.
		require_once get_parent_theme_file_path( '/inc/color-patterns.php' );
		wp_add_inline_style( 'pdgmpro-editor-customizer-styles', pdgmpro_custom_colors_css() );
	}
}
add_action( 'enqueue_block_editor_assets', 'pdgmpro_editor_customizer_styles' );

/**
 * Display custom color CSS in customizer and on frontend.
 */
function pdgmpro_colors_css_wrap() {

	// Only include custom colors in customizer or frontend.
	if ( ( ! is_customize_preview() && 'default' === get_theme_mod( 'primary_color', 'default' ) ) || is_admin() ) {
		return;
	}

	require_once get_parent_theme_file_path( '/inc/color-patterns.php' );

	$primary_color = 199;
	if ( 'default' !== get_theme_mod( 'primary_color', 'default' ) ) {
		$primary_color = get_theme_mod( 'primary_color_hue', 199 );
	}
	?>

	<style type="text/css" id="custom-theme-colors" <?php echo is_customize_preview() ? 'data-hue="' . absint( $primary_color ) . '"' : ''; ?>>
		<?php echo pdgmpro_custom_colors_css(); ?>
	</style>
	<?php
}
add_action( 'wp_head', 'pdgmpro_colors_css_wrap' );

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-pdgmpro-svg-icons.php';

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/class-pdgmpro-walker-comment.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/* Hot Sauce adds */


function pdgm_acf_user_id() {
  $uid = get_current_user_id();
  return $uid;
}

function pdgm_acf_npi() {
  
  if ($_GET["auth"] && $_SESSION["npi"]) {
    return $_SESSION["npi"];
  } else {
    $uid = get_current_user_id();
    return (get_field('agency_npi', 'user_'.$uid) ? get_field('agency_npi', 'user_'.$uid) : $default);
  }
}
 
add_shortcode( 'pdgm_uid', 'pdgm_acf_user_id' );
add_shortcode( 'pdgm_npi', 'pdgm_acf_npi' );


function pdgm_get_auth_npi() {
  if ($_GET["auth"]) {
    require_once("inc/jwt-class.php");
    
    // we're getting a key so let's authenticate with that instead.
    $secret = "[some private secret key that isn't stored in code but loaded from a safe place]"; // should ideally be moved somewhere (e.g. environment var) but not sure we have that option.
//    $alg = new HS256Algorithm($secret)

    $data = JWT::decode($_GET["auth"], $secret, 'HS256') or die("died here :(");    
    $ts = $data->timestamp;
    
    if (time() - $ts > 1800) { wp_safe_redirect("/access-expired") or print("Can't redirect"); exit; }
    $_SESSION["npi"] = $data->npi;    
  } 

}
add_action('init', pdgm_get_auth_npi);

function pdgm_report_scripts() {
	wp_enqueue_script( 'pdgmpro-custom-scripts_main', get_theme_file_uri( '/js/pdgmpro.js' ), array(), '1.1', true ); 
	if (is_page(2) || is_page(460)) {	
//		print get_template_directory() . '/pdgmtool/scripts/tabulator.min.js'; exit;
		wp_enqueue_style( 'pdgmpro-custom-style-tabulator', '/pdgmtool/styles/tabulator.min.css' );
		wp_enqueue_script( 'pdgmpro-custom-scripts_tabulator', '/pdgmtool/scripts/tabulator.min.js', array(), false, true );
	}
} 

add_action('wp_enqueue_scripts', 'pdgm_report_scripts');

require get_template_directory() . '/inc/custom-post-types.php';


/*

//adding AFC form head
function add_acf_form_head(){
    global $post;
    
  if ( !empty($post) && has_shortcode( $post->post_content, 'my_acf_user_form' ) ) {
        acf_form_head();
    }
}
add_action( 'wp_head', 'add_acf_form_head', 7 );
*/


add_filter('frm_validate_field_entry', 'pdgm_validate', 10, 3);

function pdgm_validate($errors, $posted_field, $posted_value) {
  switch ( $posted_field->id ) {
    
    case 27:  // NPI field
    case 34:  // NPI field on the profile form
      // disable SSL checking stuff
      $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
      );  
    
      $api = "https://" . $_SERVER['SERVER_NAME'] . '/pdgmtool/index.php?function=count&npi=' . $posted_value;  
      // disable SSL checking stuff
      
      // connect to it
      $response = file_get_contents($api, false, stream_context_create($arrContextOptions));
      if ($response <= 0) {       
        $errors['field'.$posted_field->id ] = $posted_value . ' does not appear to be a valid NPI. Please check and try again.'; 
        
      }
    
      break;
    
    case 19:
    
      // very simple validation of email against blocked addresses
      $email = $posted_value; // just to keep me sane.
      $blacklist = file(get_template_directory() . "/inc/blocked-emails.inc", FILE_IGNORE_NEW_LINES);
      $blacklist = array_map('strtolower', $blacklist);


      // Make sure the address is valid
      if (filter_var($email, FILTER_VALIDATE_EMAIL))
      {
          // Separate string by @ characters (there should be only one)
          $parts = explode('@', $email);
      
          // Remove and return the last part, which should be the domain
          $domain = strtolower(array_pop($parts));
      
          // Check if the domain is in our list
          if ( in_array($domain, $blacklist))
          {
              $errors['field19'] = "Sorry, registrations from $domain are not accepted at this time.";
          }
      }
      
      break;
      
    default:
    
  }
  return $errors;
//   print "<pre>"; print_r($errors); print "</pre>"; 
}

// Add a new role for Customers
add_role(
    'customer',
    __( 'Customer' ),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
        'delete_posts' => false, // Use false to explicitly deny
    )
);


if (!current_user_can('administrator')) {
  show_admin_bar(false);
}

add_action( 'load-profile.php', function() {
    if( ! current_user_can( 'manage_options' ) )
        exit( wp_safe_redirect( admin_url() ) );
} );


if (!is_admin()) {
  wp_enqueue_script('pdgmpro-jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js");
}
// login / out


add_shortcode( 'pdgm_loginorout', 'add_loginout_link');

function add_loginout_link() {
  if (is_user_logged_in()) {
    return "<a href='" . wp_logout_url(get_permalink()) . "'>Log Out</a>";
  } else {
    return "<a href='/log-in'>Log In</a>";
  }
}

add_shortcode( 'pdgm_profilelink', 'add_profile_nav_link');

function add_profile_nav_link() {
  if (is_user_logged_in()) {
    $user = wp_get_current_user();
    if ( in_array( 'customer', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles )  ) {
      return "<a href='/edit-profile/'>Edit Profile</a>";
    } 
  }
  return "";
}


//require get_template_directory() . '/inc/alert-topbar.php'; // functions for generating alert 'top bars'

