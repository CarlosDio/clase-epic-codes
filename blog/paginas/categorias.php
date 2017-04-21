<h1>Listado de Categorias</h1>
<?php  
echo '<ul>';
//Establecemos la pregunta
$sql="SELECT * FROM categorias";
//Esto es lo que EJECUTA realmente la consulta...
$consulta=mysqli_query($conexion, $sql);
//Recorremos los resultados de mi $consulta
while($r=mysqli_fetch_array($consulta)){
	echo '<li>';
	echo $r['nombre'];
	
	echo ' - <a href="index.php?p=borrarcat.php&id='.$r['id'].'" onClick="if(!confirm(\'Estas seguro?\')){return false;};">borrar</a>';

	echo ' - <a href="index.php?p=modificarcat.php&id='.$r['id'].'">modificar</a>';

	echo '</li>';
}
echo '</ul>';
?>