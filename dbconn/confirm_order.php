<html>
<head>
<title>Order Management</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>

<style>
input[type=submit] {
  width: 100%;
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

</style>

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
	
    if($_GET["Action"]=="Save")
	{
		$strSQL = "INSERT INTO member (memberid,addr) VALUES ('".$_POST["txtMember"]."','".$_POST["txtAddr"]."')";
        if (mysqli_query($conn, $strSQL)) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
          }
	}

    $objQueryHD = mysqli_query ($conn,"select Distinct memberid,membername,addr from vi_confirm_order where status in ('Order','Prepare') order by membername asc");
    while($objResultHD = mysqli_fetch_array($objQueryHD))
	{
        $memberid = $objResultHD["memberid"];
        $membername = $objResultHD["membername"];
        echo "<H1>ชื่อสมาชิก : " . $membername . "</H1>";
        echo "<H2>ที่อยู่จัดส่ง : " . $objResultHD["addr"] . "</H2>";
        echo "<H3>สถานะ : " . $objResultHD["status"] . "</H3>";

        $objQueryLN = mysqli_query ($conn,"select * from vi_confirm_order where memberid = '".$objResultHD["memberid"]."' and status = 'Order' order by orderno asc");
        ?>
        <table width="100%" border="1">
            <tr>
            <th width="244"> <div align="center">Order No </div></th>
            <th width="244"> <div align="center">Items </div></th>
            <th width="244"> <div align="center">Quantity </div></th>
            <th width="244"> <div align="center">Price </div></th>
            </tr>
        <?php
        while($objResult = mysqli_fetch_array($objQueryLN))
        {
        ?>
            <tr>
            <td><?php echo $objResult["orderno"];?></td>
            <td><?php echo $objResult["item"];?></td>
            <td><?php echo $objResult["total_qty"];?></td>
            <td><?php echo $objResult["total_price"];?></td>
            </tr>
        <?php
        }
        ?>	
        </table>

        <table width="100%">
        <tr>
            <td>
                <form name="frmMainCancel" method="post" action="?Action=Save&memberid=<?php echo $memberid;?>&status=Cancel">
                    <input name="btnSubmitCancel" type="submit" id="btnSubmitCancel" value="ยกเลิก">
                </form>	
            </td>
            <td>
                <form name="frmMainPrepare" method="post" action="?Action=Save&memberid=<?php echo $memberid;?>&status=Prepare">
                    <input name="btnSubmitPrepare" type="submit" id="btnSubmitPrepare" value="จัดเตรียมสินค้า">
                </form>	
            </td>
            <td>
                <form name="frmMainFinished" method="post" action="?Action=Save&memberid=<?php echo $memberid;?>&status=Finished">
                    <input name="btnSubmitFinished" type="submit" id="btnSubmitFinished" value="ส่งสินค้าเรียบร้อย">
                </form>	
            </td>
        </tr>
        </table>

    <?php
    }
	?>		


<?php
	mysqli_close($conn);
?>
</body>
</html> 