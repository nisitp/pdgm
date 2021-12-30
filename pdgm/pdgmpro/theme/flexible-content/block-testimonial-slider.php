<?php
$testimonials = get_sub_field('select') == 'manual'
    ? get_sub_field('testimonials')
    : get_posts([
        'post_type' => 'eh_testimonial',
        'numberposts' => get_sub_field('count'),
      ]);
?>
<section class="fc-testimonial-slider">
    <div class="fc-testimonial-slider__inner">
       <div class="fc-testimonial-slider__testimonials">
            <?php foreach($testimonials as $testimonial): ?>
                <div class="fc-testimonial-slider__testimonial">
                    <h2 class="fc-testimonial-slider__testimonial-name"><?php print get_field('company', $testimonial); ?> says:</h2>
                    <p class="fc-testimonial-slider__testimonial-content"><?php print get_field('testimonial', $testimonial); ?></p>
                    <small class="fc-testimonial-slider__testimonial-position"><?php print get_field('name', $testimonial).', '.get_field('position', $testimonial); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
