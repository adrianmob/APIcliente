<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-with');
header('Content-Type: application/json; charset=UTF-8');


$postData = json_decode(file_get_contents('php://input'),true);
$funcion = $postData['funcion'];

if($funcion == 'ver'){
    ver();
}
else if($funcion == 'menu'){
    menu();
}
else{
    actualizar();
}

function menu(){
    include_once "conexion.php";
    global $postData;
    $userId =  $postData['userId'];
    $query = mysqli_query($db,"SELECT 
    nombre, 
    fotografia, 
    apellidoMat, 
    apellidoPat
    FROM CLIENTE WHERE userId = '$userId'");
    $filas = $query->num_rows;
    if ($filas > 0){
        $usuario = $query->fetch_assoc();
        $result = json_encode(array('success'=>true, 'usuario'=>$usuario));

    }

    else $result = json_encode(array('success'=>false, 'msg'=>'No hay información'));

    echo $result;
}

function ver(){
    include_once "conexion.php";
    global $postData;
    $userId =  $postData['userId'];
    $query = mysqli_query($db,"SELECT 
    nombre, 
    email, 
    direccionFiscal, 
    rfc, 
    CFDI, 
    razonSocial, 
    formaPago, 
    fotografia, 
    userId, 
    telefono, 
    apellidoMat, 
    apellidoPat,
    calle 
    FROM CLIENTE WHERE userId = $userId");
    $filas = $query->num_rows;
    if ($filas > 0){
        $usuario = $query->fetch_assoc();
        $result = json_encode(array('success'=>true, 'usuario'=>$usuario));

    }

    else $result = json_encode(array('success'=>false, 'msg'=>'No hay información'));

    echo $result;
    
}

function actualizar(){
    include_once "conexion.php";
    global $postData;
    $parametros = "";
    foreach ($postData as $clave => $valor) {
        if(empty($parametros)){
            $parametros = $clave." = ";
        }
        else {
            $parametros = $parametros.",";
            $parametros = $parametros."".$clave." = ";
        }

        if(is_null($valor)) $parametros = $parametros."null";
        else $parametros = $parametros."'".$valor."'"; 
        
    }

    $query = mysqli_query($db,"UPDATE CLIENTE SET ".$parametros." WHERE userId = ".$postData['userId']);

    if($query){
        $result = json_encode(array('success'=>true, 'msg'=>'Perfil actualizado'));
    }

    else{
        $result = json_encode(array('success'=>false, 'msg'=>'Algo salio mal'));

    }
    
    echo $result;

}