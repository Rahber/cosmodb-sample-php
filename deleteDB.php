<?php

require_once "var.php";

function genetrateAuthToken($master,$token,$signature) {
	$authToken = "type=".$master."&ver=".$token."&sig=".$signature;
	return $authToken;
}

function getToken($masterKey,$vrb,$today,$dbName) {
	$vrb ="DELETE";
	$rType= "dbs";
	$rID = "dbs/".$dbName;
	$key = base64_decode($masterKey);
	$stringSign = $vrb."\n".$rType."\n".$rID."\n".$today."\n"."\n";
	$stringSign = strtolower($stringSign);
	$encrypt = hash_hmac('sha256', $stringSign, $key, true);
	$signature = base64_encode($encrypt);
	return urlencode($signature);
}

function curl_download($databaseAccountURL,$masterKey, $master, $vrb, $today, $token,  $appType, $apiVersion, $cacheControl, $userAgent , $dbName ){
	global $httpCode;
	if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    } 
	$authcode = genetrateAuthToken($master,$token,getToken($masterKey,$vrb,$today, $dbName));
	$ch = curl_init($databaseAccountURL);
	$header[] = 'Content-Length:' . strlen($dataString);
    $header[] = 'Accept: application/json';
    $header[] = 'Expect: 100-continue';
	$header[] = 'authorization:'.$authcode;
	$header[] = 'x-ms-version: ' . $apiVersion;
	$header[] = 'x-ms-date: ' . $today;
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);  
	curl_setopt($ch,CURLOPT_VERBOSE,true); 
    $options = array(
      CURLOPT_HTTPHEADER => $header,
    );
	curl_setopt_array($ch, $options);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $output;
}


if($_POST && $_POST['dbname']!=""){
	$dbName = $_POST["dbname"];
	$databaseAccountURLm = $databaseAccountURL.$dbName;
	$json = curl_download($databaseAccountURLm,$masterKey, $master, $vrb, $today, $token, $appType, $apiVersion, $cacheControl, $userAgent, $dbName);
	$jsonArray = json_decode($json, true);
}else{
	//do nothing
}
?>

<html>
 <head>
 	<title>COSMO DB php Sample</title>
 	<style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 		color: #333; font-size: .85em; margin: 20px; padding: 20px;
 		font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 
 	h1, h2, h3 { color: #000; margin-bottom: 0; padding-bottom: 0; }
 
 	h1 { font-size: 2em; }
 
 	h2 { font-size: 1.75em; }
 
 	h3 { font-size: 1.2em; }
 
 	table { margin-top: 0.75em;}
 
 	th { font-size: 1.2em; text-align: center; border: none 0px; padding-right: 15px; }
 
 	td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
 	</style>
 </head>
 <body>
 	<h1><a href="index.php">Cosmo DB PHP Sample</a></h1>
<div style="float:left">
	


 		<div style="margin-top:10px;">
			Delete a Database: 
			<form action="deleteDB.php" method="post">
				<input name="dbname" type="text"/>
				<input type="submit" value="Delete">
			</form>
			</submit>
		</div>
	
	
 	
	

<?php	

if($_POST){
	echo "<div>";
	if($httpCode!="204"){
		echo "<br /><h1>Status: ".$jsonArray['code']."</h1>";
		echo "<h2>".$jsonArray['message']."</h2>";
	}else if($httpCode == 204){
		echo "<h1>Status: Database Deleted</h1>";
	}
	echo "</div>";
}
?>
</div>
 </body>
 </html>