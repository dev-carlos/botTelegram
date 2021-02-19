<?php
require_once("sendMessage.php");

$TOKEN = "1688842636:AAEhFVLkIlpEPW43oIRig_App7EkJrZriUU";
$URL = "https://api.telegram.org/bot".$TOKEN;

$update = file_get_contents("php://input");
$update = json_decode($update, TRUE);

if(isset($update["mensaje"]) && isset($update["idChat"])){

    $mensaje = $update["mensaje"];
    $idChat = $update["idChat"];

    sendMessage($idChat, $mensaje);
}




?>