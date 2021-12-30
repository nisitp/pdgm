<?php
$vertical = get_sub_field('layout') == 'vertical';
?>
<section class="fc-icon-list fc-icon-list--<?php print get_sub_field('background_color'); ?>">
    <div class="fc-icon-list__container">
        <div class="fc-icon-list__inner">
            <h2 class="fc-icon-list__title"><?php print get_sub_field('headline'); ?></h2>
            <p class="fc-icon-list__desc"><?php print get_sub_field('description'); ?></p>
            <div class="fc-icon-list__solutions">
                <?php foreach(get_sub_field('items') as $icon):
                        $icon['link'] = flexible_content_helper_link($icon['link']); ?>
                    <<?php echo $icon['link'] ? 'a' : 'div'; ?> class="fc-icon-list__solution fc-icon-list__solution--<?php print $icon['icon_color']; ?><?php print $vertical ? " fc-icon-list__solution--vertical" : ""; ?>"<?php print $icon['link'] ? ' href="'.esc_attr($icon['link']).'"' : ''; ?>>
                        <?php if($icon['icon']): ?><div class="fc-icon-list__solution-icon fc-icon-list__solution-icon--<?php print $icon['icon_color']; ?>"><span class="fa <?php print esc_attr($icon['icon']); ?>"></span></div><?php endif; ?>
                        <h3 class="fc-icon-list__solution-desc"><?php print $icon['title']; ?></h3>
                        <?php if($icon['description']) print "<div class='fc-icon-list__solution--detail'>".$icon['description'] . '</div>'; ?>
                        </p>
                    </<?php echo $icon['link'] ? 'a' : 'div'; ?>>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
