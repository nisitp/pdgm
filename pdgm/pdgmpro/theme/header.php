<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
global $show_header; 

 
if ( has_blocks( $post->post_content ) ) {
	$blocks = parse_blocks( $post->post_content );
	if ($blocks[0]["blockName"] == "acf/hero") {
		$hasHero = 1;
		$classes[] = "with-hero";
	}
}

if ( ! is_home() && ! is_front_page() ) $classes[] = "not-home";
 
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <script src="//app-sj27.marketo.com/js/forms2/js/forms2.min.js"></script>
</head>

<body <?php body_class($classes); ?>>
<?php // get_alert(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'pdgmpro' ); ?></a>

<?php if ($show_header !== 0): ?>
		<header id="masthead" class="<?php echo is_singular() && pdgmpro_can_show_post_thumbnail() ? 'site-header featured-image' : 'site-header'; ?>">

			<div class="site-branding-container">
				<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
			</div><!-- .layout-wrap -->

			<?php if ( is_singular() && pdgmpro_can_show_post_thumbnail() ) : ?>
				<div class="site-featured-image">
					<?php
						pdgmpro_post_thumbnail();
						the_post();
						$discussion = ! is_page() && pdgmpro_can_show_post_thumbnail() ? pdgmpro_get_discussion_data() : null;

						$classes = 'entry-header';
						if ( ! empty( $discussion ) && absint( $discussion->responses ) > 0 ) {
							$classes = 'entry-header has-discussion';
						}
					?>
					<div class="<?php echo $classes; ?>">
						<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
					</div><!-- .entry-header -->
					<?php rewind_posts(); ?>
				</div>
			<?php endif; ?>
		</header><!-- #masthead -->
<?php endif; ?>
	<div id="content" class="site-content">
