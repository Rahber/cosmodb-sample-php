<?php

require_once "var.php";



function genetrateAuthToken($master,$token,$signature) {
	$authToken = "type=".$master."&ver=".$token."&sig=".$signature;
	return $authToken;
}


function getToken($masterKey,$vrb,$today) {
	
	$rType= "dbs";
	$rID = "/dbs";
    $key = base64_decode($masterKey);
		$stringSign = $vrb . "\n" .
		$rType . "\n" .
		$rID . "\n" .
		$today . "\n" .
		"\n";
    $signature = base64_encode(hash_hmac('sha256', strtolower($stringSign), $key, true));

    return $signature;
}

function getAuthHeaders($appType,$userAgent,$cacheControl,$today,$apiVersion,$authToken) {
	 return Array(
             'Accept: ' . $appType,
             'User-Agent: ' . $userAgent,
             'Cache-Control: ' . $cacheControl,
             'x-ms-date: ' . $today,
             'x-ms-version: ' . $apiVersion,
             'authorization: ' . urlencode($authToken)
           );
}

function curl_download($databaseAccountURL,$masterKey, $master, $vrb, $today, $token,  $appType, $apiVersion, $cacheControl, $userAgent ){
 
    // is cURL installed yet?
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
	
	$data = array("id" => "ratestid");                                                                    
	$dataString = json_encode($data);   

	
	
	
  genetrateAuthToken($master,$token,getToken($masterKey,$vrb,$today));
 
	$headers = getAuthHeaders($appType,$userAgent,$cacheControl,$today,$apiVersion,genetrateAuthToken($master,$token,getToken($masterKey,$vrb,$today)));
  $ch = curl_init($databaseAccountURL);

	$header[] = 'Content-Length:' . strlen($dataString);
    $header[] = 'Accept: application/json';
    $header[] = 'Expect: 100-continue';
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);  
	curl_setopt($ch,CURLOPT_VERBOSE,true); 
    $options = array(
      CURLOPT_HTTPHEADER => $header,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $dataString
    );

	curl_setopt_array($ch, $options);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    curl_close($ch);
 
    return $output;
}



echo $json = curl_download($databaseAccountURL,$masterKey, $master, $vrb, $today, $token, $appType, $apiVersion, $cacheControl, $userAgent);

?>