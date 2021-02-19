
<?php

require_once('sendMessage.php');


$TOKEN = "1688842636:AAEhFVLkIlpEPW43oIRig_App7EkJrZriUU";
$URL = "https://api.telegram.org/bot".$TOKEN;




//guardar id de chat, mensaje recibido por telegram y el nombre del usuario en fichero.txt
function saveTxT($chatId, $from, $message){
    $myfile = "fichero.txt";
    //$fichero = file_get_contents($myfile);
    $txt = $chatId."-".$message."-".$from. " \n";
    //$fichero.= $txt;


    file_put_contents($myfile, $txt, FILE_APPEND | LOCK_EX);
    
    
}



//aqui recibo por php input el json de la api de telegram
$update = json_decode(file_get_contents('php://input'), TRUE);



//cojo del json lo que me interesa
$chatId = $update["message"]["chat"]["id"];
$chatType = $update["message"]["chat"]["type"];
$message = $update["message"]["text"];
$from = $update["message"]["from"]["first_name"];
$esComando = $update["message"]["entities"];

//guardo en txt en el server
saveTxT($chatId, $from ,$message);

if(isset($esComando)){
    //devuelvo el mensaje a telegram por post con curl
    sendMessage($chatId, $message);
}
else{
    sendMessage($chatId, "No entiendo lo que dises piltrafilla...");
}



?>