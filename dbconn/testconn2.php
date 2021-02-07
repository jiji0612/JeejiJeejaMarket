<?php

	$mysqli = new mysqli("127.0.0.1", "ba7f82c856e7b5", "9090f5ee", "heroku_565ce00c19449b1", 3306);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	echo $mysqli->host_info . "\n";
?>
