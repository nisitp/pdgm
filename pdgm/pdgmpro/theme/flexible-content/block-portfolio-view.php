<?php 
  // how we get the fields depends on whether we're in a 'flexible content' block or direct (i.e. via gutenberg editor)  
  if (get_field('flexible_content')) {
    $function = 'get_sub_field';
  } else {
    $function = 'get_field';
  }

  /* Generate our query */
  $category = $function('category');
  if (!$category) {
    $cat = get_query_var('category');
    if ($cat && $cat != "all") $category[] = $cat;
  }

  global $wp_query; 
//    echo paginate_links();

  $btpgid=get_queried_object_id();
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
//  $paged = false;
  $postsPerPage = $function('items_to_show');
  if ($postsPerPage == -1) {
    $postsPerPage = $function('items_per_page');
    $showPager = 1;  
  } else { $paged = false; $showPager = false; }
  
  $postOffset = $paged * $postsPerPage;
    
  $tax_query = [];

  if (is_array($category)) {
    $tax_query[] = [
        'taxonomy' => 'portfolio-category',
        'field'    => 'term_id',
        'terms'    => $category,
        'field'    => 'slug'
    ];
  }

  $post_type = array('eh_resource');
  
  $args = array(
     'post_type' => $post_type,
     'tax_query' => $tax_query,
     'orderby' => array(
      'post_date' => 'desc',
      ),
      'paged' => $paged,
      'posts_per_page'  => $postsPerPage,
  );

  if ($function('limit_to_featured') == true) {
    if (is_front_page()) {
     $args['meta_key'] = 'promote_home';
    } else {
      $args['meta_key'] = 'promote_related';
    }  
    $args['meta_value'] = true;    
  } 
  
// print "<pre>"; print_r($args); exit;  
  $postslist = new WP_Query( $args );
?>
<?php $addClass = $function('class'); ?>
<section class="fc-portfolio-view">
  <?php if($function('headline')): ?>
      <h2 class="fc-teaser-grid__title"><?php print $function('headline'); ?></h2>
  <?php endif; ?>
  <div class="fc-portfolio-view__items">
    <?php
      
//      print '<pre>'; print_r($postslist); exit;
      // save our original $post object
      global $post;
      $oldpost = $post;
      
      // loop through our items
    foreach($postslist->posts as $post): ?>    
      <div class="fc-portfolio-view__items--item">
        <?php get_template_part('partials/'.$post->post_type, 'teaser'); ?>      
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php 
  //reset post
  $post = $oldpost;
  wp_reset_postdata();

if ($showPager) {
  // Custom query loop pagination
  next_posts_link( '« Older Resources', $postslist->max_num_pages );      
  previous_posts_link( 'Newer Resources »' ); 
}  
?>