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
      <br/>
      <a href="new_course.php">Agregar un nuevo curso</a>
      </td>
      <td id="pagina">
      	<?php if(!is_null($curso_reg)){	?>
        <h2><?php echo $curso_reg["nombre"]; ?></h2>
        <?php } elseif(!is_null($capitulo_reg)) { ?>
        <h2><?php echo $capitulo_reg["nombre"]; ?></h2>
        <div id="pagina-contenido">
        <?php echo $capitulo_reg["contenido"]; ?>
        <br /><br /><br />
        <a href="edit_chapter.php?capitulo=<?php echo urlencode($capitulo_reg["id"]) ?>">Editar capítulo</a>
        </div>
        <?php } else { ?>
		<h2>Selecciona algún curso o capítulo </h2>
        <?php }	?>
     </td>
    </tr>
  </table>
<?php require_once("includes/footer.php"); ?>