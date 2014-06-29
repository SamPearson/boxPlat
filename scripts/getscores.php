<?php
header('Access-Control-Allow-Origin: *');


$host="localhost"; // Host name 
$username="spearson_boxplat"; // Mysql username 
$password="!QOnKBg=qqR+"; // Mysql password 
$db_name="spearson_boxplat"; // Database name 
$tbl_name="scores"; // Table name

if(isset($_GET['world']) && isset($_GET['level'])){

	// Connect to server and select database.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");

	//Lightly sanitize the GET's to prevent SQL injections and possible XSS attacks
	$world = strip_tags(mysql_real_escape_string($_GET['world']));
	$level = strip_tags(mysql_real_escape_string($_GET['level']));

	// Retrieve data from database 
	$sql="SELECT * FROM scores WHERE level = $level AND world = $world ORDER BY timeInSeconds ASC LIMIT 10";
	$result=mysql_query($sql);

	// Start looping rows in mysql database.
	while($rows=mysql_fetch_array($result)){
	echo $rows['name'] . "|" . $rows['timeInSeconds'] . "|";
	// close while loop 
	}

	// close MySQL connection 
	mysql_close();
}

?>