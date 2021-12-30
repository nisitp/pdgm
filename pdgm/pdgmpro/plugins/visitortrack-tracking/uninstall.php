<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();
		
//netfactor_vt_delete_all_database_columns();
delete_option('vt_URL');		
delete_option('vt_email_address');		
delete_option('vt_SiteID');		
delete_option('vt_username');		
delete_option('vt_password');
	
?>