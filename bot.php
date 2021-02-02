<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'AYyU+19kM1Sc/SvtDOAkHMZt0R6/pz+1PQAmv+4WDzW6Z/nYx9qUJGVrfQlTChWXGS4YkZASmqj8s1HZmAoJSZiKWXcjm3DVxchx8PUnin+f3PToBHREHH3ihbD4sNVE/5ziwnXe7Cym5Cl2lFYwhwdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'de095f3ae95904dee375316809d4ef89';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array


if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

        $reply_message = '';
        $reply_token = $event['replyToken'];

        $text = $event['message']['text'];
        if ($text == 'Hi') {
            $text = 'Hello';
        }else{
            $text = send_reply_message('https://script.google.com/macros/s/AKfycbwG9gca_qwKqD03pEqtv3Q2HmpHsK0OYGY9-vxs2s4xkKobMy4/exec');
            echo "Result: ".$send_result."\r\n";
            return;
        }
        
        if ($text == '') {
            $text = $event['message']['text'];
        }
        
        $data = [
            'replyToken' => $reply_token,
            // 'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  Debug Detail message
            'messages' => [['type' => 'text', 'text' => $text ]]
        ];
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";


function get_reply_message($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
