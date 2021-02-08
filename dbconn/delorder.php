<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];

    $url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

	$server = $url ["host"];
	$username = $url ["user"];
	$password = $url ["pass"];
	$db = substr ($url ["path"], 1);
	$conn = mysqli_connect ($server, $username, $password, $db);
	mysqli_query("SET NAMES UTF8");

	/*** Update Member ***/
    $strSQL = "DELETE FROM member_order WHERE memberid = '".$uid."'";
    if (mysqli_query($conn, $strSQL)) {
        echo "successfully";
    } else {
        echo "Error:" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
  } else {
    echo "None POST methods!";
  }
?>
