<?php
    $url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

    $server = $url ["host"];
    $username = $url ["user"];
    $password = $url ["pass"];
    $db = substr ($url ["path"], 1);
    $conn = mysqli_connect ($server, $username, $password, $db);
    mysqli_set_charset($conn, "utf8");

    $objQuery = mysqli_query ($conn,"select * from items where cate = '".$itmgrp."' order by items_name asc");
    $arr_items_lst = '';
    $host_php = "https://jeejijeejamarket.herokuapp.com/";

    $row_cnt = mysqli_num_rows($objQuery);
    $i = 0;
    while($objResult = mysqli_fetch_array($objQuery))
    {
        $itmname = $objResult["items_id"] ;
        $itmdesc = $objResult["items_desc"];
        $itmprice = $objResult["items_price"];
        $imagefile = $objResult["image"];
        $nextgroup = $objResult["nextgroup"];
        $status = $objResult["items_status"];
    }

    mysqli_close($conn);
    echo $jsonobj;
?>