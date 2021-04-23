<html>
<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
<meta charset=utf-8">
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<h3>Qual o questionário que pretende editar:</h3>
	<?php

	
		$questionarios=get_all_questionarios($pdo);
		$resultados=get_all_resultados($pdo);
		foreach($questionarios as $questionario){
			$respondido=0;
			$questionario_id=$questionario["QuestionarioID"];
			$questionario_titulo=$questionario["Titulo"];	
			foreach($resultados as $resultado){
				if($resultado['QuestionarioID']==$questionario_id){
					$respondido=1;
				}
			}
			if($respondido==0){
				echo "<a href='editarQuestionarioEscolha.php?questionario=$questionario_id' class='box' style='display:block' >$questionario_titulo - O questionário não tem resultados</a>";
			}
		}
		?>
		</br>
		<a href='gerirQuestionarios.php' class='box'>Voltar</a>
</div>
</body>
</html>