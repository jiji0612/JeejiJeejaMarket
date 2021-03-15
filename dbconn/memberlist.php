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


    $objQuery = mysqli_query ($conn,"select 1 from member");
    $row_cnt = mysqli_num_rows($objQuery);
    if ($row_cnt == 0){
        echo '{
            "replyToken": "",  
            "messages": [
                {
                "type": "text",
                "text": "$ ยังไม่พบสมาชิกค่ะ",
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

        $arr_order_lst = '{
            "type": "box",
            "layout": "horizontal",
            "contents": [
                {
                "type": "text",
                "text": "ชื่อสมาชิก",
                "size": "sm",
                "weight": "bold",
                "color": "#555555",
                "flex": 0
                },
                {
                "type": "text",
                "text": "Ordered",
                "size": "sm",
                "weight": "bold",
                "color": "#111111",
                "align": "end"
                }
            ]
            },
            ';
        $objQuery = mysqli_query ($conn,"select * from member");
        while($objResult = mysqli_fetch_array($objQuery))
        {
            $arr_member_lst .= '{
                "type": "box",
                "layout": "horizontal",
                "contents": [
                    {
                    "type": "text",
                    "wrap": true,
                    "text": "'. $objResult["member_name"]. '",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                    },
                    {
                    "type": "text",
                    "wrap": true,
                    "text": "0",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                    }
                ]
                },
                ';
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
                            "text": "รายชื่อสมาชิก",
                            "weight": "bold",
                            "color": "#1DB446",
                            "size": "sm"
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
                                .$arr_member_lst.
                                '{
                                "type": "separator",
                                "margin": "xxl"
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