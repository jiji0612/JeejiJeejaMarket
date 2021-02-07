<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'AYyU+19kM1Sc/SvtDOAkHMZt0R6/pz+1PQAmv+4WDzW6Z/nYx9qUJGVrfQlTChWXGS4YkZASmqj8s1HZmAoJSZiKWXcjm3DVxchx8PUnin+f3PToBHREHH3ihbD4sNVE/5ziwnXe7Cym5Cl2lFYwhwdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'de095f3ae95904dee375316809d4ef89';

$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array


//include 'msgapitemplate.php';
//include 'msgapitemplate2.php';
//include 'msgapitemplate3.php';

include 'autobottext.php';

if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {
		error_log(json_encode($event));
        $reply_message = '';
        $reply_token = $event['replyToken'];
		
        $text = $event['message']['text'];

        if (array_key_exists($text, $arrayText)) {
			$arr = $arrayText[$text];
			if(startsWith($arr,"file")) 
			{
				$file = explode(':', $arr);

				$string = file_get_contents($file[1]);
				$json_a = json_decode($string, true);
				$json_a['replyToken'] = $reply_token;
				$post_body = json_encode($json_a, JSON_UNESCAPED_UNICODE);
			}
		} else if(startsWith($text,"order")) {
			$string = file_get_contents('receivedorder.json');
			$json_a = json_decode($string, true);
			$json_a['replyToken'] = $reply_token;
			$post_body = json_encode($json_a, JSON_UNESCAPED_UNICODE);
		} else {
			//$string = file_get_contents('defaultemoji.json');
			//$json_a = json_decode($string, true);
			//$json_a['replyToken'] = $reply_token;
			//$post_body = json_encode($json_a, JSON_UNESCAPED_UNICODE);

			$uid = $event['source']['userId'];
			// HTTP Request
			//GET https://api.line.me/v2/bot/profile/userId

			// Headers
			//Authorization: Bearer CHANNEL-ACCESS-TOKEN
			//Get User Frofile
			$API_GET = "https://api.line.me/v2/bot/profile/" . $uid;
			$GET_HEADER = array('Authorization: Bearer ' . $ACCESS_TOKEN);
			$get_user = get_reply_message($API_GET, $GET_HEADER);
			$data = [
				'replyToken' => $reply_token,
				'messages' => [['type' => 'text', 'text' => $get_user["displayName"] ]]
			];
			$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
		}
		$send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

		//Debug Code
		$data = [
			'replyToken' => $reply_token,
			'messages' => [['type' => 'text', 'text' => '"'.$send_result.'"' ]]
		];
		$post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
		
        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";

function startsWith ($string, $startString) 
{ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
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

function get_reply_message($url, $post_header)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
