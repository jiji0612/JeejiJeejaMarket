
<?php
	$url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

	$server = $url ["host"];
	$username = $url ["user"];
	$password = $url ["pass"];
	$db = substr ($url ["path"], 1);
	$link = mysqli_connect ($server, $username, $password, $db);
	$result = mysqli_query ($link,"select * from vi_member_order");

	while ($member = mysqli_fetch_array ($result)) {
	echo $member ['memberid'] . ":" . $member ['addr'] . "<br>";
	}
?>