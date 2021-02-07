<html>
<head>
<title>PHP Test MySql Connection</title>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
</head>
<body>
<?php	
	/*** Connect ***/
	$objConnect = mysql_connect("sql12.freemysqlhosting.net","sql12391241","irdEMCJaFj") or die("Error Connect to Database");
	$objDB = mysql_select_db("sql12391241");
	mysql_query("SET NAMES TIS620");
	/*
	// Or //
	mysql_query("SET character_set_results=tis620");
	mysql_query("SET character_set_client=tis620");
	mysql_query("SET character_set_connection=tis620");
	*/

	/***  Add Record ***/
	if($_GET["Action"]=="Save")
	{
		$strSQL = "INSERT INTO member (memberid,addr) VALUES ('".$_POST["txtMember"]."','".$_POST["txtAddr"]."')";
		mysql_query($strSQL);
	}
	
	/*** List Record ***/
	$strSQL = "SELECT * FROM vi_member_order";
	$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
?>
	<table width="498" border="1">
	<tr>
	<th width="87"> <div align="center">MemberID </div></th>
	<th width="145"> <div align="center">Address </div></th>
	<th width="244"> <div align="center">Order No </div></th>
    <th width="244"> <div align="center">Items Name </div></th>
    <th width="244"> <div align="center">Quantity </div></th>
    <th width="244"> <div align="center">Price </div></th>
	</tr>
	<?php
	while($objResult = mysql_fetch_array($objQuery))
	{
	?>
		<tr>
		<td><div align="center"><?php echo $objResult["memberid"];?></div></td>
		<td><?php echo $objResult["addr"];?></td>
		<td><?php echo $objResult["orderno"];?></td>
        <td><?php echo $objResult["item"];?></td>
        <td><?php echo $objResult["total_qty"];?></td>
        <td><?php echo $objResult["total_price"];?></td>
		</tr>
	<?php
	}
	?>		
	<form name="frmMain" method="post" action="?Action=Save">
		<tr>
		  <td>
	      </td>
		  <td><input name="txtMember" type="text" id="txtMember"></td>
		  <td><input name="txtAddr" type="text" id="txtAddr">
	      <input name="btnSubmit" type="submit" id="btnSubmit" value="Submit"></td>
	  </tr>
</form>	  

</table>
	<?php
	mysql_close($objConnect);
	?>
</body>
</html> 