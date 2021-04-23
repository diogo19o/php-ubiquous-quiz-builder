<html>
<head>
    <meta charset=utf-8">
<title>Perguntas</title>
<link rel='stylesheet' href='style.css'/>
<head>
<body>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<?php
		$questionarioID=$_GET['questionario'];
		$questionarios=get_all_questionarios($pdo);
		$perguntas=get_all_perguntas($pdo);
		$users=get_all_users($pdo);
		$my_id=$_SESSION['user_id'];
		foreach($questionarios as $questionario){
			if($questionarioID==$questionario['QuestionarioID']){
				$questionarioTexto=$questionario['Titulo'];
			}
		}
		echo "<h3>Perguntas do questionario : '$questionarioTexto'</h3>";

		$admin=0;
		foreach($users as $user){
			if($user["id"]==$my_id){
				if($user['tipo']==1){
					$admin=1;
				}
			}
		}

		foreach($perguntas as $pergunta){
			if($questionarioID==$pergunta['QuestionarioID']){
				$pergunta_id=$pergunta["PerguntaID"];
				$pergunta_texto=$pergunta["Texto"];
				if($admin==1){	
					echo "<a href='verPergunta.php?pergunta=$pergunta_id' class='box' style='display:block'>$pergunta_texto</a>";
				}else{
					echo "<h2>$pergunta_texto</h2>";
				}
			}
		}
	?>
		</br>
		<?php
		echo "<a href='questionariosAtivos.php' class='box' >Voltar</a>";
	?>

</div>
</body>
</html>