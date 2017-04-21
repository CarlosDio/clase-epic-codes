<?php  
// ###### Nombre del fichero:
// conexion.php

//1.- Conectar a la base de datos
$servidor='localhost';
$usuario='root';
$clave='';
$base='galeria';
$conexion = mysqli_connect($servidor, $usuario, $clave, $base);
mysqli_set_charset($conexion, 'utf8');

?>