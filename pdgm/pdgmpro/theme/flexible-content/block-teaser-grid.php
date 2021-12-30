<?php 
  // quick hack for looping
  global $post;
  $oldpost = $post;
?>

<?php $addClass = get_sub_field('class'); ?>
<section class="fc-teaser-grid <?php print $addClass;?>">
  <?php if(get_sub_field('headline')): ?>
      <h2 class="fc-teaser-grid__title"><?php print get_sub_field('headline'); ?></h2>
  <?php endif; ?>
  <div class="fc-teaser-grid__items">
    <?php foreach(get_sub_field('items') as $i => $post): ?>
    <div class="fc-teaser-grid--row">
      <?php get_template_part('partials/'.$post->post_type, 'teaser'); ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php // reset post
  $post = $oldpost;
?>