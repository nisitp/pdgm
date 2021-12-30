<section class="fc-numbers">
    <div class="fc-numbers__inner">
        <?php foreach(get_sub_field('numbers') as $number): ?>
            <div class="fc-numbers__number">
                <div class="fc-numbers__number-inner">
                    <span class="fa <?php print esc_attr($number['icon']); ?>"></span>
                    <h4><?php print esc_attr($number['number']); ?></h4>
                    <p><?php print esc_attr($number['description']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
