<?php
	
	// reworked for PDGM layout needs
	
$background = get_field('background');
$style = $background['type'] == 'image'
    ? "background-image: url('".esc_attr($background['image'])."');"
    : "";

$hcontent = get_field('hero_content');
$button = get_field('button');
$button['link'] = $button['link']['link_to'] == 'internal'
    ? get_permalink($button['link']['link'])
    : $button['link']['link'];

$featured_content = get_field('featured_content');

$featured_content_image = isset($featured_content['content']) && $featured_content['content'][0]['image'];
?>
<section class="fc-hero <?php print $featured_content['enable'] ? 'fc-hero--with-featured-content' : ''; ?>"  style="<?php print $style; ?>">
    <div class="fc-hero__main-content">    
	    <h1 class="fc-hero__headline"><?php print esc_html(get_field('headline')); ?></h1>
	    <div class="fc-hero__content"><?php print $hcontent; ?></div>
    </div>
    
    <?php if($button['enable']): ?>
      <div class="fc-hero__cta">
        <a class="fc-hero__button" href="<?php print esc_attr($button['link']); ?>"><?php print esc_html($button['text']); ?></a>
      </div>
    <?php endif; ?>
    
    <?php if($featured_content['enable']): ?>  
      <div class="fc-hero__detail">
          <div class="fc-hero__detail-inner">
              <?php foreach($featured_content['content'] as $content): ?>
  
                  <?php if($featured_content_image): ?>
                      <div class="fc-hero__feature fc-hero__feature--image">
                          <img class="fc-hero__feature-image" src="<?php print esc_attr($content['image']); ?>" alt="<?php print esc_attr($content['title']); ?>">
                      </div>
                  <?php endif; ?>
                  <div class="fc-hero__feature <?php print $featured_content_image ? 'fc-hero__feature--with-image' : ''; ?>">
                      <h3 class="fc-hero__feature-title"><?php print $content['title']; ?></h3>
                      <div class="fc-hero__feature-desc">
                        <?php print $content['description']; ?>
                      </div>
                  </div>
              <?php endforeach; ?>
          </div>
      </div>
    <?php endif; ?>
</section>
