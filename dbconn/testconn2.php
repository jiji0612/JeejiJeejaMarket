<html>
<head>
<title>PHP Test MySql Connection</title>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
</head>
<body>

<?php $url = parse_url (getenv ("mysql://ba7f82c856e7b5:9090f5ee@us-cdbr-east-03.cleardb.com/heroku_565ce00c19449b1?reconnect=true"));

$server = $url ["host"];
$username = $url ["user"];
$password = $url ["pass"];
$db = substr ($url ["path"], 1);
$link = mysqli_connect ($server, $username, $password, $db);
$result = mysqli_query ($link,"select * from vi_member_order");

while ($user = mysqli_fetch_array ($result)) {
echo $user ['memberid'],":" ;, $user ['addr'],"<br>" ;;
}
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
		<tr>
		<td><div align="center"></div></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
        <td></td>
	</tr>		
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

</body>
</html> 