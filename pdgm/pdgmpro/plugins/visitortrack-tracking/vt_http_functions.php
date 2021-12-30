<?php

function netfactor_vt_GetVisitorTrackSiteID($url, $emailAddress){
	$curl_handle=curl_init();
	$request_url = "https://app.visitor-track.com/Services/api/User/createtrialReturnSiteID";
	$curl_handle=curl_init($request_url);
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_handle, CURLOPT_URL, $request_url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_handle, CURLINFO_HEADER_OUT, true);

	$data = array("username" => $url, "email" => $emailAddress, "selfserve" => true);
	$data_string = json_encode($data);
	curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$data = curl_exec($curl_handle);
	$data2 = json_decode($data,true);
	curl_close($curl_handle);
	return $data2;
}

function netfactor_vt_GetSiteIDByUserName($username, $token){

	$curl_handle=curl_init();
	$request_url = "https://app.visitor-track.com/Services/api/User/GetUserSiteIDByUsername?username=" . urlencode($username);
	$curl_handle=curl_init($request_url);
	$headers[] = "Authorization: bearer " . $token;
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_handle, CURLOPT_URL, $request_url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl_handle, CURLINFO_HEADER_OUT, true);
	curl_setopt($curl_handle, CURLOPT_HTTPGET, true);

	$data = curl_exec($curl_handle);
	$data2 = json_decode($data,true);
	curl_close($curl_handle);
	return $data2;
}

function netfactor_vt_GetTokenWithUsernamePassword($username, $password){
	$curl_handle=curl_init();
	$request_url = "https://app.visitor-track.com/Services/Token";
	$curl_handle=curl_init($request_url);
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_handle, CURLOPT_URL, $request_url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_handle, CURLINFO_HEADER_OUT, true);
	$data = 'grant_type=password&username=' . urlencode($username) . '&password=' . urlencode($password);
	curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
	$data = curl_exec($curl_handle);
	$data2 = json_decode($data,true);
	curl_close($curl_handle);
	return $data2;
}

function netfactor_vt_http_is_connected()
{
	$connected = @fsockopen("www.yahoo.com", 80);  //port 80
	if ($connected){
		$is_conn = true;
		fclose($connected);
	}else{
		$is_conn = false;
	}
	return $is_conn;
}

?>