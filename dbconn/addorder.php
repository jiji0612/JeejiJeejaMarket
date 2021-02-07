<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $uid = $_POST['uid'];
    $user_name = $_POST['uname'];
    $ordersubmit = $_POST['ordersubmit'];
    if (empty($ordersubmit)) {
        echo "Order submit is empty";
    } else {
    //Add order

    $url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

	$server = $url ["host"];
	$username = $url ["user"];
	$password = $url ["pass"];
	$db = substr ($url ["path"], 1);
	$conn = mysqli_connect ($server, $username, $password, $db);
	mysqli_query("SET NAMES TIS620");
	
	/***  Add Record ***/
    $strSQL = "INSERT INTO member (memberid,membername,remark) VALUES ('".$uid."','".$user_name."','".$ordersubmit."') WHERE NOT EXISTS (SELECT 1 FROM member WHERE memberid = '".$uid."')";
    if (mysqli_query($conn, $strSQL)) {
        echo $strSQL;
    } else {
        echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

  }
} else {
    echo "None POST methods!";
}
?>