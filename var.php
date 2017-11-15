<?php

/** Rahber ashraf
	*/


	//edit only these variables
	
	$databaseAccount = ""; //please enter your databasename account name
	$masterKey = ""; //please enter your primary key
	
	
	//$today ="wed, 15 nov 2017 15:05:18 gmt";
	$today = gmdate('D, d M Y H:i:s T', strtotime('+2 minutes'));
	$master = 'master';
	$token = '1.0';
	$apiVersion = '2017-02-22';
	$vrb= "POST";
	$rType ="";
	$rID = "";
	$httpCode ="";
	
	
	//Do not edit the below.
	
	$databaseAccountURL = "https://".$databaseAccount.".documents.azure.com:443/dbs/";
	$appType = 'application/json';
	$userAgent = 'ratest/1.0.0';
	$cacheControl = 'no-cache';
	$signature ="";
	$authToken = "";
	
	error_reporting(0);
	

?>
