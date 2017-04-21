<h4>Categorias</h4>
<a href="index.php?p=noticias.php&accion=listado">Todas</a><br>
<?php  
//Consulta de seleccion
$sql="SELECT * FROM categorias";
//Ejecuto la consulta
$consulta=mysqli_query($conexion, $sql);
//Recorremos los resultados
while($r=mysqli_fetch_array($consulta)){

	// echo '<a href="index.php?p=noticias.php&accion=listado&idCat='.$r['id'].'">'.$r['nombre'].'</a><br>';

	?>
	<a href="index.php?p=noticias.php&accion=listado&idCat=<?php echo $r['id'];?>"><?php echo $r['nombre'];?></a><br>

	<?php
}
?>