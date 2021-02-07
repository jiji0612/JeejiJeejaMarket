<html>
<head>
<title>PHP Test MySql Connection</title>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
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
	mysqli_query("SET NAMES TIS620");
	
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

    $objQuery = mysqli_query ($conn,"select * from vi_member_order");
?>
	<table width="498" border="1">
	<tr>
	<th width="87"> <div align="center">MemberID </div></th>
	<th width="145"> <div align="center">Address </div></th>
	<th width="244"> <div align="center">Order No </div></th>
    <th width="244"> <div align="center">Items Name </div></th>
    <th width="244"> <div align="center">Quantity </div></th>
    <th width="244"> <div align="center">Price </div></th>
	<th width="244"> <div align="center">Remark </div></th>
	</tr>
	<?php
	while($objResult = mysqli_fetch_array($objQuery))
	{
		//$utf8 = iconv("tis-620", "utf-8", $objResult["remark"] );
	?>
		<tr>
		<td><div align="center"><?php echo $objResult["memberid"];?></div></td>
		<td><?php echo $objResult["addr"];?></td>
		<td><?php echo $objResult["orderno"];?></td>
        <td><?php echo $objResult["item"];?></td>
        <td><?php echo $objResult["total_qty"];?></td>
        <td><?php echo $objResult["total_price"];?></td>
		<td>
			<?php 
				$tis620 = iconv("utf-8", "tis-620", $objResult["remark"] );
				$utf8 = iconv("tis-620", "utf-8", $tis620);
				echo iconv("tis-620", "utf-8",  $utf8 );
			?>
		</td>
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