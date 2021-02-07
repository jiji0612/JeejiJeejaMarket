<?php
echo "Starting";
    $url = parse_url (getenv ("mysql://ba7f82c856e7b5:9090f5ee@us-cdbr-east-03.cleardb.com/heroku_565ce00c19449b1?reconnect=true"));

	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr ($url["path"], 1);
	$link = mysqli_connect ($server, $username, $password, $db);
	echo $server.$username.$password.$db;

	$result = mysqli_query ($link,"select * from vi_member_order");

	while ($user = mysqli_fetch_array ($result)) {
	echo $user['memberid'].":".$user['addr']."<br>" ;
	}
?>
