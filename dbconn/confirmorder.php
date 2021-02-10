<html>
<head>
<title>Order Confirm</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>
<body>
<?php	
	/*** Connect ***/
	$url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

	$server = $url ["host"];
	$username = $url ["user"];
	$password = $url ["pass"];
	$db = substr ($url ["path"], 1);
	$conn = mysqli_connect ($server, $username, $password, $db);
	mysqli_query("SET NAMES UTF8");
	
	$uid  = "";
	if(isset($_GET["uid"]))
	{
    	$uid = $_GET['uid'];
	}

	/***  Add Record ***/
	if($_GET["Action"]=="Save")
	{
		//Update address to member
		$strSQL = "Update member Set addr = '".$_POST["txtAddr"]."' Where memberid = '".$uid."'";
        if (mysqli_query($conn, $strSQL)) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
          }
	}

	//Get Address of member
    $objQuery = mysqli_query($conn, "Select addr From member Where memberid = '".$uid."'");
	while($objResult = mysqli_fetch_array($objQuery))
	{?>

	<form name="frmMain" method="post" action="?Action=Save&uid="<?php $_GET['uid'];?>>
		<div align='center '><H1>ที่อยู่จัดส่ง</H1></div>";
		<input name="txtaddr" type="text" id="txtaddr" value="<?php $objResult["addr"];?>">
		<div align="right"><input name="btnSubmit" type="submit" id="btnSubmit" value="ยืนยัน"></div>
	</form>	  

	<?php
	}
		mysqli_close($conn);
	?>
</body>
</html> 