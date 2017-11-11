<?php
/** Rahber ashraf
www.rahber.net
	*/
	
include_once 'var.php';

// Assumes database already exists.
$conn = connect();

$sql = "CREATE TABLE items(
			id INT NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(id),
			name VARCHAR(30),
			category VARCHAR(30),
			date DATE,
			is_complete  BOOL)";

try{
	$conn->query($sql);
}
catch(Exception $e){
	print_r($e);
}

echo "<h3>Table created.</h3>";
?>