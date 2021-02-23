<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uid = $_POST['uid'];

    /*** Connect ***/
    $url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

    $server = $url ["host"];
    $username = $url ["user"];
    $password = $url ["pass"];
    $db = substr ($url ["path"], 1);
    $conn = mysqli_connect ($server, $username, $password, $db);
    mysqli_set_charset($conn, "utf8");


    $objQuery = mysqli_query ($conn,"select * from vi_member_order where memberid = '".$uid."'");
    $row_cnt = mysqli_num_rows($objQuery);
    if ($row_cnt == 0){
        echo '{
            "replyToken": "",  
            "messages": [
              {
                "type": "text",
                "text": "$ ยังไม่มีสินค้าในตะกร้าค่ะ",
                "emojis": [
                    {
                    "index": 0,
                    "productId": "5ac2216f040ab15980c9b448",
                    "emojiId": "148"
                    }
                ]
              }
            ]
          }';
    } else {

        //Get Profile
        $membername = "";
        $memberaddr = "";
        $objQuery = mysqli_query($conn, "Select * From member Where memberid = '". $uid ."'");
        while($objResult = mysqli_fetch_array($objQuery))
        {
            $membername = $objResult["membername"];
            $memberaddr = $objResult["addr"];
        }

        $confrimtext = "ConfirmOrder";
        $confrimlabel = "ยืนยันสั่งซื้อ";

        $infofooter = "เราจะรีบจัดส่งให้นะคะ";
        $coloralert = "#1DB446";
        if ($memberaddr == ""){
            $confrimtext = "Profile";
            $confrimlabel = "ใส่ที่อยู่จัดส่ง";
            $infofooter = "ใส่ที่อยู่จัดส่ง *เฉพาะครั้งแรก* ก่อนค่ะ";
            $coloralert = "#FF0000";
        }

        $arr_order_lst = '{
            "type": "box",
            "layout": "horizontal",
            "contents": [
                {
                "type": "text",
                "text": "สินค้า",
                "size": "sm",
                "weight": "bold",
                "color": "#555555",
                "flex": 0
                },
                {
                "type": "text",
                "text": "ราคา",
                "size": "sm",
                "weight": "bold",
                "color": "#111111",
                "align": "end"
                }
            ]
            },
            ';
        $sum_qty = '0';
        $sum_price = '0';

        while($objResult = mysqli_fetch_array($objQuery))
        {
            $arr_order_lst .= '{
                "type": "box",
                "layout": "horizontal",
                "contents": [
                    {
                    "type": "text",
                    "wrap": true,
                    "text": "'. $objResult["item"]. '  ('.$objResult["total_qty"].')",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                    },
                    {
                    "type": "text",
                    "wrap": true,
                    "text": "'.$objResult["total_price"].'฿",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                    }
                ]
                },
                ';
        }

        //Summary
        $objQuery = mysqli_query ($conn,"select sum(total_qty) as total_qty,sum(total_price) as total_price from vi_member_order where memberid = '".$uid."'");
        while($objResult = mysqli_fetch_array($objQuery))
        {
            $sum_qty = $objResult["total_qty"];
            $sum_price = $objResult["total_price"];
        }

        $jsonobj = '{
            "replyToken": "",
            "messages": [
                {
                    "type": "flex",
                    "altText": "Hello Flex Message",
                    "contents": {
                        "type": "bubble",
                        "body": {
                        "type": "box",
                        "layout": "vertical",
                        "contents": [
                            {
                            "type": "text",
                            "text": "ชื่อสมาชิก : ' . $membername . '",
                            "weight": "bold",
                            "color": "#1DB446",
                            "size": "sm"
                            },
                            {
                            "type": "text",
                            "text": "รายการสั่งซื้อ",
                            "weight": "bold",
                            "size": "xxl",
                            "margin": "md"
                            },
                            {
                            "type": "text",
                            "text": "ที่อยู่ : ' . $memberaddr . '",
                            "size": "xs",
                            "color": "#aaaaaa",
                            "wrap": true
                            },
                            {
                            "type": "separator",
                            "margin": "xxl"
                            },
                            {
                            "type": "box",
                            "layout": "vertical",
                            "margin": "xxl",
                            "spacing": "sm",
                            "contents": ['
                                .$arr_order_lst.
                                '{
                                "type": "separator",
                                "margin": "xxl"
                                },
                                {
                                "type": "box",
                                "layout": "horizontal",
                                "margin": "xxl",
                                "contents": [
                                    {
                                    "type": "text",
                                    "text": "จำนวนรวม",
                                    "size": "sm",
                                    "color": "#555555"
                                    },
                                    {
                                    "type": "text",
                                    "text": "'.$sum_qty.'",
                                    "size": "sm",
                                    "color": "#111111",
                                    "align": "end"
                                    }
                                ]
                                },
                                {
                                "type": "box",
                                "layout": "horizontal",
                                "contents": [
                                    {
                                    "type": "text",
                                    "text": "ราคารวม",
                                    "size": "sm",
                                    "color": "#555555"
                                    },
                                    {
                                    "type": "text",
                                    "text": "'.$sum_price.'฿",
                                    "size": "sm",
                                    "color": "#111111",
                                    "align": "end"
                                    }
                                ]
                                },
                                {
                                    "type": "separator",
                                    "margin": "xxl"
                                },
                                {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "contents": [
                                        {
                                        "type": "button",
                                        "style": "link",
                                        "height": "sm",
                                        "action": {
                                            "type": "message",
                                            "label": "ยกเลิกสั่งซื้อ",
                                            "text": "CancelOrder"
                                            }
                                        },
                                        { 
                                        "type": "button",
                                        "style": "link",
                                        "height": "sm",
                                        "color": "'.$coloralert.'",
                                        "action": {
                                            "type": "message",
                                            "label": "'.$confrimlabel.'",
                                            "text": "'.$confrimtext.'"
                                            }
                                        }
                                    ]
                                }
                            ]
                            },
                            {
                            "type": "separator",
                            "margin": "xxl"
                            },
                            {
                            "type": "box",
                            "layout": "horizontal",
                            "margin": "md",
                            "contents": [
                                {
                                "type": "text",
                                "text": "'.$infofooter.'",
                                "size": "sm",
                                "color": "'.$coloralert.'",
                                "flex": 0
                                }
                            ]
                            }
                        ]
                        },
                        "styles": {
                        "footer": {
                            "separator": true
                        }
                        }
                    }
                }
            ]
        }';

        echo $jsonobj;
    }

    mysqli_close($conn);
}
?>