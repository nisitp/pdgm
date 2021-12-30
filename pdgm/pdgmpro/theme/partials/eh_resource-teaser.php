<?php
      if (has_post_thumbnail( $post->ID )) {
        $img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0];
      }

        $type = wp_get_post_terms($post->ID, 'eh_resource_type');
        $type = sizeof($type) > 0 ? $type[0]->name : "Press Release";

        $text = get_field('resource_text', $post->ID);
        if($excerpt = get_field('excerpt', $post->ID))
            $text = $excerpt;

        $linkType = get_field('resource_display_type', $post->ID);
        $linkClass = "";
        $link = get_permalink($post->ID);
        if($linkType == 'iframe') {
          $link = get_permalink($post->ID);                      
//                        $linkClass = "fancybox";
//                        $link = "#modal_".$post->ID;
        } else if ($linkType == 'file') {
            $link = get_field('resource_file', $post->ID);
        } else if ($linkType == 'link') {
            $link = get_field('resource_link', $post->ID);
        }
        if (!$link_text = get_field('resource_link_text', $post->ID)) $link_text = "Read it Now";                    
    ?>
        <div class="resource resource-teaser resource-post">
            <span class="resource-type"><?php print $type; ?></span>
            
            <?php if (!$img) $img = esc_attr(get_field('resource_image', $post->ID));
                if ($img) {
                  $imgstyle = "style='background-image: url($img);'";
                  $imgclass="";
                } else {
                  $imgstyle = "";
                  $imgclass = "no-default"; 
                }
                ?>
                <div <?php print $imgstyle;?> class="resource-image-placeholder <?php print $imgclass;?>"> <a class="<?php print esc_attr($linkClass); ?>" href="<?php print esc_attr($link); ?>"></a></div>
              
            
            <h3 class="resource-title"><a class="<?php print esc_attr($linkClass); ?>" href="<?php print esc_attr($link); ?>"><?php print $post->post_title; ?></a></h3>
            <div class="resource-excerpt">
                <?php print $text; ?>
                <a class="<?php print esc_attr($linkClass); ?>" href="<?php print esc_attr($link); ?>"><?php print $link_text; ?></a>
            </div>
            <?php if($linkType == 'iframe' && 0): ?>
                <div style="display:none">
                    <div id="modal_<?php print $post->ID; ?>" class="iframe-modal">
                        <h3><?php print $post->post_title; ?></h3>
                        <p>Fill out the form below to download the pdf.</p>
                        <?php echo get_field('resource_iframe', $post->ID); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
