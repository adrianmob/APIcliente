<?php

$host = "freeinstance.cvphzq25aqlg.us-west-1.rds.amazonaws.com";
$usuario = "elestor";
$pass = "sim0n11.";
$database = "ELESTOR";

/*
$host = "localhost";
$usuario = "estore";
$pass = "Admin1234";
$database = "ELESTOR";*/

$db = new mysqli($host,$usuario,$pass,$database);

if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}






