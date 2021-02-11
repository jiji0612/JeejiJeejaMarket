<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $status = $_GET['status'];

    /*** Connect ***/
    $url = parse_url (getenv ("CLEARDB_DATABASE_URL"));

    $server = $url ["host"];
    $username = $url ["user"];
    $password = $url ["pass"];
    $db = substr ($url ["path"], 1);
    $conn = mysqli_connect ($server, $username, $password, $db);
    mysqli_set_charset($conn, "utf8");

    $que = "select membername, sum(total_price) as total_price from vi_confirm_order ";
    $que .= "where status = '".$status."' ";
    $que .= "group by order,membername ";
    $que .= "order by membername asc";

    $objQuery = mysqli_query($conn,$que);
    $arr_order_lst = '';
    $sum_qty = '0';
    $sum_price = '0';
    $membername = "";

    while($objResult = mysqli_fetch_array($objQuery))
    {
        $arr_order_lst .= '{
            "type": "box",
            "layout": "horizontal",
            "contents": [
                {
                "type": "message",
                "label": "'.$objResult["membername"].'",
                "text": "getord:'.$objResult["membername"].'",
                "size": "sm",
                "color": "#555555",
                "flex": 0
                },
                {
                "type": "message",
                "label": "'.$objResult["total_price"].'",
                "text": "getord:'.$objResult["total_price"].'฿",
                "size": "sm",
                "color": "#111111",
                "align": "end"
                }
            ]
            },
        ';
    }

    //Summary
    $objQuery = mysqli_query ($conn,"select sum(total_qty) as total_qty,sum(total_price) as total_price from vi_confirm_order where status = '".$status."'");
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
                                        "label": "ยกเลิก",
                                        "text": "ยกเลิกสั่งซื้อ"
                                        }
                                    },
                                    { 
                                    "type": "button",
                                    "style": "link",
                                    "height": "sm",
                                    "action": {
                                        "type": "message",
                                        "label": "ยืนยัน",
                                        "text": "ยืนยันสั่งซื้อ"
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
                            "text": "*อย่าลืม* ใส่ที่อยู่จัดส่งหลัง ยืนยัน ด้วยนร้า",
                            "size": "sm",
                            "color": "#1DB446",
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

    //var_dump(json_decode($jsonobj, true));
    mysqli_close($conn);
    echo $jsonobj;
}
?>