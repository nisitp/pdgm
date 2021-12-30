<?php $features = get_sub_field('features'); 
  $featureCount = count($features);
  $addClass = get_sub_field('class');
?><section class="fc-features fc-features-<?php print $featureCount;?>-items <?php print $addClass;?>">  
    <?php foreach($features as $feature): ?>
    <div class="fc-features--feature">
      <div class="fc-features--feature--inner">
      <?php if($img = $feature["feature_icon"]): ?>
        <img class="fc-features--feature--icon" alt="<?php print $img["alt"];?>" src="<?php print $img["url"]; ?>" />
      <?php endif; ?>
	    <?php if($headline = $feature["feature_headline"]): ?>
	        <h3 class="fc-features--feature__title"><?php print $headline; ?></h3>
	    <?php endif; ?>
	    <?php if($content = $feature['feature_content']): ?>
	        <div class="fc-features--feature__content">
	            <?php print $content; ?>
	        </div>
	    <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
</section>
