<html>
<head>
<title>Order Management</title>
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
	mysqli_set_charset($conn, "utf8");
	
    $status = $_GET['status'];

	/***  Add Record ***/
	if($_GET["Action"]=="Save")
	{
		$strSQL = "INSERT INTO member (memberid,addr) VALUES ('".$_POST["txtMember"]."','".$_POST["txtAddr"]."')";
        if (mysqli_query($conn, $strSQL)) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
          }
	}

    $objQuery = mysqli_query ($conn,"select * from vi_confirm_order where status = '".$status."' order by orderno,memberid asc");
?>
	<table width="100%" border="1">
	<tr>
    <th width="244"> <div align="center">Order No </div></th>
	<th width="87"> <div align="center">Member </div></th>
	<th width="145"> <div align="center">Address </div></th>
    <th width="244"> <div align="center">Items </div></th>
    <th width="244"> <div align="center">Quantity </div></th>
    <th width="244"> <div align="center">Price </div></th>
	</tr>
	<?php
	while($objResult = mysqli_fetch_array($objQuery))
	{
	?>
		<tr>
		<td><?php echo $objResult["orderno"];?></td>
		<td><?php echo $objResult["membername"];?></td>
        <td><?php echo $objResult["addr"];?></td>
        <td><?php echo $objResult["item"];?></td>
        <td><?php echo $objResult["total_qty"];?></td>
        <td><?php echo $objResult["total_price"];?></td>
		</tr>
	<?php
	}
	?>		
	<form name="frmMain" method="post" action="?Action=Save">
		<tr>
		  <td><input name="txtMember" type="text" id="txtMember"></td>
		  <td><input name="txtAddr" type="text" id="txtAddr">
          <td><input name="btnSubmit" type="submit" id="btnSubmit" value="Submit"></td>
	      <td></td>
          <td></td>
          <td></td>
		  <td></td>
	  </tr>
</form>	  

</table>
<?php
	mysqli_close($conn);
?>
</body>
</html> 