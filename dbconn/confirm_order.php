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
	mysqli_query("SET NAMES UTF8");
	
    $objQueryHD = mysqli_query ($conn,"select Distinct membername,addr from vi_confirm_order where status = 'Order' order by membername asc");
    while($objResultHD = mysqli_fetch_array($objQueryHD))
	{
        $membername = $objResultHD["membername"];
        echo "<H1>" . $membername . "</H1>";
        echo "<H1>" . $objResultHD["addr"] . "</H1>";

        $objQueryLN = mysqli_query ($conn,"select * from vi_confirm_order where membername = '".$membername."' status = 'Order' order by orderno asc");
        ?>
        <table width="100%" border="1">
            <tr>
            <th width="244"> <div align="center">Order No </div></th>
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
            <td><?php echo $objResult["item"];?></td>
            <td><?php echo $objResult["total_qty"];?></td>
            <td><?php echo $objResult["total_price"];?></td>
            </tr>
        <?php
        }
        ?>	
        </table>
    <?php
    }
	?>		


<?php
	mysqli_close($conn);
?>
</body>
</html> 