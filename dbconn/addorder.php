<html>
<head>
<title>Add order</title>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
</head>
<body>

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
	
	/*** Update Member ***/
    $strSQL = "INSERT INTO member (memberid,membername) ";
    $strSQL .= "SELECT '".$uid."','".$user_name."' FROM DUAL WHERE NOT EXISTS (SELECT memberid FROM member WHERE memberid = '".$uid."') ";
    if (mysqli_query($conn, $strSQL)) {
        //Update Last Order
        $strSQL = "UPDATE member set remark = '".$ordersubmit."' WHERE memberid = '".$uid."'";
        mysqli_query($conn, $strSQL);

        //Add new Order
        print "successfully";
    } else {
        print "Error:" . mysqli_error($conn);
    }
    

    mysqli_close($conn);
 
  }
} else {
    print "None POST methods!";
}
?>

</body>
</html> 