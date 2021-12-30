<?php
$testimonials = get_sub_field('select') == 'manual'
    ? [get_sub_field('testimonial')]
    : get_posts([
        'post_type' => 'eh_testimonial',
        'numberposts' => 1,
        'orderby' => get_sub_field('select') == 'random' ? 'rand' : 'date',
      ]);
if(sizeof($testimonials) > 0):
    $testimonial = $testimonials[0];
    $headshot = get_field('headshot', $testimonial);
    $headshot = $headshot
        ? " style=\"background-image: url('{$headshot['sizes']['medium']}\"')"
        : "";
?>
<section class="fc-testimonial-bubble">
    <div class="fc-testimonial-bubble__inner">
        <div class="fc-testimonial-bubble__testimonial">
            <p class="fc-testimonial-bubble__testimonial-content"><?php print get_field('testimonial', $testimonial); ?></p>
            <small class="fc-testimonial-bubble__testimonial-position"><?php print get_field('name', $testimonial); ?> <br><?php print get_field('position', $testimonial); ?>, <?php print get_field('company', $testimonial); ?></small>
        </div>
        <div class="fc-testimonial-bubble__headshot"<?php print $headshot; ?>></div>
    </div>
</section>
<?php
endif;
?>