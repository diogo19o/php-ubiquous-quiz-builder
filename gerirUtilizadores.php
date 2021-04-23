<html>
<head>
<title>Gerir Utilizadores</title>
<link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
<head>
<body>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<h3>Gerir Utilizadores:</h3>
	<?php
		?>
		<a href='promoverUtilizador.php' class='boxBom' style='display:block'>Promover um utilizador</a>
		<a href='registar.php' class='boxBom' style='display:block'>Criar novo utilizador</a>
		<a href='inserirAdministrador.php' class='boxBom' style='display:block'>Criar novo administrador</a>
		<a href='apagarUtilizador.php' class='boxBom4' style='display:block'>Apagar um utilizador/administrador</a>
</div>
</body>
</html>