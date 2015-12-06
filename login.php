<?php require("includes/session.php");?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(isset($_SESSION["usuario_id"]))
	{
		header("Location: admin.php");
		exit;
	}
?>
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
		
		if(empty($errores))
		{
			$consulta = "SELECT *
							FROM usuarios
							WHERE username='{$username}' 
							AND password='{$password}' 
							LIMIT 1";
			$resultado = mysql_query($consulta,$conexion);
			if(mysql_affected_rows()==1)
			{
				$usuario = mysql_fetch_array($resultado);
				$_SESSION["usuario_id"]=$usuario["id"];
				$_SESSION["username"] = $usuario["username"];
				header("Location: admin.php");
				exit;
			}
			else
			{
				$mensaje = "No se ha podido acceder al módulo: " . mysql_error();

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
      <a href="index.php">Regresar a la website</a>
      </td>
      <td id="pagina">
      	<h2>Administración</h2>
        <?php if(isset($mensaje)) { echo "<p>" . $mensaje . "</p>"; } ?>
        <form action="login.php" method="post">
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
        <input type="submit" value="Ingresar" />
        </form>
     </td>
    </tr>
  </table>
<?php require_once("includes/footer.php"); ?>