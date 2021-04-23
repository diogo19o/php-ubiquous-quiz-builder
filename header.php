<div id='title_bar'>
<ul>
	<?php
	if(loggedin()){
		?>

		<?php
		$my_id=$_SESSION['user_id'];
		$pdo = create_database_connection();
		$users=get_all_users($pdo);
        $questionarios=get_all_questionarios($pdo);
        ?><li><a href='questionariosAtivos.php'>Questionários ativos</a></li><?php
        ?><li><a href='introduzirQuestionarioModo.php'>Criar Questionário</a></li><?php
        ?><li><a href='opcoesSeusQuestionarios.php' class='box' >Seus Questionários</a></li><?php
		foreach($users as $user){
			$user_id=$user["id"];
			if($user_id==$my_id){
				if($user['tipo']==1){
					?>
                    <li><a href='apagarQuestionario.php'>Apagar Questionários</a></li>
                    <li><a href='membros.php'>Membros</a></li>
                    <li><a href='gerirUtilizadores.php'>Gerir Utilizadores</a></li>
					<?php
                    //<li><a href='gerirQuestionarios.php'>Gerir Questionarios</a></li>
				}if($user['tipo']==0){
					?>
                    <li><a href='estatisticas.php' class='box' >Estatísticas</a></li>
                    <li><a href='editarPerfil.php' class='box'>Editar Perfil</a></li>
					<?php
				}
			}
		}
		?>
		<li><a href='logout.php'>Logout</a></li>
        <?php
		?>
		<div class="topright">
		<?php
		foreach($users as $user){
			$userid=$user["id"];
			if($userid==$my_id){
				$nome=$user['nome'];
				echo "<h10>Logged in as: $nome</h10>";
			}
		}
		?>
		</div>
		<?php
	}else{
		?>
		<li><a href='login.php'>Log in</a></li>
		<li><a href='registar.php'>Registar</a></li>
		<?php
	}
	?>
	<div class='clear'></div>
</ul>
</div>