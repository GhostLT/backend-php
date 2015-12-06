<?php require("includes/session.php");?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	$errores = validar_campos_obligatorios(array("nombre","posicion","visibilidad"));	
	
	if(!empty($errores))
	{
		header("Location: new_course.php");
		exit;
	}
?>
<?php
	$nombre = preparar_consulta(htmlentities($_POST["nombre"],ENT_QUOTES,"UTF-8"));
	$posicion = preparar_consulta(htmlentities($_POST["posicion"],ENT_QUOTES,"UTF-8"));
	$visibilidad = preparar_consulta(htmlentities($_POST["visibilidad"],ENT_QUOTES,"UTF-8"));
	
	$consulta = "INSERT INTO cursos (
				nombre,posicion,visibilidad
				) VALUES (
				'{$nombre}',{$posicion},{$visibilidad}
				)";
	if(mysql_query($consulta,$conexion))
	{
		header("Location: content.php");
		exit;
	}
	else
	{
		echo "No se ha podido crear el curso: " . mysql_error();	
	}
?>

<?php
	mysql_close($conexion);
?>