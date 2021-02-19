<?php




//envio por post con curl porque va por SSL
function http_post($url, $json)
{
    $ans = null;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    try
    {
        $data_string = json_encode($json);
       
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $ans = json_decode(curl_exec($ch));
        if($ans->ok !== TRUE)
        {
            $ans = null;
        }
    }
    catch(Exception $e)
    {
        echo "Error: ", $e->getMessage(), "\n";
    }
    curl_close($ch);
    return $ans;
}

//recibe el id de usuaio objetivo y el texto a enviarle
function sendMessage($chatId, $text)
{

    global $URL;
    $json = ['chat_id'       => $chatId,
             'text'          => $text,
             'parse_mode'    => 'HTML'];
    
    //ejecuto el post enviandole este json
    return http_post($URL.'/sendMessage', $json);
}


?>