<?php 
//La base de datos se llamara "galeria"
include('conexion.php');

//Vamos a hacer el codigo necesario para INSERTAR una nueva IMAGEN
//En la BBDD
if(isset($_POST['insertar'])){
	//Recogemos el titulo de la imagen
	$titulo=$_POST['titulo'];
	//Recogemos la imagen en si
	$archivo=time().'_'.$_FILES['archivo']['name'];
	// echo $_FILES['archivo']['type'];
	// echo $_FILES['archivo']['size'];
	// echo $_FILES['archivo']['tmp_name'];
	//Subo el fichero a la carpeta adecuada
	move_uploaded_file($_FILES['archivo']['tmp_name'], 'imagenes/'.$archivo);
	//Inserto el registro en la bbdd
	$sql="INSERT INTO imagenes(titulo,archivo)VALUES('$titulo','$archivo')";
	$consulta=mysqli_query($conexion, $sql);
}

//Que pasa si el usuario quiere eliminar una imagen
if(isset($_GET['accion'])){
	if($_GET['accion']=='eliminar'){

		$id=$_GET['id'];
		$sql="SELECT * FROM imagenes WHERE id=$id";
		$consulta=mysqli_query($conexion, $sql);
		$r=mysqli_fetch_array($consulta);
		$archivo=$r['archivo'];
		unlink('imagenes/'.$archivo);

		$sql="DELETE FROM imagenes WHERE id=$id";
		$consulta=mysqli_query($conexion, $sql);
	}
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Galeria de imagenes</title>
</head>
<body>
	<section>
		<header>Formulario para imagenes</header>
		<section>
			<!-- form>input:text+input:file+input:submit -->
			<form action="index.php" method="post" enctype="multipart/form-data">
				<input type="text" name="titulo" id="">
				<input type="file" name="archivo" id="" required>
				<input type="submit" value="insertar" name="insertar">
			</form>
		</section>
	</section>
	<hr>
	<section>
		<?php  
			$sql="SELECT * FROM imagenes";
			$consulta=mysqli_query($conexion, $sql);
			while($r=mysqli_fetch_array($consulta)){
				?>
				<article style="display:inline-block;">
					<img src="imagenes/<?php echo $r['archivo'];?>" alt="" width="200">
					<footer>
						<?php echo $r['titulo'];?>
						-
						<a href="index.php?accion=eliminar&id=<?php echo $r['id'];?>">Eliminar</a>
					</footer>
				</article>
				<?php
			}
		?>
	</section>
</body>
</html>
<?php  
mysqli_close($conexion);
?>