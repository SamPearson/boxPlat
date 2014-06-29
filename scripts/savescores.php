<?php


$db = "spearson_boxplat";//Your database name
$dbu = "spearson_boxplat";//Your database username
$dbp = "!QOnKBg=qqR+";//Your database users' password
$host = "localhost";//MySQL server - usually localhost

$dblink = mysql_connect($host,$dbu,$dbp);
$seldb = mysql_select_db($db);

if(isset($_GET['world']) && isset($_GET['level']) && isset($_GET['time']) && isset($_GET['name'])){
	//Lightly sanitize the GET's to prevent SQL injections and possible XSS attacks
	$world = strip_tags(mysql_real_escape_string($_GET['world']));
	$level = strip_tags(mysql_real_escape_string($_GET['level']));
	$time = strip_tags(mysql_real_escape_string($_GET['time']));
	$name = strip_tags(mysql_real_escape_string($_GET['name']));
	
	$numScores = mysql_query("SELECT * FROM `scores` WHERE world = $world AND level = $level ");
	$getLowest = mysql_query("SELECT max( timeInSeconds ) FROM `scores`");
	if(is_resource($getLowest) and mysql_num_rows($getLowest)>0){
		$row = mysql_fetch_array($getLowest);
		$scoreToBeat = $row[0];
	}

	if ($time < $scoreToBeat or $numScores < 5){
		$sql = mysql_query("INSERT INTO scores (id, world, level, timeInSeconds, name) VALUES ('', '$world', '$level', '$time', '$name');");
		$sql = mysql_query("DELETE FROM scores WHERE world = $world AND level = $level ORDER BY timeInSeconds DESC LIMIT 1");
	}	
	if($sql){
	
		//The query returned true - now do whatever you like here.
		echo 'Your score was saved. Congrats!';
		
	}else{
	
		//The query returned false - you might want to put some sort of error reporting here. Even logging the error to a text file is fine.
		if (! $time < $scoreToBeat){
			echo "Your score wasn't high enough to save.";
		} else {
		echo 'There was a problem saving your score. Please try again later.';
		}
	}
	
}else{
	echo 'missing params';
}

mysql_close($dblink);//Close off the MySQL connection to save resources.
?>
