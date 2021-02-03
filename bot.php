<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'AYyU+19kM1Sc/SvtDOAkHMZt0R6/pz+1PQAmv+4WDzW6Z/nYx9qUJGVrfQlTChWXGS4YkZASmqj8s1HZmAoJSZiKWXcjm3DVxchx8PUnin+f3PToBHREHH3ihbD4sNVE/5ziwnXe7Cym5Cl2lFYwhwdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'de095f3ae95904dee375316809d4ef89';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array


include 'msgapitemplate.php';
include 'msgapitemplate2.php';


if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

        $reply_message = '';
        $reply_token = $event['replyToken'];

        $text = $event['message']['text'];
        
        $arrayText = array('ขนมขบเคี้ยว' => 'เลือกสินค้า ขนมขบเคี้ยว ได้เลยค่ะ',
                      'อาหาร' => 'เลือกสินค้า อาหาร ได้เลยค่ะ',
                      'เครื่องดื่ม' => 'เลือกสินค้า เครื่องดื่ม ได้เลยค่ะ',
                      'Hi' => 'Hello World!',
					  'Hello' => 'สวีสดีจร้า');

        if (array_key_exists($text, $arrayText)) {
			$text = $arrayText[$text];
			$data = [
				'replyToken' => $reply_token,
				// 'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  Debug Detail message
				'messages' => [['type' => 'text', 'text' => $text ]]
			];
		}else{
			$data = [
				'replyToken' => $reply_token,
				'messages' => [$msgapitemplate2]
            ];
		}
		
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";


function get_reply_message($url, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
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
