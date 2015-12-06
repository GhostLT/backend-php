<?php require("includes/session.php");?>
<?php verificar_sesion(); ?>
<?php include("includes/header.php"); ?>
  <table id="estructura">
    <tr>
      <td id="menu">&nbsp;</td>
      <td id="pagina"><h2>Administración</h2>
      <p>Bienvenido al módulo de Administración, <?php echo $_SESSION["username"]; ?></p>
      <ul>
        <li><a href="content.php">Administrar contenidos</a></li>
        <li><a href="new_user.php">Crear usuarios</a></li>
        <li><a href="logout.php">Salir</a></li>
      </ul></td>
    </tr>
  </table>
<?php include("includes/footer.php"); ?>