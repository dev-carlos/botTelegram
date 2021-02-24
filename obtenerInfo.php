<?php

//aqui recibo por php input el json de la api de telegram
$update = json_decode(file_get_contents('php://input'), TRUE);

$opcion = $update["option"];

if(isset($opcion) && $opcion == 1){
    $datos = readTxt();
    echo json_encode($datos);
}

//funcion para leer txt y descomponer en variables
function readTxt(){

    $miArrayDeObjetos = [];
    $myfile = fopen("fichero.txt", "r") or die("No se pudo abrir el fichero!");
    while(!feof($myfile)) {
        $lineaTxt = fgets($myfile);
        $datosLinea = explode("-", $lineaTxt);
        //$datosJson = json_encode($datosLinea);
        array_push($miArrayDeObjetos, $datosLinea);
    }
      fclose($myfile);

      return $miArrayDeObjetos;
}


?>