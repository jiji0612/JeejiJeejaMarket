<?php
/*** Connect ***/
$url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

$server = $url ["host"];
$username = $url ["user"];
$password = $url ["pass"];
$db = substr ($url ["path"], 1);
$conn = mysqli_connect ($server, $username, $password, $db);
mysqli_query("SET NAMES UTF8");

$objQuery = mysqli_query ($conn,"select * from vi_member_order");
$arr_order_lst = '{
    "type": "box",
    "layout": "horizontal",
    "contents": [
        {
        "type": "text",
        "text": "Energy Drink",
        "size": "sm",
        "color": "#555555",
        "flex": 0
        },
        {
        "type": "text",
        "text": "$2.99",
        "size": "sm",
        "color": "#111111",
        "align": "end"
        }
    ]
    },
    ';

while($objResult = mysqli_fetch_array($objQuery))
	{

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
                                "text": "จำนวน",
                                "size": "sm",
                                "color": "#555555"
                                },
                                {
                                "type": "text",
                                "text": "3",
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
                                "text": "ยอดรวมสินค้า",
                                "size": "sm",
                                "color": "#555555"
                                },
                                {
                                "type": "text",
                                "text": "฿10",
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
                                "text": "ค่าจัดส่ง",
                                "size": "sm",
                                "color": "#555555"
                                },
                                {
                                "type": "text",
                                "text": "฿0",
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
                                "text": "ทั้งหมด",
                                "size": "sm",
                                "color": "#555555"
                                },
                                {
                                "type": "text",
                                "text": "฿10",
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
                            "text": "การจ้ายเงิน",
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
?>