<html>
<head>
<title>Gerir Questionários</title>
    <meta charset=utf-8">
<link rel='stylesheet' href='style.css'/>
<head>
<body>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<h3>Gerir Questionários:</h3>
	<?php
		?>
		<a href='editarQuestionario.php' class='box' style='display:block'>Editar questionarios existentes</a>
		<a href='apagarQuestionario.php' class='box' style='display:block'>Apagar questionarios existentes</a>
</div>
</body>
</html>