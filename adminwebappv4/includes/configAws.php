<?php
/*
if (!defined('PDO::ATTR_DRIVER_NAME')) {
echo 'PDO unavailable';
}
else{
echo 'PDO Available';	
}
*/
$dbhost = "database-intro.cmqkfcvyht0y.eu-west-1.rds.amazonaws.com";
$dbuser = "admin";
$dbpass = "J1mb2gl3n!";
$dbname = "introDB";

$mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";

try{
	$pdo = new PDO($mysql_conn_string, $dbuser, $dbpass); 

	$pdo->setAttribute( PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex) {
	echo 'Failed';
	echo($ex->getMessage());
}
?>