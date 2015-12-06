<?php require("includes/session.php");?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php obtener_pagina(); ?>
<?php include("includes/header.php"); ?>
  <table id="estructura">
    <tr>
      <td id="menu">
      <?php echo menu($curso_reg,$capitulo_reg); ?>
      </td>
      <td id="pagina">
      <h2>Agregar un nuevo curso</h2>
      <form action="create_course.php" method="post">
      <p>Nombre de Curso: <input name="nombre"/></p>
      <p>Posición:
      <select name="posicion">
      	<?php
			$todos_los_cursos = obtener_cursos();
			$num_cursos = mysql_num_rows($todos_los_cursos);
			for($i=1;$i<=$num_cursos+1;$i++)
			{
				echo "<option value=\"{$i}\">{$i}</option>";	
			}
		?>
      </select>
      </p>
      <p>Visible:
      <input type="radio" name="visibilidad" value="0">No</input>
      <input type="radio" name="visibilidad" value="1">Si</input>
      </p>
      <input type="submit" value="Agregar curso"/>
      </form>      
      <a href="content.php">Cancelar</a>
     </td>
    </tr>
  </table>
<?php require_once("includes/footer.php"); ?>