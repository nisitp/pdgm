<section class="fc-tabbed-content">
    <div class="fc-tabbed-content__container">
        <div class="fc-tabbed-content__inner">
            <?php if(get_sub_field('headline')): ?><h2 class="fc-tabbed-content__title"><?php print get_sub_field('headline'); ?></h2><?php endif; ?>
            <?php if(get_sub_field('description')): ?><p class="fc-tabbed-content__desc"><?php print get_sub_field('description'); ?></p><?php endif; ?>
            <div class="fc-tabbed-content__tabs">
                <?php foreach(get_sub_field('tabs') as $i => $tab): ?>
                    <a class="fc-tabbed-content__tab<?php print $i == 0 ? " fc-tabbed-content__tab--active" : ""; ?>" href="#tab<?php print $i ?>">
                        <?php print $tab['title']; ?>
                        <i class="fa <?php print $i == 0 ? "fa-chevron-up" : "fa-chevron-down"; ?>" aria-hidden="true"></i>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="fc-tabbed-content__tab-content fc-tabbed-content__tab-content--arr0">
                <?php foreach(get_sub_field('tabs') as $i => $tab): ?>    
                    <div id="tab<?php print $i ?>" class="fc-tabbed-content__tab-content-inner<?php print $i == 0 ? " fc-tabbed-content__tab-content-inner--active" : ""; ?>">
                        <?php print $tab['content']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
