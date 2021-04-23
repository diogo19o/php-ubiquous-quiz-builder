<html>
<head>
<title>Apagar Perfil</title>
<link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Tem a certeza que quer promover este questionário?');
}
</script>
<head>
<body>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<h3>Selecione o membro que pretende promover para administrador:</h3>
	<?php
		$users=get_all_users($pdo);
		foreach($users as $user){
			if($user['tipo']!=1){
				$user_id=$user["id"];
				$user_nome=$user["nome"];
				echo "<a href='promover.php?id=$user_id' class='boxMembros' style='display:block'";?>onclick="return checkDelete()"<?php echo">$user_nome</a>";
			}
		}
	?>
    <br>
    <?php
    echo "<a href='gerirUtilizadores.php' class='box' >Voltar</a>";
    ?>
</div>
</body>
</html>