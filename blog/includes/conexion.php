<?php  
// ###### Nombre del fichero:
// includes/conexion.php

//1.- Conectar a la base de datos
$servidor='localhost';
$usuario='root';
$clave='';
$base='blog';
$conexion = mysqli_connect($servidor, $usuario, $clave, $base);
mysqli_set_charset($conexion, 'utf8');

?>