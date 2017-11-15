<?php

/** Rahber ashraf
www.rahber.net
	*/


	//edit only these variables
	
	$databaseAccount = "ratestdb";
	
	$today = gmdate('D, d M Y H:i:s T', strtotime('+2 minutes'));
	//$today = "wed, 15 nov 2017 12:05:49 gmt";
	$master = 'master';
	$token = '1.0';
	$apiVersion = '2017-02-22';

	$masterKey = "H7y2RRsBhTgIqTPxQYsx660vPBb2EXW7dOe6OPjCWyLkmSr1sCAwOfVN4JUzgS4YoiXugvlBfi1seVJEuw4KtQ==";
	$vrb= "POST";
	$rType ="";
	$rID = "";
	
	
	//Do not edit the below.
	
	$databaseAccountURL = "https://".$databaseAccount.".documents.azure.com:443/dbs/";
	$appType = 'application/json';
	$userAgent = 'ratest/1.0.0';
	$cacheControl = 'no-cache';
	$signature ="";
	$authToken = "";
	
	error_reporting(0);
	

?>
