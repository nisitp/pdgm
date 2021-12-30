<?php
  if (!$npi = $_GET["npi"]) exit;
  // simple helper to abstract/obfuscate the API for now to mitigate risk of naughty people  doing naughty things.  
  
  // disable SSL checking stuff
  $arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
  );  

  // Real endpoint  
  $api = 'https://' . $_SERVER['HTTP_HOST'] . '/pdgmtool/api.php/records/wp_pdgmdata?filter=NPI,eq,' . $_GET["npi"];  
  
  // connect to it
  $response = file_get_contents($api, false, stream_context_create($arrContextOptions));
 
  $npi = $_GET["npi"];
  if ($_GET["function"] == "count") {
    // deserialize
    $res = json_decode($response);
    print count($res->records);
  } else {
    // otherwise just send it through.
    print $response;
  }
?>
