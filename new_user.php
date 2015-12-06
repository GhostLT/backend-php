<?php require("includes/session.php");?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(isset($_POST["username"]))
	{
		$errores = array();
		$errores = array_merge($errores, validar_campos_obligatorios(array("username","password")));
		$max_caracteres = array("username" => 30,"password" => 30);
		foreach($max_caracteres as $campo => $max)
		{
			if(strlen($_POST[$campo])>$max)
			{
				$errores[] = $campo;	
			}			
		}
		
		$username = trim(preparar_consulta($_POST["username"]));
		$password = sha1(trim(preparar_consulta($_POST["password"])));
		//$password = trim(preparar_consulta($_POST["password"]));
		
		if(empty($errores))
		{
			$consulta = "INSERT INTO usuarios (
							username,password
							) VALUES (
							'{$username}','{$password}')";
			$resultado = mysql_query($consulta,$conexion);
			if($resultado)
			{
				$mensaje = "El usuario ha sido creado.";
			}
			else
			{
				$mensaje = "No se ha podido crear el usuario: " . mysql_error();
			}
		}
		else
		{
			$mensaje = "Se han encontrado " . count($errores) . " errores";
		}
	}
?>
<?php include("includes/header.php"); ?>
  <table id="estructura">
    <tr>
      <td id="menu">
      <a href="new_user.php">Regresar al menú principal</a>
      </td>
      <td id="pagina">
      	<h2>Crear nuevo usuario</h2>
        <?php if(isset($mensaje)) { echo "<p>" . $mensaje . "</p>"; } ?>
        <form action="admin.php" method="post">
        <table>
            <tr>
                <td>Nombre de usuario:</td>
                <td><input type="text" name="username" /></td>
            </tr>
            <tr>
                <td>Contraseña:</td>
                <td><input type="password" name="password" /></td>
            </tr>
        </table>
        <input type="submit" value="Crear usuario" />
        </form>
     </td>
    </tr>
  </table>
<?php require_once("includes/footer.php"); ?>