<?php
	/* Hot Sauce add to generate the topbar code */	
	function get_alert() {

    global $post;
  	
  	$args = array(
  		'post_type'  => 'custom_alert',
      'numberposts' => 1,
      'orderby' => 'post_date',
      'order' => 'DESC',
      'post_status' => 'publish'
    );
    
    $alerts = get_posts( $args );

    foreach ( $alerts as $post ) : setup_postdata( $post ); ?>
      
      <?php 
        $style = '';
        if ($bgcol = get_field('background_color')) $style .= "background-color: $bgcol;";
        if ($bgimg = get_field('background_image')) $style .= "background-image: url($bgimg);";
        
        global $wp;
        $here = home_url( $wp->request );
        $last = substr($here, -1);
        if ($last != "/") $here .= "/";
        
        $exclude = get_field('exclude_from_pages');
        if (in_array($here, get_field('exclude_from_pages'))) return;
        
      ?>  
    	<div class="topbar__alert"<?php if($style):?> style='<?php print $style; ?>'<?php endif; ?> id="topbar-<?php print get_field('alert_id');?>">
      	 <span class="topbar__alert__close"></span>
      	 <div class="topbar__alert__inner">
           <?php print get_field('content'); ?>
      	 </div>
      </div>

        
    	</div>
    <?php endforeach; 
    wp_reset_postdata();?>    

<?php 
	}
?>