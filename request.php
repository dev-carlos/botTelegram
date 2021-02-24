
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
    //comandos disponibles con sus respuestas    
switch($message){
    case '/start':
        $msg['text']  = 'Hola ' . $oUserFrom->getFirstName() . '!' . PHP_EOL;
        $msg['text'] .= '¿Qué puedo hacer por ti? Puedes ver una lista de las opciones disponibles con el comando /help';
        $msg['reply_to_message_id'] = null;
        break;

    case '/ayuda':
        $msg['text']  = 'Los comandos disponibles son:' . PHP_EOL;
        $msg['text'] .= '/start Inicializa el bot';
        $msg['text'] .= '/fecha Muestra la fecha actual';
        $msg['text'] .= '/hora Muestra la hora actual';
        $msg['text'] .= '/ayuda Muestra esta ayuda';
        $msg['text'] .= '/noticias Muestra las noticias principales';
        $msg['text'] .= '/saludo SAludo del bot';
        $msg['reply_to_message_id'] = null;
        break;
    case '/fecha':
        $msg['text']  = 'La fecha actual es ' . date('d/m/Y');
        break;

    case '/hora':
        $msg['text']  = 'La hora actual es ' . date('H:i:s');
	break;

    case '/noticias':      
        getNoticias($chatId);
        break;
    case '/saludo':
        $msg['text']  = "Hola, soy RO_BOT encantado ";
            sendMessage($chatId,$response);
            break;
    default:
        $msg['text']  = 'Lo siento ' . $oUserFrom->getFirstName() . ', pero [' . $cmd . '] no es un comando válido.' . PHP_EOL;
        $msg['text'] .= 'Prueba /ayuda para ver la lista de comandos disponibles';
        break;
/*
    case '/ayuda':
    $response = "Tranquilo, estoy contigo";
    sendMessage($chatId,$response);
    break;
    case '/saludo':
        $response = "Hola, soy RO_BOT encantado ";
        sendMessage($chatId,$response);
        break;

    case '/noticias':      
        getNoticias($chatId);
        break;
    }
    */
    
}
    sendMessage($chatId, $msg);
}
else{
    sendMessage($chatId, "No entiendo lo que dises piltrafilla...");
}

function getNoticias($chatId){
include ('simple_html_dom.php');
$context = stream_context_create(array('header'=> array ('Accept : application/xml')));
$url = "https://www.europapress.es/rss/rss.aspx";
$xmlstring = file_get_contents($url,false,$context);
$xml = simplexml_load_string($xmlstring,"SimpleXMLElement",LIBXML_NOCDATA);
$json = json_encode($xml);
$array = json_decode($json,true);

// recorres las noticias que tenemos

for ($i=0; $i <9 ; $i++) { 
    # code...
    $titulos = $titulos."\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
    +info</a>";
}
sendMessage($chatId,$titulos);

}

?>