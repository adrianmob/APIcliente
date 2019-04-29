<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-with');
header('Content-Type: application/json; charset=UTF-8');

$postData = json_decode(file_get_contents('php://input'),true);

include_once "conexion.php";

$correo = $postData['correo'];

$query = mysqli_query($db,"SELECT email FROM CLIENTE WHERE email = '$correo'");

$filas = $query->num_rows;

if ($filas > 0){
    $result = json_encode(array('success'=>false, 'msg'=>'Usuario existente'));
    echo $result;
    exit();
}

$password = md5($postData['password']);
$query = mysqli_query($db,"INSERT INTO CLIENTE SET
    nombre = '$postData[nombre]',
    email = '$postData[correo]',
    telefono = '$postData[telefono]',
    password = '$password',
    userId = '$postData[userId]'
    ");

if ($query) $result = json_encode(array('success'=>true));
else $result = json_encode(array('success'=>error, 'msg'=>'error, Intente de nuevo', 'error'=>$db));

echo $result;
