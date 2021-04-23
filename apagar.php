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
		$statement=$pdo->prepare("DELETE FROM users WHERE id=:id");
		$statement->bindParam(':id',$id);
		$statement->execute();

		header('location: apagarUtilizador.php');
		?>
</div>
</body>
</html>