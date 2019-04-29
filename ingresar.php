<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-with');
header('Content-Type: application/json; charset=UTF-8');

$postData = json_decode(file_get_contents('php://input'),true);

include_once "conexion.php";
$password = md5($postData['password']);
$correo = $postData['correo'];

$query = mysqli_query($db,"SELECT userId,password FROM CLIENTE WHERE email = '$correo'");
$filas = $query->num_rows;
if ($filas > 0){
    $fila = $query->fetch_assoc();
    if( $fila['password'] == $password){
        $userId = $fila['userId'];
        $result = json_encode(array('success'=>true, 'userId'=>$userId));
    }
    else{
        $result = json_encode(array('success'=>false, 'msg'=>'Contraseña incorrecta'));
    }
    
}
else $result = json_encode(array('success'=>false, 'msg'=>'Usuario no existe'));

echo $result;