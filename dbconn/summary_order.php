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
    mysqli_query("SET NAMES UTF8");

    $objQuery = mysqli_query ($conn,"select * from vi_member_order where memberid = '".$uid."'");
    $arr_order_lst = '';
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
                "text": "'.$objResult["item"].'  ('.$objResult["total_qty"].')",
                "size": "sm",
                "color": "#555555",
                "flex": 0
                },
                {
                "type": "text",
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
                        "text": "ร้าน จ้ากะจี้ เฟส1",
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
                        "text": "ตะกร้า",
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
                            "text": "การจ่ายเงิน",
                            "size": "xs",
                            "color": "#aaaaaa",
                            "flex": 0
                            },
                            {
                            "type": "text",
                            "text": "ปลายทาง",
                            "color": "#aaaaaa",
                            "size": "xs",
                            "align": "end"
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

    //var_dump(json_decode($jsonobj, true));
    mysqli_close($conn);
    echo $jsonobj;
}
?>