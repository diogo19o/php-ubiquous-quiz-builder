<html>
<head>
<title>Apagar Perfil</title>
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
	<?php
		$id=$_GET['id'];
		$tipo=1;
		$statement=$pdo->prepare("UPDATE users set tipo=:tipo WHERE id=:id");
		$statement->bindParam(':id',$id);
		$statement->bindParam(':tipo', $tipo);
		$statement->execute();

		header('location: promoverUtilizador.php');
		?>
</div>
</body>
</html>