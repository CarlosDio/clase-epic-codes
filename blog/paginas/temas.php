<?php  
//Archivo paginas/temas.php
?>

<h1>Gestion de temas en mi web</h1>

<?php  
//Este archivo recibira una ACCION a realizar
//Dependiendo de la accion, hago una cosa u otra
if(isset($_GET['accion'])){
	$accion=$_GET['accion'];
}else{
	$accion='listado';
}

//Realizamos un switch, para hacer una accion u otra
switch($accion){
	/////////////////////////////////////////////////////////
	case 'listado':

		echo '<ul>';
		//Establecemos la pregunta
		$sql="SELECT * FROM temas";
		//Esto es lo que EJECUTA realmente la consulta...
		$consulta=mysqli_query($conexion, $sql);
		//Recorremos los resultados de mi $consulta
		while($r=mysqli_fetch_array($consulta)){
			echo '<li>';
			echo $r['nombre'];
			echo ' - <a href="index.php?p=temas.php&accion=borrar&id='.$r['id'].'" onClick="if(!confirm(\'Estas seguro?\')){return false;};">borrar</a>';
			echo ' - <a href="index.php?p=temas.php&accion=modificar&id='.$r['id'].'">modificar</a>';
			echo ' - <a href="index.php?p=temas.php&accion=ver&id='.$r['id'].'">Ver</a>';
			echo '</li>';
		}
		echo '</ul>';
		echo '<hr>';
		echo '<a href="index.php?p=temas.php&accion=insertar">Nuevo tema</a>';
		break;
	/////////////////////////////////////////////////////////
	case 'insertar':

		?>
		<h2>Alta de Tema</h2>
		<form action="index.php?p=temas.php&accion=insercion" method="post">
			<input type="text" name="nombre" placeholder="Nombre de tema"><br>
			<input type="submit" name="insertar" value="insertar">
		</form>
		<?php	

		break;
	/////////////////////////////////////////////////////////
	case 'insercion':

		//Recoger los datos por post
		$nombre=$_POST['nombre'];
		//Establecer consulta de insercion
		$sql="INSERT INTO temas(nombre)VALUES('$nombre')";
		//Realizo la consulta (Ejecuto la consulta)
		$consulta=mysqli_query($conexion, $sql);
		if($consulta==true){
			echo 'Insertada con exito';
			header('Location:index.php?p=temas.php');
		}else{
			echo 'Error al insertar';
		}

		break;
	/////////////////////////////////////////////////////////
	case 'modificar':

		?>
		<h2>Modifico el tema</h2>
		<?php 
		//Recojo el id de del tema que quiero modificar 
		$id=$_GET['id'];
		//establezco la consulta
		$sql="SELECT * FROM temas WHERE id=$id";
		//Ejecuto la consulta
		$consulta=mysqli_query($conexion, $sql);
		//Extraigo el unico registro de mi consulta
		$r=mysqli_fetch_array($consulta);
		?>
		<form action="index.php?p=temas.php&accion=modificacion" method="post">
			<input type="text" name="nombre" placeholder="Nombre de tema" value="<?php echo $r['nombre'];?>"><br>
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<input type="submit" name="guardar" value="guardar">
		</form>
		<?php

		break;
	/////////////////////////////////////////////////////////
	case 'modificacion':

		//Recojo los datos que quiero actualizar en la bbdd
		$id=$_POST['id'];
		$nombre=$_POST['nombre'];
		//Establezco la consulta
		$sql="UPDATE temas SET nombre='$nombre' WHERE id=$id";
		//Ejecuto la consulta
		$consulta=mysqli_query($conexion, $sql);
		//Miro a ver si se ejecuta o no bien
		if($consulta==true){
			echo 'Ok';
			header('Location:index.php?p=temas.php');
		}else{
			echo 'Error';
		}

		break;
	/////////////////////////////////////////////////////////
	case 'borrar':

		//Recojo datos necesarios
		$id=$_GET['id'];
		//Establezco consulta
		$sql="DELETE FROM temas WHERE id=$id";
		//Realizo la consulta (Ejecuto la consulta)
		$consulta=mysqli_query($conexion, $sql);
		if($consulta==true){
			echo 'Borrado con exito';
			//Redireccionar en este punto a esta pagina
			header('Location:index.php?p=temas.php');
		}else{
			echo 'Error al borrar';
		}

		break;

	/////////////////////////////////////////////////////////
	case 'ver':
		echo '<h2>Muestro el tema</h2>';
		//Recojo el id de del tema que quiero modificar 
		$id=$_GET['id'];
		//establezco la consulta
		$sql="SELECT * FROM temas WHERE id=$id";
		//Ejecuto la consulta
		$consulta=mysqli_query($conexion, $sql);
		//Extraigo el unico registro de mi consulta
		$r=mysqli_fetch_array($consulta);
		//Muestro datos de la base de datos
		echo $r['nombre'];
		break;
}

?>