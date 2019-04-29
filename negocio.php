<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-with');
header('Content-Type: application/json; charset=UTF-8');

$postData = json_decode(file_get_contents('php://input'),true);

$funcion = $postData['funcion'];

if($funcion == 'all') negocio();
else negocioId();


function negocio(){
    include_once "conexion.php";
    global $postData;
    $categoria = $postData['categoria'];

    $query = mysqli_query($db,"SELECT 
            b.nombre, 
            b.callenumero, 
            b.colonia, 
            b.horaapertura, 
            b.horacierre,
            b.id_negocio
        FROM SUBCATNEGOCIO AS a
        JOIN NEGOCIO AS b
        ON a.id_SUBCATNEGOCIO = b.FK_subcategoria
        WHERE a.nombre = '$categoria'");
    $filas = $query->num_rows;
    if ($filas > 0){
        $locales = array();
        while($row = $query->fetch_assoc()) {
            array_push($locales,$row);
        }
        $result = json_encode(array('success'=>true, 'negocio'=>$locales));

    }

    else $result = json_encode(array('success'=>false, 'msg'=>'No hay información'));

    echo $result;

}

function negocioId(){

    include_once "conexion.php";
    global $postData;
    $id = $postData['id_negocio'];

    $query = mysqli_query($db,"SELECT 
            latitud, 
            longitud, 
            colonia,
            callenumero,
            codigopostal,
            ciudad,
            estado, 
            horaapertura, 
            horacierre
        FROM NEGOCIO WHERE id_negocio = '$id'");
    $filas = $query->num_rows;
    if ($filas > 0){
        $local = $query->fetch_assoc();
        $result = json_encode(array('success'=>true, 'local'=>$local));

    }

    else $result = json_encode(array('success'=>false, 'msg'=>'No hay información'));

    echo $result;

}

