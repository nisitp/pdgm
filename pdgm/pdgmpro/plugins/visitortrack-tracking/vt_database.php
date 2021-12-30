<?php


function netfactor_vt_save_settings_to_database($siteID, $userName, $password){
	update_option('vt_SiteID',$siteID);	
	update_option('vt_username',$userName);	
	
	$password = netfactor_vt_encrypt_decrypt('encrypt', $password);
	update_option('vt_password', $password);			
		
}

function netfactor_vt_delete_all_database_columns(){
	delete_option('vt_URL');		
	delete_option('vt_email_address');		
	delete_option('vt_SiteID');		
	delete_option('vt_username');		
	delete_option('vt_password');			
}

function netfactor_vt_clean_all_database_settings(){
	update_option('vt_URL','');		
	update_option('vt_email_address','');		
	update_option('vt_SiteID','');		
	update_option('vt_username','');		
	update_option('vt_password','');			
}