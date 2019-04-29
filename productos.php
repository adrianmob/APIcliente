<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-with');
header('Content-Type: application/json; charset=UTF-8');

$postData = json_decode(file_get_contents('php://input'),true);

$funcion = $postData['funcion'];

if($funcion == 'all') producto();
else productoId();

function producto(){

    include_once "conexion.php";

    global $postData;
    
    $idNegocio = $postData['id'];
    
    $query = mysqli_query($db,"SELECT id_producto,nombre,descripcion,cantidad,precio FROM PRODUCTO WHERE FK_idNegocio = $idNegocio");
    $filas = $query->num_rows;
    
    if ($filas > 0){
    
        $productos = array();
        while($fila = $query->fetch_assoc()) {
            array_push($productos,$fila);
        }
        $result = json_encode(array('success'=>true, 'productos'=>$productos));
    
    }
    
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay información'));
    
    echo $result;

}

function productoId(){

    include_once "conexion.php";

    global $postData;
    
    $idProducto = $postData['id'];
    
    $query = mysqli_query($db,"SELECT 
    a.id_producto,
    a.nombre,
    a.descripcion,
    a.cantidad,
    a.precio,
    b.latitud,
    b.longitud 
    FROM  PRODUCTO AS a
    JOIN NEGOCIO AS b
    ON a.FK_idNegocio = b.id_negocio
    WHERE a.id_producto = $idProducto");
    
    $filas = $query->num_rows;
    
    if ($filas > 0){

        $producto = $query->fetch_assoc();
    
        $result = json_encode(array('success'=>true, 'producto'=>$producto));
    
    }
    
    else $result = json_encode(array('success'=>false, 'msg'=>'No hay información'));
    
    echo $result;

}
