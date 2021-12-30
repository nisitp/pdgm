<?php

function netfactor_vt_encrypt_decrypt($action, $string) {
	$output = false;

	if( $action == 'encrypt' ) {		
		$output = base64_encode($string);
	}
	else if( $action == 'decrypt' ){		
		$output = base64_decode($string);
	}

	return $output;
}