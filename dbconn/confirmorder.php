<html>
<head>
<title>Order Confirm</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>
<body>
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
		$strSQL = "Update member Set addr = '".$_POST["txtaddr"]."' Where memberid = '". $_SESSION['uid'] ."'";
        if (mysqli_query($conn, $strSQL)) {
            echo $_POST["txtaddr"] . "   " . $_SESSION['uid'] ;
          } else {
            echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
          }
	}

	//Get Address of member
    $objQuery = mysqli_query($conn, "Select addr From member Where memberid = '". $_SESSION['uid'] ."'");
	while($objResult = mysqli_fetch_array($objQuery))
	{?>

	<table width="100%" border="1">
	<tr>
		<th width="100%"><div align='center '><H1>ที่อยู่จัดส่ง</H1></div></th>
	</tr>
	<form name="frmMain" method="post" action="?Action=Save">
		<tr>
			<td width="100%"><input name="txtaddr" type="text" id="txtaddr"></td>
			<td width="100%"><input name="btnSubmit" type="submit" id="btnSubmit" value="ยืนยัน"></td>
		</tr>
	</form>	 
	</table>
	 
	<?php
	}
		mysqli_close($conn);
	?>
</body>
</html> 