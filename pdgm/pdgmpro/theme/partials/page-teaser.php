<?php 
  $categories = get_the_terms($post, 'wf_page_folders'); 
//  print "<pre>"; print_r($categories); exit;
  
  // we only want the top-level category
  foreach ($categories as $cat) {
    if ($cat->parent == 0) {
      $category = $cat->name;
      break;
    }
  }
  
  // if there was no top-level category, use the first tag instead.  
  if (!$category) $category = $categories[0]->name;
  
  // RISKY - trimming the last "s". Will need to fix if we add categories that end in 's'.
  if (substr($category,-1) == "s") {
    $category = substr($category,0, -1);
    $categorylc = strtolower($category);
  }
  
?>
<div class="teaser portfolio-item portfolio-item--teaser portfolio-<?php print $categorylc;?>">
  <div class="portfolio-item-category"><?php print $category;?></div>
  <a href="<?php print the_permalink();?>">
    <h3><?php print the_title(); ?></h3>
    
    <div class="excerpt portfolio-item--teaser--excerpt">
      <?php print the_excerpt(); ?>
    </div>
  </a>
</div>
