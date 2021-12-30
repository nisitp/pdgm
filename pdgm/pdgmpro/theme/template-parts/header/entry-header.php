<?php			
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

$discussion = ! is_page() && pdgmpro_can_show_post_thumbnail() ? pdgmpro_get_discussion_data() : null; ?>

<?php 
	$hasHero = 0;
	if ( has_blocks( $post->post_content ) ) {
		$blocks = parse_blocks( $post->post_content );
		if ($blocks[0]["blockName"] == "acf/hero") {
			$hasHero = 1;
		}
	}
	
?>	
<?php if (! $hasHero) {
	 print "<div class='header__inner'>";
	 the_title( '<h1 class="entry-title">', '</h1>' ); 
	 }
	 ?>

<?php if ( ! is_page() ) : ?>
<div class="entry-meta">
	<?php pdgmpro_posted_by(); ?>
	<?php pdgmpro_posted_on(); ?>
	<span class="comment-count">
		<?php
		if ( ! empty( $discussion ) ) {
			pdgmpro_discussion_avatars_list( $discussion->authors );
		}
		?>
		<?php pdgmpro_comment_count(); ?>
	</span>
	<?php
	// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'pdgmpro' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">' . pdgmpro_get_icon_svg( 'edit', 16 ),
			'</span>'
		);
	?>
</div><!-- .meta-info -->
<?php endif; ?>

<?php if (! $hasHero) print "</div>";
	