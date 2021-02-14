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

    $orderNo = date("YmdHis");
    $strSQL = "INSERT INTO confirm_order(orderno,memberid,item,qty,price,status,orderdate) ";
    $strSQL .= "SELECT '" . $orderNo . "',memberid,item,total_qty,total_price,'Order',NOW() FROM vi_member_order Where memberid = '". $uid ."';";

    $strSQL .= "DELETE FROM member_order Where memberid = '". $uid ."';";
    if (mysqli_multi_query($conn, $strSQL)) {
        echo "successfully (Ord : " . $orderNo . ")";
    } else {
        echo "Error:" . mysqli_error($conn);
    }
      
      mysqli_close($conn);
    } else {
      echo "None POST methods!";
    }
?>
