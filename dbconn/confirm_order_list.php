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

    $query = "select membername, sum(total_price) as total_price from vi_confirm_order ";
    $query .= "where status in ('" . str_replace(",","','" $status) . "') ";
    $query .= "group by membername ";

    $objQuery = mysqli_query($conn,$query);
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
            "text": "ยอดสั่งซื้อ",
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
    $membername = "";

    while($objResult = mysqli_fetch_array($objQuery))
    {
        $arr_order_lst .= '{
            "type": "box",
            "layout": "horizontal",
            "contents": [
                {
                "type": "text",
                "text": "'.$objResult["membername"].'",
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
                        "text": "สำหรับผู้ดูแลระบบ",
                        "weight": "bold",
                        "color": "#1DB446",
                        "size": "sm"
                        },
                        {
                        "type": "text",
                        "text": "Order Summary",
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
                                        "label": "เช็คยอด",
                                        "text": "chkord"
                                        }
                                    },
                                    { 
                                    "type": "button",
                                    "style": "link",
                                    "height": "sm",
                                    "action": {
                                        "type": "uri",
                                        "label": "จัดการ",
                                        "uri": "https://jeejijeejamarket.herokuapp.com/dbconn/confirm_order.php"
                                        }
                                    }
                                ]
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