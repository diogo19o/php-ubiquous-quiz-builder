<html>
<head>
<title>Editar Perfil</title>
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
		$message="";
		$users=get_all_users($pdo);
		$my_id=$_SESSION['user_id'];
		foreach($users as $user){
			if($user['id']==$my_id){
				if($user['tipo']==0){
					if (isset($_POST['submit'])) {
						if(!empty($_POST['nome'])&&(!empty($_POST['email']))&&(!empty($_POST['password']))){
							$password = sha1($_POST['password']);
							$statement=$pdo->prepare("UPDATE users set nome=:nome, email=:email,password=:password where id=:id");
							$statement->bindParam(':nome',$_POST['nome']);
							$statement->bindParam(':email',$_POST['email']);
							$statement->bindParam(':password',$password);
							$statement->bindParam(':id',$my_id);
							$statement->execute();
						}
					}
					?>
					<html>
					<body>

					<form action="" method="post">
					Nome:<br/>
					<input type="text" name="nome">
					<br/><br/>
					Email:<br/>
					<input type="email" name="email">
					<br/><br/>
					Password:<br/>
					<input type="password" name="password">
					<br/><br/>
					<input type='submit' name='submit' value='Editar'>
					</form>

					</body>
					</html>
					<?php
				}
			}
		}
	?>
</div>
</body>
</html>