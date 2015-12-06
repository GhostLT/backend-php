<?php require("includes/session.php");?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(intval($_GET["capitulo"]) == 0)
	{
		header("Location: content.php");
		exit;
	}

	if(isset($_POST["nombre"]))
	{
		$errores = validar_campos_obligatorios(array("nombre","posicion","visibilidad"));
	
		if(empty($errores))
		{	
			$capitulo_id = preparar_consulta(htmlentities($_GET["capitulo"],ENT_QUOTES,"UTF-8"));
		
			$nombre = preparar_consulta(htmlentities($_POST["nombre"],ENT_QUOTES,"UTF-8"));
			$posicion = preparar_consulta(htmlentities($_POST["posicion"],ENT_QUOTES,"UTF-8"));
			$visibilidad = preparar_consulta(htmlentities($_POST["visibilidad"],ENT_QUOTES,"UTF-8"));
			$contenido = preparar_consulta(htmlentities($_POST["contenido"],ENT_QUOTES,"UTF-8"));
			
			$consulta = "UPDATE capitulos SET
							nombre = '{$nombre}',
							posicion = {$posicion},
							visibilidad = {$visibilidad},
							contenido = '{$contenido}'
						WHERE id=" . $capitulo_id;
			$resultado = mysql_query($consulta,$conexion);
			if(mysql_affected_rows() == 1)
			{
				$mensaje = "Se ha actualizado correctamente el capítulo.";
			}
			else
			{
				$mensaje = "Se ha obtenido un error. <br/>" . mysql_error();
			}
		}
		else{
			$mensaje = "Se han obtenido ". count($errores) ." errores";
		}
	}
?>
<?php obtener_pagina(); ?>
<?php include("includes/header.php"); ?>
  <table id="estructura">
    <tr>
      <td id="menu">
      <?php echo menu($curso_reg,$capitulo_reg); ?>
      <br/>
      <a href="new_course.php">Agregar un nuevo curso</a>
      </td>
      <td id="pagina">
      <h2>Editar capítulo: <?php echo $capitulo_reg["nombre"]; ?></h2>
      <?php
	  		if(isset($mensaje))
			{
				echo $mensaje;
				foreach($errores as $error)
				{
					echo "<br/> - " . $error;
				}
			}
	  ?>
      <form action="edit_chapter.php?capitulo=<?php echo urlencode($capitulo_reg["id"]); ?>" method="post">
      <p>Nombre de capítulo: <input name="nombre" value="<?php echo $capitulo_reg["nombre"] ?>"/></p>
      <p>Posición:
      <select name="posicion">
      	<?php
			$resultado = obtener_capitulos_por_curso($capitulo_reg["curso_id"]);
			$num = mysql_num_rows($resultado);
			for($i=1;$i<=$num;$i++)
			{
				echo "<option value=\"{$i}\"";
				if($capitulo_reg["posicion"] == $i)
				{
					echo " selected";
				}
				echo ">{$i}</option>";	
			}
		?>
      </select>
      </p>
      <p>Visible:
      <input type="radio" name="visibilidad" value="0"
      <?php if($capitulo_reg["visibilidad"] == 0) { echo " checked"; } ?>
      >No</input>
      <input type="radio" name="visibilidad" value="1" 
	  <?php if($capitulo_reg["visibilidad"] == 1) { echo " checked"; } ?>
      >Si</input>
      </p>
      <p>Contenido:<br />
      <textarea name="contenido" rows="20" cols="80"><?php echo $capitulo_reg["contenido"] ?></textarea>
      </p>
      <input type="submit" value="Editar capítulo"/>
      <a href="delete_chapter.php?capitulo=<?php echo urlencode($capitulo_reg["id"]); ?>">Borrar capítulo</a>
      </form>      
      <a href="edit_course.php?curso=<?php echo urlencode($curso_reg["id"]); ?>">Cancelar</a>
     </td>
    </tr>
  </table>
<?php require_once("includes/footer.php"); ?>