<html>
<head>
<title>Estatisticas</title>
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
		$users=get_all_users($pdo);
		$resultados=get_all_resultados($pdo);
		$questionarios=get_all_questionarios($pdo);
		if(isset($_GET['user'])&& !empty($_GET['user'])){
			$userid=$_GET['user'];
		}else{
			$userid=$_SESSION['user_id'];
		}

		$my_id=$_SESSION["user_id"];
		foreach($users as $user){
			if($user["tipo"]==1){
				$utilizador=$user;
			}
		}
		foreach($questionarios as $questionario){
		    if($questionario['QuestionarioID']==($_GET['questionario']))
            {
                $titulo = $questionario['Titulo'];
            }
		}

		$respondidos=0;
		foreach ($resultados as $resultado) {
			if(($userid)==($resultado["UtilizadorID"])&&($resultado["QuestionarioID"])==($_GET['questionario'])){
				$certas=$resultado["RespostasCertas"];
				$erradas=$resultado["RespostasErradas"];
				$respostaTotal=$certas + $erradas;
				$dataResposta=$resultado["DataDePreenchimento"];
				$score = $resultado["Score"];
				$modo = $resultado["Modo"];
				$percentagem=number_format(($certas/$respostaTotal)*100,2,'.','');
				echo "<h1>Nome : $titulo</h1>";
				echo "<h1>Número de Respostas : $respostaTotal</h1>";
				echo "<h1>Certas : $certas</h1>";
				echo "<h1>Erradas : $erradas</h1>";
				echo "<h1>Data de preenchimento : $dataResposta</h1>";
				echo "<h1>Percentagem : $percentagem %</h1>";
				echo "<h1>Modo : $modo</h1>";
				if($modo!="questionario")
                {
                    echo "<h1>Score: $score</h1>";
                }
			}
		}
	?>
	</br>
	<?php
	echo "<a href='estatisticas.php?user=$userid' class='box' >Voltar</a>";
	?>
</div>
</body>
</html>