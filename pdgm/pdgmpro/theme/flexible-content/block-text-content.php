<?php $addClass = " " . get_sub_field('class'); ?>
<section class="fc-text-content fc-text-content--<?php print get_sub_field('background_color') . $addClass; ?>">
    <div class="fc-text-content__container">
        <div class="fc-text-content__inner">
            <?php if(get_sub_field('headline')): ?>
                <h2 class="fc-text-content__title"><?php print get_sub_field('headline'); ?></h2>
            <?php endif; ?>
            <?php if(get_sub_field('content')): ?>
                <div class="fc-text-content__content" style="column-count: <?php print esc_attr(get_sub_field('columns')); ?>">
                    <?php print get_sub_field('content'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
