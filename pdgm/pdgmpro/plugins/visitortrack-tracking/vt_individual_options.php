<?php

register_activation_hook(__FILE__,'netfactor_vt_set_default_options');

function netfactor_vt_set_default_options() {
	if ( get_option( 'vt_URL' ) === false ) {
		add_option( 'vt_URL', "" );
	}
	if ( get_option( 'vt_email_address' ) === false ) {		
		add_option( 'vt_email_address', '' );
	} 	
}

?>