<html>
<head>
<title>Member Profile</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>

<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 150%;
}

input[type=submit] {
  width: 100%;
  height: 300px;
  background-color: #4CAF50;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 150%;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>

<body>
<div align='center'><H1>แก้ไขข้อมูลส่วนตัว</H1></div>
<div align='center'><H2>ถ้าไม่พบข้อมูล ลองกลับไปเลือกสินค้าลงตะกร้าก่อนค่ะ</H2></div>

<?php	
	session_start();

	/*** Connect ***/
	$url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

	$server = $url ["host"];
	$username = $url ["user"];
	$password = $url ["pass"];
	$db = substr ($url ["path"], 1);
	$conn = mysqli_connect ($server, $username, $password, $db);
	mysqli_query("SET NAMES UTF8");
	
	$uid  = "dummy";
	if(isset($_GET["uid"]))
	{
    	$uid = $_GET['uid'];
		$_SESSION['uid'] = $uid;
	}

	/***  Add Record ***/
	if($_GET["Action"]=="Save")
	{
		//Update address to member
		$strSQL = "DELETE FROM member WHERE memberid = '".$uid."';";
		$strSQL .= "INSERT INTO member (memberid,membername,addr) VALUES ('".$_SESSION['uid']."','".$_POST["txtname"]."','".$_POST["txtaddr"]."');";
    	if (mysqli_multi_query($conn, $strSQL)) {
            echo "sucessfully";
          } else {
            echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
          }
	}
	
	//Get Address of member
    $objQuery = mysqli_query($conn, "Select * From member Where memberid = '". $_SESSION['uid'] ."'");
	while($objResult = mysqli_fetch_array($objQuery))
	{
	echo '<div>
		<table width="100%" border="1">
		<form name="frmMain" method="post" action="?Action=Save">
		<tr>
			<td width="30%"><div align="center"><H1>ชื่อสมาชิก</H1></div></td>
			<td width="70%"><H1><input name="txtname" type="text" id="txtname" value="' . $objResult["membername"] . '><H1></td>
		</tr>
		<tr> 
			<td width="30%"><div align"center"><H1>ที่อยู่จัดส่ง</H1></div></td>
			<td width="70%"><H1><input name="txtaddr" type="text" id="txtaddr" value="' . $objResult["addr"] . '><H1></td>
		</tr>
		<input name="btnSubmit" type="submit" id="btnSubmit" value="บันทึก">
		</form>	
		</table>
	</div>';
	}
	
	
	mysqli_close($conn);
	?>
</body>
</html> 
