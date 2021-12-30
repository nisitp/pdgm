<?php $addClass = get_sub_field('class'); ?>
<section class="fc-two-columns <?php print $addClass;?>">
    <div class="fc-two-columns__inner">
        <div class="fc-two-columns__left">
            <?php
                if(have_rows('left_flexible_content')) {
                    while(have_rows('left_flexible_content')) {
                        the_row();
                        get_template_part('flexible-content/block', get_row_layout());
                    }
                }
            ?>
        </div>
        <div class="fc-two-columns__right">
            <?php
                if(have_rows('right_flexible_content')) {
                    while(have_rows('right_flexible_content')) {
                        the_row();
                        get_template_part('flexible-content/block', get_row_layout());
                    }
                }
            ?>
        </div>
    </div>
</section>
