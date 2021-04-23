<html>
<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
<meta charset=utf-8">
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Tem a certeza que quer apagar esta pergunta?');
}
</script>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<?php
		$count=0;
		$count2=1;
		$nrCorreta=0;
		$QuestionarioID=$_GET['questionario'];
		$perguntaID=$_GET['pergunta'];
		$perguntas= get_all_perguntas($pdo);
		$respostas=get_all_respostas($pdo);
		$numeroPerguntas=0;
		foreach($perguntas as $pergunta){
			if($pergunta['PerguntaID']==$perguntaID){
				$pergunta_texto=$pergunta['Texto'];
				$perguntaID=$pergunta['PerguntaID'];
			}
		}
		if (isset($_POST['textoPergunta'])) {
			$id=$perguntaID;
			$statement=$pdo->prepare("UPDATE pergunta set texto=:texto where PerguntaID=:id");
			$statement->bindParam(':texto',$_POST['texto']);
			$statement->bindParam(':id',$id);
			$statement->execute();
		}		

		?>
		<form action="" method="post">
		Nome da Pergunta:<br/>
		<input type="text" name="texto" value="<?php echo"$pergunta_texto"; ?>">
		<br/><br/>
		<input type='submit' name='textoPergunta' value='Editar Nome da Pergunta'>
		</form>

		<form action="" method="post">
		<?php 
		
		foreach($respostas as $resposta){
			$perguntaID=$_GET['pergunta'];
			if($resposta['PerguntaID']==$perguntaID){
				$count +=1;
				$resposta_texto=$resposta['Texto'];
				if($resposta['Correta']==1){
					$resposta_correta="Correta";
				}else{
					$resposta_correta="Errada";
				}


				$respostaID=$resposta['RespostaID'];
				?>
				Resposta:<br/>
				<input type="text" name="text<?php echo"$count"; ?>" value="<?php echo"$resposta_texto"; ?>">
				<input type="text" name="correta<?php echo"$count"; ?>" value="<?php echo"$resposta_correta"; ?>">
				<br/><br/><?php

			}
		}
		if($count>=0){
			?>
			<input type='submit' name='resposta' value='Editar Respostas'>
			<?php
			echo "<a href='editarPergunta.php?questionario=$QuestionarioID' class='box' >Voltar</a>";
		}
        if($count<3)
        {
            echo "<a href='adicionarPerguntaOutras.php?questionario=$QuestionarioID&pergunta=$perguntaID' class='box' >Adicionar mais respostas possiveis</a> ";
            ?>
                </form>
            <?php
        }
		if (isset($_POST['resposta'])) {
			//print($count);
			for($i=1;$i<=$count;$i++){
				$teste=2;
				if(($_POST['correta'.$i]=="Correta")||($_POST['correta'.$i]=="correta")){
					//$teste=1;
					$nrCorreta=$nrCorreta + 1;	
				}else if(($_POST['correta'.$i]=="Errada")||($_POST['correta'.$i]=="errada")){
					//$teste=0;
				}else{
					echo"<h3>As resposta têm de estar 'Correta' ou 'Errada'</h3>";
				}

				//$nrCorreta=$nrCorreta + $_POST['correta'.$i];		
			}
			if($nrCorreta==1){
				$id=$perguntaID;														/////ATE AQUI FUNCIONA
				/*$statement=$pdo->prepare("UPDATE pergunta set texto=:texto where PerguntaID=:id");
				$statement->bindParam(':texto',$_POST['texto']);
				$statement->bindParam(':id',$id);
				$statement->execute();*/
				foreach($respostas as $resposta){

					if($resposta['PerguntaID']==$perguntaID){
						$teste=2;
						if(($_POST['correta'.$count2]=="Correta")||($_POST['correta'.$count2]=="correta")){
							$teste=1;
						}else if(($_POST['correta'.$count2]=="Errada")||($_POST['correta'.$count2]=="errada")){
							$teste=0;
						}

						$id=$resposta['RespostaID'];

						$statement=$pdo->prepare("UPDATE resposta set texto=:texto, Correta=:correta where RespostaID=:id");
						$statement->bindParam(':texto',$_POST['text'.$count2]);
						$statement->bindParam(':correta',$teste);
						$statement->bindParam(':id',$id);
						$statement->execute();
						$count2+=1;
					}
				}
				echo"<h3>As resposta à pergunta foram editadas</h3>";
			}else if($nrCorreta>1){
				echo"<h3>Mais que uma resposta certa indicada</h3>";
			}else if($nrCorreta==0){
				echo"<h3>Nenhuma resposta certa indicada</h3>";
			}

			
		}



		?>

</div>
</body>
</html>