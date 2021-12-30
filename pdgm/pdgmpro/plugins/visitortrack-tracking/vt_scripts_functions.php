<?php

function netfactor_vt_footer_script() {	
	$siteID = get_option( 'vt_SiteID' );		
	if($siteID != "" && $siteID > 0 && $siteID != null){
?>	
		<script type="text/javascript">

            (function () {
                            vtid = <?php $siteID = get_option( 'vt_SiteID' ); print_r($siteID) ?>; var a = document.createElement('script'); a.async = true;
                a.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'code.visitor-track.com/VisitorTrack2.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(a, s);
            })();
				</script>	
				<?php 		
	} 
}

?>