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

input[type=button] {
  width: 100%;
  background-color: #4CAF50;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 150%;
}

</style>

<body>
<?php	
	$url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

	$server = $url ["host"];
	$username = $url ["user"];
	$password = $url ["pass"];
	$db = substr ($url ["path"], 1);
	$conn = mysqli_connect ($server, $username, $password, $db);
	mysqli_set_charset($conn, "utf8");
	
    if($_GET["Action"]=="Save")
	{
        $updateorder = $_GET["orderno"];
        $status = $_GET["status"];

		$strSQL = "UPDATE confirm_order SET status = '" . $status . "' ";
        $strSQL .= "WHERE orderno = '" . $updateorder . "'";
        if (mysqli_query($conn, $strSQL)) {
            echo "Update Status successfully";
        } else {
        echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
        }
	}

    $objQueryHD = mysqli_query ($conn,"select Distinct orderno,orderdate,memberid,membername,addr from vi_confirm_order where status in ('Order','Prepare') order by orderdate asc");
    while($objResultHD = mysqli_fetch_array($objQueryHD))
	{
        $orderno = $objResultHD["orderno"];
        $memberid = $objResultHD["memberid"];
        $membername = $objResultHD["membername"];
        echo "<H1>Order No. : " . $orderno . "</H1>";
        echo "<H2>Order Date : " . $objResultHD["orderdate"] . "</H2>";
        echo "<H2>ชื่อสมาชิก : " . $membername . "</H2>";
        echo "<H2>ที่อยู่จัดส่ง : " . $objResultHD["addr"] . "</H2>";

        $objQueryLN = mysqli_query ($conn,"select * from vi_confirm_order where orderno = '".$orderno."' and status in ('Order','Prepare')");
        ?>
        <table width="100%" border="1">
            <tr>
            <th width="20%"> <div align="center">Order No </div></th>
            <th width="30%"> <div align="center">Items </div></th>
            <th width="15%"> <div align="center">Quantity </div></th>
            <th width="15%"> <div align="center">Price </div></th>
            <th width="20%"> <div align="center">สถานะ </div></th>
            </tr>
        <?php
        while($objResult = mysqli_fetch_array($objQueryLN))
        {
        ?>
            <tr>
            <td><?php echo $objResult["orderno"];?></td>
            <td><?php echo $objResult["item"];?></td>
            <td style="text-align:center"><?php echo $objResult["total_qty"];?></td>
            <td style="text-align:center"><?php echo $objResult["total_price"];?></td>
            <td style="text-align:center"><?php echo $objResult["status"];?></td>
            </tr>
        <?php
        }
        ?>	
        </table>

        <table width="100%">
        <tr>
            <td>
                <form name="frmMainCancel" method="post" action="?Action=Save&orderno=<?php echo $orderno;?>&status=Cancel">
                    <input name="btnSubmitCancel" type="submit" id="btnSubmitCancel" value="ยกเลิก">
                </form>	
            </td>
            <td>
                <form name="frmMainPrepare" method="post" action="?Action=Save&orderno=<?php echo $orderno;?>&status=Prepare">
                    <input name="btnSubmitPrepare" type="submit" id="btnSubmitPrepare" value="จัดเตรียมสินค้า">
                </form>	
            </td>
            <td>
                <form name="frmMainFinished" method="post" action="?Action=Save&orderno=<?php echo $orderno;?>&status=Finished">
                    <input name="btnSubmitFinished" type="submit" id="btnSubmitFinished" value="ส่งสินค้าเรียบร้อย">
                </form>	
            </td>
        </tr>
        </table>

    <?php
    }
	?>		

<input type="button" id="btnClose"
onclick="window.opener='x';window.close();" value="Close" />

<?php
	mysqli_close($conn);
?>
</body>
</html> 