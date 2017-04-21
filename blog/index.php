<?php  
require('includes/conexion.php');

if(isset($_GET['p'])){
	//Si p, tiene valor, lo recojo
	$p=$_GET['p'];
}else{
	//Si no tiene valor, cargo el listado
	$p='noticias.php';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blog</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>

	<section id="contenedor">
		<nav id="menu">
			<?php include('includes/menu.php'); ?>
			<hr>
			<?php include('includes/menuCategorias.php'); ?>
		</nav>
		<section id="contenido">
			<?php include('paginas/'.$p); ?>
		</section>
	</section>

</body>
</html>

<?php  
//5.- Desconectar de la base de datos
mysqli_close($conexion);
?>