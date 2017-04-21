<?php  
//Archivo paginas/noticias.php
?>

<h1>Gestion de noticias en mi web</h1>

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

		if(isset($_GET['idCat'])){
			$sql="SELECT * FROM posts WHERE idCat=".$_GET['idCat'];

			//Quiero mostrar el nombre de la categoria que estoy viendo
			$sqlCat="SELECT * FROM categorias WHERE id=".$_GET['idCat'];
			$consultaCat=mysqli_query($conexion, $sqlCat);
			$rCat=mysqli_fetch_array($consultaCat);
			echo '<h3>'.$rCat['nombre'].'</h3>';

		}else{
			$sql="SELECT * FROM posts";
			echo '<h3>Todos</h3>';
		}



		//3.- Preguntar a la base de datos
		$consulta=mysqli_query($conexion, $sql);
		//4.- Procesar la respuesta
		while($r=mysqli_fetch_array($consulta)){
			?>
			<article class="post">
				<header>
					<?php  
					//if($r['imagen']){ //Lo mismo que la sig linea
					if(strlen($r['imagen'])>0){
						$imagen=$r['imagen'];
					}else{
						$imagen='nodisponible.png';
					}
					?>
					<img src="img/<?php echo $imagen;?>" width="150">
					<h2>
						<a href="index.php?p=noticias.php&accion=ver&id=<?php echo $r['id']; ?>">
							<?php echo $r['titulo']; ?>
						</a>
					</h2>
				</header>
				<a href="index.php?p=noticias.php&accion=borrar&id=<?php echo $r['id'];?>" onClick="if(!confirm('Estas seguro?')){return false;};">Borrar</a>
				<a href="index.php?p=noticias.php&accion=modificar&id=<?php echo $r['id'];?>">Modificar</a>
			
			</article>
			<hr>
			<?php
		}
		break;
	/////////////////////////////////////////////////////////
	case 'insertar':

		?>
		<h4>Insertar noticia</h4>
		<form action="index.php?p=noticias.php&accion=insercion" method="post" enctype="multipart/form-data">
		<input type="text" name="titulo" placeholder="titulo"><br>
		<textarea name="contenido" cols="30" rows="10"></textarea><br>
		<input type="text" name="autor" placeholder="autor"><br>
		<select name="idCat">
			<?php  
			$sql="SELECT * FROM categorias";
			$consulta=mysqli_query($conexion, $sql);
			while($r=mysqli_fetch_array($consulta)){
				?>
				<option value="<?php echo $r['id'];?>">
					<?php echo $r['nombre'];?>
				</option>
				<?php
			}
			?>
		</select><br>
		<input type="file" name="imagen"><br>
		<input type="submit" value="Insertar">
		</form>
		<?php

		break;
	/////////////////////////////////////////////////////////
	case 'insercion':
		//REcojo los datos
		$titulo=$_POST['titulo'];
		$contenido=$_POST['contenido'];
		$autor=$_POST['autor'];
		$idCat=$_POST['idCat'];
		$imagen=time().'_'.$_FILES['imagen']['name'];
		move_uploaded_file($_FILES['imagen']['tmp_name'], 'img/'.$imagen);
		$sql="INSERT INTO posts(titulo, contenido, autor, idCat, imagen)VALUES('$titulo', '$contenido', '$autor', '$idCat', '$imagen')";
		//Realizo la consulta (Ejecuto la consulta)
		$consulta=mysqli_query($conexion, $sql);
		if($consulta==true){
			echo 'Insertada con exito';
			header('Location:index.php?p=noticias.php');
		}else{
			echo 'Error al insertar';
		}
		break;
	/////////////////////////////////////////////////////////
	case 'modificar':
		//Recojo el id de la noticia que quiero modificar 
		$id=$_GET['id'];
		//establezco la consulta
		$sql="SELECT * FROM posts WHERE id=$id";
		//Ejecuto la consulta
		$consulta=mysqli_query($conexion, $sql);
		//Extraigo el unico registro de mi consula
		$r=mysqli_fetch_array($consulta);
		?>
		<form action="index.php?p=noticias.php&accion=modificacion" method="post" enctype="multipart/form-data">
			<input type="text" name="titulo" value="<?php echo $r['titulo'];?>"><br>
			<input type="text" name="autor" value="<?php echo $r['autor'];?>"><br>
			<textarea name="contenido"><?php echo $r['contenido'];?></textarea><br>
			<input type="hidden" name="id" value="<?php echo $id;?>">
			
			<select name="idCat">
				<?php  
				$sqlCat="SELECT * FROM categorias";
				$consultaCat=mysqli_query($conexion, $sqlCat);
				while($rCat=mysqli_fetch_array($consultaCat)){
					if($r['idCat']==$rCat['id']){
						$s='selected';
					}else{
						$s='';
					}
					?>
					<option value="<?php echo $rCat['id'];?>" <?php echo $s;?>>
						<?php echo $rCat['nombre'];?>
					</option>
					<?php
				}
				?>
			</select><br>

			<img src="img/<?php echo $r['imagen']; ?>" width="50">
			<input type="file" name="imagen"><br>

			<input type="submit" name="guardar" value="guardar">
		</form>
		<?php
		break;
	/////////////////////////////////////////////////////////
	case 'modificacion':
		$titulo=$_POST['titulo'];
		$autor=$_POST['autor'];
		$contenido=$_POST['contenido'];
		$id=$_POST['id'];
		$idCat=$_POST['idCat'];

		//Si subo una nueva imagen......
		if(strlen($_FILES['imagen']['name'])>0){

			$sql="SELECT * FROM posts WHERE id=$id";
			$consulta=mysqli_query($conexion, $sql);
			$r=mysqli_fetch_array($consulta);
			if(strlen($r['imagen'])>0){
				unlink('img/'.$r['imagen']);
			}

			$imagen=time().'_'.$_FILES['imagen']['name'];
			move_uploaded_file($_FILES['imagen']['tmp_name'], 'img/'.$imagen);
			$sql="UPDATE posts SET titulo='$titulo', autor='$autor', contenido='$contenido', idCat='$idCat', imagen='$imagen' WHERE id=$id";
		}else{
			$sql="UPDATE posts SET titulo='$titulo', autor='$autor', contenido='$contenido', idCat='$idCat' WHERE id=$id";
		}

		$consulta=mysqli_query($conexion, $sql);
		if($consulta==true){
			echo 'modificado con exito';
			header('Location:index.php?p=noticias.php');
		}else{
			echo 'Error al modificar';
		}
		break;
	/////////////////////////////////////////////////////////
	case 'borrar':
		//Recojo datos necesarios
		$id=$_GET['id'];

		//Averiguo el nombre de la imagen que quiero borrar
		$sql="SELECT * FROM posts WHERE id=$id";
		$consulta=mysqli_query($conexion, $sql);
		$r=mysqli_fetch_array($consulta);
		unlink('img/'.$r['imagen']);

		//Establezco consulta
		$sql="DELETE FROM posts WHERE id=$id";
		//Realizo la consulta (Ejecuto la consulta)
		$consulta=mysqli_query($conexion, $sql);
		if($consulta==true){
			echo 'Borrado con exito';
			header('Location:index.php?p=noticias.php');
		}else{
			echo 'Error al borrar';
		}
		break;
	/////////////////////////////////////////////////////////
	case 'ver':
		$id=$_GET['id'];
		//Estalezco una consulta a la base de datos
		$sql="SELECT * FROM posts WHERE id=$id";
		//Realizo la consulta (Ejecuto la consulta)
		$consulta=mysqli_query($conexion, $sql);
		//Extraigo el unicoo resultado que tiene mi consulta
		$r=mysqli_fetch_array($consulta);
		?>
		<h1>Noticia individual</h1>
		<article class="post">
			<header>
				<h2>
					<?php echo $r['titulo']; ?>
				</h2>
			</header>
			<div>
				<img src="img/<?php echo $r['imagen']; ?>" width="150">
				<?php echo $r['contenido']; ?>
			</div>
			<footer>
				Publicado por <strong><?php echo $r['autor'];?></strong>
			</footer>
		</article>
		<hr>
		<a href="index.php">Volver</a>
		<?php
		break;
}

?>