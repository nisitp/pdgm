<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?>
<div class="site-branding">
   <p class="print-only print-logo"><img src="/wp-content/themes/pdgmpro/assets/images/pdgm-pro-logo.png" alt="Trella Health Logo" /></p>
	<?php $blog_info = get_bloginfo( 'name' ); ?>
	<?php if ( ! empty( $blog_info ) ) : ?>
		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>		<span>fueled by <a href="https://www.trellahealth.com/">Trella Health</a></span></div>
</h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> 		<span>fueled by <a href="https://www.trellahealth.com/">Trella Health</a></span></div>
</p>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	$description = get_bloginfo( 'description', 'display' );
	if ( $description || is_customize_preview() ) :
		?>
			<p class="site-description">
				<?php echo $description; ?>
			</p>
	<?php endif; ?>
	<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'pdgmpro' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_class'     => 'main-menu',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	<?php endif; ?>
	<?php if ( has_nav_menu( 'social' ) ) : ?>
		<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'pdgmpro' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'social',
					'menu_class'     => 'social-links-menu',
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>' . pdgmpro_get_icon_svg( 'link' ),
					'depth'          => 1,
				)
			);
			?>
		</nav><!-- .social-navigation -->
	<?php endif; ?>
	<?php 
	if ( is_active_sidebar( 'header-widgets' ) ) : ?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Header', 'pdgmpro' ); ?>">
		<?php
			if ( is_active_sidebar( 'header-widgets' ) ) {
				?>
					<div class="widget-column footer-widget-1">
						<?php dynamic_sidebar( 'header-widgets' ); ?>
					</div>
				<?php
			}
		?>
	</aside><!-- .widget-area -->
  <?php endif; ?>
</div><!-- .site-branding -->
