<?php
/*
* Plugin Name: VisitorTrack
* Plugin URI: http://netfactor.com/wp_visitortrack
* Description: Your best sales leads are visiting your website - anonymously.  Get details about companies and the people who work there without any web registration.
* Version: 1.6.5
* Author: netFactor
* Author URI: http://netfactor.com/wp_visitortrack
* License: GPLv2
*/

require 'vt_http_functions.php';
require 'vt_scripts_functions.php';
require 'vt_database.php';
require 'vt_hash.php';

// Add settings link on plugin page
function netfactor_vt_plugin_settings_link($links) {
	$settings_link = '<a href="options-general.php?page=visitortrack-tracking/vt_settings_page.php">Settings</a>';
	array_unshift($links, $settings_link);
	return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'netfactor_vt_plugin_settings_link' );

add_action('admin_menu','netfactor_vt_add_menu_and_initialize_optionspage');

function netfactor_vt_add_menu_and_initialize_optionspage(){
	add_options_page('VisitorTrack Settings','VisitorTrack','manage_options',__FILE__,'netfactor_vt_initialize_page');
	add_menu_page(
			__('VisitorTrack Settings','textdomain'),
			'VisitorTrack',
			'manage_options',
			'custompage',
			'netfactor_vt_initialize_page',
			'dashicons-search',
			100
	);
	wp_enqueue_script('jquery');
	netfactor_vt_queue_stylesheet();
}
function netfactor_vt_queue_stylesheet() {
	wp_enqueue_style( 'privateshortcodestyle', plugins_url( 'stylesheet.css', __FILE__ ) );
}

function netfactor_vt_initialize_page() {
	$optionURL = get_option( 'vt_URL' );
	$optionEmail = get_option( 'vt_email_address' );
	$optionSiteID = ''; //get_option( 'vt_SiteID' );

	$optionUserName = get_option( 'vt_username' );
	$optionPassword = get_option( 'vt_password' );
	$optionPassword = netfactor_vt_encrypt_decrypt('decrypt', $optionPassword);

	if($optionUserName != '' && $optionPassword != ''){
		$optionSiteID = netfactor_vt_validate_user($optionUserName, $optionPassword);
		$optionStatus = netfactor_vt_check_status($optionSiteID);
	} else{
		$optionStatus = netfactor_vt_check_status($optionSiteID);
	}



	$optionNetworkStatus = netfactor_vt_check_network_connectivity();
	$optionSubmitButton = netfactor_vt_check_submit_button($optionSiteID);
	netfactor_vt_save_settings_to_database($optionSiteID, $optionUserName, $optionPassword);
?>

<script type="text/javascript">			
jQuery(document).ready(function() {			
	var getSiteID = jQuery("#siteID").val();						
	if(jQuery.isNumeric(getSiteID) && getSiteID !== 0){
		netfactor_vt_PageSectionsDisplay(true);
	}else{
		netfactor_vt_PageSectionsDisplay(false);
	}
});

function netfactor_vt_PageSectionsDisplay(activated){		  						
	if(activated === true){						
		jQuery('#status').css('color','green');		
		jQuery('#NewUser').hide();
		jQuery('#Login').hide();
		
		jQuery('#DeactivatePlugin1').show();						
		jQuery('#DeactivatePlugin2').show();						
	} else{
		jQuery('#status').css('color','#c0392b');		
		jQuery('#NewUser').show();
		jQuery('#Login').show();
			
		jQuery('#DeactivatePlugin1').hide();						
		jQuery('#DeactivatePlugin2').hide();						
	}	
}
</script>


<div id="VisitorTrackPlugin" class="wrap renderBody">
    <form class="form-horizontal" method="post" action="admin-post.php" role="form">
        <input type="hidden" name="action" value="save_vt_options" />
        <?php wp_nonce_field( 'vt_setting_page' ); ?>

        <section id="Header">
            <div class="row" style="min-width: 615px; background-color: #ecf0f1; ">
                <div style="float: left;">
                    <img src="http://www.visitor-track.com/email/visitortrack_wp_plugin.png" />
                </div>
                <div style="margin-left: 20px; float: left; margin-top: 15px;">
                    <img src="http://www.visitor-track.com/email/visitortrack_wp_logo.png" />
                    <br />
                    <div style="font-size: 20pt; font-weight: bold; color: #2980b9; margin-top: 10px;">
                        Install VisitorTrack
                        <br />into your website with WordPress
                    </div>
                </div>
            </div>
        </section>
        <section id="NewUser" class="form-group group" style="display: none;">
            <div class="row">
                <div class="col-sm-2">
<a class="button-primary" href="https://app.visitor-track.com/Trial" target="_blank" style="width: 110px;">&nbsp;&nbsp;&nbsp;&nbsp;Start Trial</a>
                </div>
                <div class="col-sm-10">
                    <b>New User - Start a VisitorTrack Free Trial / Learn More</b>
                    <br />
                    You'll receive user name and password immediately by email.
                </div>
            </div>
        </section>
        <div class="spacer-5"></div>
        <section id="Login" class="form-group group" style="display: none;">
            <div class="row">
                <span class="col-sm-11 sub-header">Got a VisitorTrack Account?</span>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <input class="form-control" type="text" placeholder="User Name" name="userName" value="<?php echo esc_html( $optionUserName ); ?>" />
                </div>
            </div>
            <div class="spacer-10   rt-display" style=""></div>
            <div class="row">
                <div class="col-sm-5">
                    <input class="form-control" type="password" placeholder="Password" name="password" value="<?php echo esc_html( $optionPassword ); ?>" />
                </div>
            </div>
            <div class="spacer-10   rt-display" style=""></div>
            <div class="row">
                <div class="col-sm-2">
                    <input type="submit" style="width: 110px;" name="settingsSubmit"
                        value="<?php if($optionSubmitButton != 'Resubmit') echo esc_html( 'Start'); if($optionSubmitButton == 'Resubmit') echo esc_html( 'Resubmit'); ?>"
                        class="<?php if($optionSubmitButton != 'Resubmit') echo esc_html( 'button-green'); if($optionSubmitButton == 'Resubmit') echo esc_html( 'button-orange'); ?>" />
                    <br />
                </div>
                <div class="col-sm-10">
                    <?php
    if($optionSubmitButton != 'Resubmit') echo 'Insert the VisitorTrack tracking code into WordPress pages<br/>and start tracking visitors.';
    if($optionSubmitButton == 'Resubmit') echo 'We are unable to authorize the VisitorTrack account through<br/>WordPress.  Tracking is suspended until you resubmit.';
                    ?>

                </div>
            </div>
            <div id="status" style="margin-top: 10px; margin-left: 10px; color: #c0392b; font-size: .9em; display: <?php if($optionNetworkStatus == '') echo esc_html( "none" ); if($optionNetworkStatus != '') echo esc_html( "block" ); ?>">
                <?php echo esc_html( $optionStatus); ?>
            </div>
            <div id="statusNetwork" style="margin-top: 10px; color: #c0392b; display: <?php if($optionNetworkStatus == '') echo esc_html( "block" ); if($optionNetworkStatus != '') echo esc_html( "none" ); ?>">
                Internet connectivity to Visitor Track API is unavailable.  Check connectivity<?php echo esc_html( $optionNetworkStatus); ?>
            </div>
            <input type="hidden" id="siteID" name="siteID" value="<?php echo esc_html( $optionSiteID ); ?>" />
        </section>
        <div class="spacer-5"></div>
        <section class="form-group group" id="DeactivatePlugin1" style="display: none;">
            <div class="row" style="color: #27ae60; font-weight: bold; margin-left: 10px;">
                VisitorTrack is activated on your website and login has been validated.
            </div>
        </section>
        <div class="spacer-5"></div>
        <section class="form-group group" id="DeactivatePlugin2" style="display: none;">
            <div class="row">
                <div class="col-sm-2">
                    <input type="submit" name="settingsSubmit" value="Stop" class="button-red" style="width: 110px;" />
                    <br />
                </div>
                <div class="col-sm-10" style="margin-top: 7px;">
                    Remove the VisitorTrack tracking code from WordPress pages.
                </div>
            </div>
            <div class="spacer-20"></div>
            <div class="row">
                <div class="col-sm-12" style="font-size: .9em">
                    The Stop button will remove the VisitorTrack tracking code from your website pages.  Please contact
                    <br />
                    your netFactor representitive or
                    <a href="mailto: support@netfactor.com">support@netfactor.com</a>for any changes to your VisitorTrack service.
                </div>
            </div>
        </section>
    </form>
</div>


<?php

}

add_action( 'admin_init', 'netfactor_vt_admin_init' );
add_action('wp_footer','netfactor_vt_footer_script', 1000);

function netfactor_vt_admin_init() {
add_action( 'admin_post_save_vt_options','netfactor_vt_post_page');
}

function netfactor_vt_post_page() {
	netfactor_vt_check_security();

	if($_POST['settingsSubmit'] == 'Stop'){
		$optionUserName = '';
		$optionPassword = '';
		$optionSiteID = '';
	} else{
		$optionUserName = $_POST['userName'];
		$optionPassword = $_POST['password'];
	    $optionSiteID = netfactor_vt_validate_user($optionUserName, $optionPassword);
	}

	netfactor_vt_save_settings_to_database($optionSiteID, $optionUserName, $optionPassword);
    wp_redirect( add_query_arg('page', 'visitortrack-tracking/vt_settings_page',admin_url('options-general.php')));

	exit;
}

function netfactor_vt_validate_user($username, $password){

	$token = netfactor_vt_GetTokenWithUsernamePassword($username, $password);

    //echo reset($token);

	if($token != ''){
		if(strlen(reset($token)) > 20 ){
			$siteID = netfactor_vt_GetSiteIDByUserName($username, reset($token));
			return $siteID;
		}
		else{
			return "Username, password invalid.";
		}
	} else{
		return "Username, password invalid.";
	}
}

function netfactor_vt_check_network_connectivity(){
	$result;
	if(netfactor_vt_http_is_connected()){
		$result = true;
	} else{
		$result = false;
	}
	return $result;
}

function netfactor_vt_check_security(){
	if ( !current_user_can( 'manage_options' ) )		// Check that user has proper security level
	wp_die( 'Not allowed' );
	check_admin_referer( 'vt_setting_page' );			// Check that nonce field created in configuration form is present
}

function netfactor_vt_check_status($optionSiteID){
	$optionStatus = '';
	$pluginActivated = true;


	if(is_numeric($optionSiteID) && $optionSiteID != 0){
		$optionStatus = "VisitorTrack is activated on your website and login has been validated.";
		$pluginActivated = true;
	}
	else{
		$pluginActivated = false;
		if($optionSiteID == ""){
			$optionStatus = "The tracking code is not currently placed and/or login has not been validated until Start completes.";
		} elseif($optionSiteID === "Username, password invalid."){
			$optionStatus = "The login information has not been found.  Username and password are case sensitive.  Please try again or contact support@netfactor.com";
		} else{
			$optionStatus = $optionSiteID;
		}
	}

	return $optionStatus;
}

function netfactor_vt_check_submit_button($optionSiteID){
	$optionSubmitButton = '';
	if($optionSiteID === "Username, password invalid."){
		$optionDBSiteID = get_option( 'vt_SiteID' );
		if(is_numeric($optionDBSiteID) && $optionDBSiteID != 0){
			$optionSubmitButton = "Resubmit";
		} else{
			$optionSubmitButton = "Start";
		}
	}
	return $optionSubmitButton;
}
?>