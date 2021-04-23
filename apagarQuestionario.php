<html>
<head>
<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Tem a certeza que quer apagar este questionário?');
}
</script>
<head>
<body>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
$my_id = $_SESSION['user_id'];

?>
<div class='container'>
	<h3>Apagar:</h3>
	<?php

        $users = get_all_users($pdo);
        foreach ($users as $user)
        {
            if($user['id']==$my_id)
            {
                if($user['tipo']=="1")
                {
                    $questionarios = get_all_questionarios($pdo);
                }
                else{
                    $questionarios = get_seus_questionarios($pdo,$my_id);
                }
            }
        }
		$perguntas=get_all_perguntas($pdo);
		$resultados=get_all_resultados($pdo);
		foreach($questionarios as $questionario){
			$respondido=0;
			$rascunho=0;
			$questionario_id=$questionario["QuestionarioID"];
			$questionario_titulo=$questionario["Titulo"];
			if($questionario['Acesso']=="privado"){
				echo "<a href='apagarQuestionarioApagar.php?questionario=$questionario_id' class='boxBom1' style='display:block'";?>onclick="return checkDelete()"<?php echo">$questionario_titulo - Tem o acesso privado</a>";
				$rascunho=1;
			}else{
				
				foreach($resultados as $resultado){
					if($resultado['QuestionarioID']==$questionario_id){
						$respondido=1;
					}
				}
			}
			if($respondido==0&&$rascunho==0){
				echo "<a href='apagarQuestionarioApagar.php?questionario=$questionario_id' class='boxBom1' style='display:block'"; ?>onclick="return checkDelete()"<?php echo">$questionario_titulo - O questionário não tem resultados</a>";
			}
		}
		?>
		</br>
		<a href='opcoesSeusQuestionarios.php' class='box' >Voltar</a>
</div>
</body>
</html>