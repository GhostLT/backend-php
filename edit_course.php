<?php require("includes/session.php");?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(intval($_GET["curso"]) == 0)
	{
		header("Location: content.php");
		exit;
	}

	if(isset($_POST["nombre"]))
	{	
		$errores = validar_campos_obligatorios(array("nombre","posicion","visibilidad"));
	
		if(empty($errores))
		{
			$curso_id = preparar_consulta($_GET["curso"]);
		
			$nombre = preparar_consulta(htmlentities($_POST["nombre"],ENT_QUOTES,"UTF-8"));
			$posicion = preparar_consulta(htmlentities($_POST["posicion"],ENT_QUOTES,"UTF-8"));
			$visibilidad = preparar_consulta(htmlentities($_POST["visibilidad"],ENT_QUOTES,"UTF-8"));
			
			$consulta = "UPDATE cursos SET
							nombre = '{$nombre}',
							posicion = {$posicion},
							visibilidad = {$visibilidad}
						WHERE id={$curso_id}";
			$resultado = mysql_query($consulta,$conexion);
			if(mysql_affected_rows() == 1)
			{
				$mensaje = "Se ha actualizado correctamente el curso.";
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
      </td>
      <td id="pagina">
      <h2>Editar curso: <?php echo $curso_reg["nombre"]; ?></h2>
      <form action="edit_course.php?curso=<?php echo urlencode($curso_reg["id"]); ?>" method="post">
      <p>Nombre de Curso: <input name="nombre" value="<?php echo $curso_reg["nombre"] ?>"/></p>
      <p>Posición:
      <select name="posicion">
      	<?php
			$todos_los_cursos = obtener_cursos();
			$num_cursos = mysql_num_rows($todos_los_cursos);
			for($i=1;$i<=$num_cursos;$i++)
			{
				echo "<option value=\"{$i}\"";
				if($curso_reg["posicion"] == $i)
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
	  <?php if($curso_reg["visibilidad"] == 0) { echo " checked"; } ?>
      >No</input>
      <input type="radio" name="visibilidad" value="1"
      <?php if($curso_reg["visibilidad"] == 1) { echo " checked"; } ?>
      >Si</input>
      </p>
      <input type="submit" name="submit" value="Editar curso"/>
      <a href="delete_course.php?curso=<?php echo urlencode($curso_reg["id"]); ?>">Borrar curso</a>
      </form>      
      <a href="content.php">Cancelar</a>      
      <p>
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
      </p>
      <hr />
      <h3>Capítulos del curso</h3>
      <ul>
      <?php		
		$capitulos = obtener_capitulos_por_curso($curso_reg["id"],false);
		while($capitulo = mysql_fetch_array($capitulos))
		{
			echo "<li><a href=\"content.php?capitulo=" . $capitulo["id"] . "\">" . $capitulo["nombre"] . "</a></li>";
		}
	  ?>
      </ul>
      <br/>
      <a href="new_chapter.php?curso=<?php echo urlencode($curso_reg["id"]); ?>">Agregar un nuevo capítulo a este curso
      </a>
     </td>
    </tr>
  </table>
<?php require_once("includes/footer.php"); ?>