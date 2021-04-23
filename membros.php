<html>
<head>
<title>Membros</title>
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
	<h3>Membros:</h3>
	<?php
		$users=get_all_users($pdo);
		foreach($users as $user){
			if($user['tipo']!=1){
				$user_id=$user["id"];
				$user_nome=$user["nome"];
				echo "<a href='estatisticas.php?user=$user_id' class='boxMembros' style='display:block'>$user_nome</a>";
			}
		}
	?>
    <br>
    <?php
    echo "<a href='questionariosAtivos.php' class='box' >Voltar</a>";
    ?>
</div>
</body>
</html>