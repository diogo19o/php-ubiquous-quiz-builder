<html>
<head>
    <meta charset=utf-8">
    <title>Respsostas</title>
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
		$perguntaID=$_GET['pergunta'];
		$questionarios=get_all_questionarios($pdo);
		$perguntas=get_all_perguntas($pdo);
		$respostas=get_all_respostas($pdo);
		foreach($perguntas as $pergunta){
			if($perguntaID==$pergunta['PerguntaID']){
				$perguntaTexto=$pergunta['Texto'];
				foreach($questionarios as $questionario){
					if($pergunta['QuestionarioID']==$questionario['QuestionarioID']){
						$questionarioTexto=$questionario['Titulo'];
						$questionarioID=$pergunta['QuestionarioID'];
					}
				}
			}
		}

		echo "<h3>Respostas da pergunta: '$perguntaTexto' do questionário: '$questionarioTexto'</h3>";
		foreach($respostas as $resposta){
			if($perguntaID==$resposta['PerguntaID']){
				$resposta_id=$resposta["RespostaID"];
				$resposta_texto=$resposta["Texto"];
				echo "<h1>$resposta_texto</h1>";
			}
		}
	?>
		</br>
		<?php
		echo "<a href='verQuestionario.php?questionario=$questionarioID' class='box' >Voltar</a>";
	?>
</div>
</body>
</html>