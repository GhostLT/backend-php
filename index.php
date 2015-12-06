<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php obtener_pagina(); ?>
<?php include("includes/header.php"); ?>
  <table id="estructura">
    <tr>
      <td id="menu">
     	<?php echo menu_publico($curso_reg,$capitulo_reg); ?>
      </td>
      <td id="pagina">
      	<?php if(!is_null($capitulo_reg)) { ?>
        <h2><?php echo $capitulo_reg["nombre"]; ?></h2>
        <div id="pagina-contenido">
        <?php echo $capitulo_reg["contenido"]; ?>
        </div>
        <?php } else { ?>
		<h2>Bienvenido a Cursos Online</h2>
        <?php }	?>
     </td>
    </tr>
  </table>
<?php require_once("includes/footer.php"); ?>