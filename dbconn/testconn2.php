<?php
    echo "Starting";

	$server = "us-cdbr-east-03.cleardb.com";
	$username = "ba7f82c856e7b5";
	$password = "9090f5ee";
	//$db = "heroku_565ce00c19449b1";
	$link = mysqli_connect ($server, $username, $password);
	$result = mysqli_query ($link,"select * from vi_member_order");
	echo $result;

	while ($user = mysqli_fetch_array ($result)) {
	echo $user['memberid'] . ":" . $user['addr'] . "<br>" ;
	}
?>
