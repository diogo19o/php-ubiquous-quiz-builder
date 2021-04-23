<html>
<head>
<title>Inserir novo Perfil</title>
<link rel='stylesheet' href='style.css'/>
<head>
<body>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<h3>Insira a informação do novo utilizador:</h3>
	<?php
		$message="";	
		$emailexiste=0;
		if (isset($_POST['submit'])) {
			if((!empty($_POST['nome']))&&(!empty($_POST['email']))&&(!empty($_POST['password']))){
				$users=get_all_users($pdo);
				foreach($users as $user){
					if($user['email']==$_POST['email']){
						$message="Já exsite uma conta registada com este email";
						$emailexiste=1;	
					}
				}
				if($emailexiste==0){
					$password = sha1($_POST['password']);
					$id=0;
					$tipo=0;
					$message="";
					$statement=$pdo->prepare("INSERT INTO users VALUES(:id,:nome,:email,:password,:tipo)");
					$statement->bindParam(':id',$id);
					$statement->bindParam(':nome',$_POST['nome']);
					$statement->bindParam(':email',$_POST['email']);
					$statement->bindParam(':password',$password);
					$statement->bindParam(':tipo',$tipo);
					$statement->execute();

					$message="Foi registado com sucesso";
				}
			}else{
				$message="Por favor preencha todos os campos";
			}
		}
		if($message!=''){
			echo"<div class='box'>$message</div>";
		}

		?>
		<html>
		<body>

		<form action="" method="post">
		Nome:<br/>
		<input type="text" name="nome">
		<br/><br/>
		Email:<br/>
		<input type="Email" name="email">
		<br/><br/>
		Password:<br/>
		<input type="password" name="password">
		<br/><br/>
		<input type='submit' name='submit' value='Inserir'>
		</form>

		</body>
		</html>
</div>
</body>
</html>