<?php
  // ACF gutenberg blocks
  
function hs_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'flexible-content',
				'title' => __( 'Flexible Content Blocks', 'flexible-content' ),
				'icon'	=> 'admin-settings',				
			),
		)
	);
}
add_filter( 'block_categories', 'hs_block_category', 10, 2);
  
function acf_block_render_callback( $block, $content = '', $is_preview = false ) {
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/flexible-content/block-{$slug}.php") ) ) {
		include( get_theme_file_path("/flexible-content/block-{$slug}.php") );
	} else {
  	print "[Template not defined - get Hot Sauce to fix!]";
	}
	
}

add_action('acf/init', 'pdgm_register_blocks');

function pdgm_register_blocks() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'hero',
			'title'				=> __('Hero Banner'),
			'description'		=> __('Custom hero block'),
			'render_callback'	=> 'acf_block_render_callback',
			'category'			=> 'flexible-content',
			'icon'				=> 'admin-comments',			
			'keywords'			=> array( 'hero', 'banner' ),
			'mode' => 'edit',			
		));
		
		acf_register_block(array(
			'name'				=> 'portfolio-view',
			'title'				=> __('Portfolio View'),
			'description'		=> __('Show items based on tags in a portfolio view'),
			'render_callback'	=> 'acf_block_render_callback',
			'category'			=> 'flexible-content',
			'icon'				=> 'admin-settings',
			'mode' => 'edit',
			'keywords'			=> array( 'solutions', 'features', 'thumbnails' ),
		));		
		
	} 
}
?>