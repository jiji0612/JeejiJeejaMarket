<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $itmgrp = $_GET['itmgrp'];

    /*** Connect ***/
    $url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

    $server = $url ["host"];
    $username = $url ["user"];
    $password = $url ["pass"];
    $db = substr ($url ["path"], 1);
    $conn = mysqli_connect ($server, $username, $password, $db);
    mysqli_set_charset($objCon, "utf8");

    $objQuery = mysqli_query ($conn,"select * from items where cate = '".$itmgrp."'");
    $arr_items_lst = '';
    $host_php = "https://jeejijeejamarket.herokuapp.com/";

    $row_cnt = mysqli_num_rows($objQuery);
    $i = 0;
    while($objResult = mysqli_fetch_array($objQuery))
    {
        $tis620 = iconv("utf-8", "tis-620", $objResult["items_name"] );
		$utf8 = iconv("tis-620", "utf-8", $objResult["items_name"] );
        $itmname = $utf8;

        $itmdesc = $objResult["items_desc"];

        $itmprice = $objResult["items_price"];
        $imagefile = $objResult["image"];
        
        $arr_items_lst .= '{
                        "type": "buttons",
                        "width": "30px",
                        "thumbnailImageUrl": "' . $host_php . 'images/' . $imagefile  . '",
                        "imageAspectRatio": "rectangle",
                        "imageSize": "contain",
                        "imageBackgroundColor": "#FFFFFF",
                        "title": "' . $itmdesc . '",
                        "text": "ราคา ' . $itmprice . ' บาท",
                        "actions": [
                            {
                                "type": "message",
                                "label": "หยิบใส่ตะกร้า",
                                "text": "order ' . $itmname . ' ราคา=' . $itmprice . '"
                            }
                        ]
                    }';
        $i = $i + 1;

        if($i < $row_cnt){
            $arr_items_lst .= ',';
        }
    }

    $jsonobj = '{
        "replyToken": "",
        "messages": [
            {
                "type": "template",
                "altText": "This is a carousel template",
                "template": {
                    "type": "carousel",
                    "imageAspectRatio": "rectangle",
                    "imageSize": "contain",
                    "columns": [
                    ' . $arr_items_lst . '
                ]
            }
        }
        ]
    }';

    //var_dump(json_decode($jsonobj, true));
    mysqli_close($conn);
    echo $jsonobj;
}
?>