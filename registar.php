<html>
<head>
<title>Inserir novo Perfil</title>
<link rel='stylesheet' href='style.css'/>
<head>
    <meta charset=utf-8">
<body>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<div class="container_login">
        <h2>Insira a informação do novo utilizador:</h2><br>
        <?php
        $message="";
        $emailExiste=0;
        $nomeExiste=0;
        if (isset($_POST['submit'])) {
            if((!empty($_POST['nome']))&&(!empty($_POST['email']))&&(!empty($_POST['password']))){
                $users=get_all_users($pdo);
                foreach($users as $user){
                    if($user['email']==$_POST['email']){
                        $message="Já existe uma conta registada com este email";
                        $emailExiste=1;
                    } else if($user['nome']==$_POST['nome']){
                        $message="Já existe uma conta registada com este nome";
                        $nomeExiste=1;
                    }
                }
                if($emailExiste == 0 && $nomeExiste == 0){
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
                    $message="Conta registada com sucesso";
                    header("location: login.php");
                }
            }else{
                $message="Por favor, preencha todos os campos";
            }
        }
        if($message!=''){
            echo"<div class='box'>$message</div>";
        }

        ?>
        <html>
        <body>
        <form action="" method="post">
            <h3>Username:</h3>
            <input type="text" class="claro" name="nome" size="30">
            <br/><br/>
            <h3>Email:</h3>
            <input type="Email" class="claro" name="email" size="30">
            <br/><br/>
            <h3>Password:</h3>
            <input type="password" class="claro" name="password" size="30">
            <br/><br/><br>
            <input type='submit' name='submit' value='Registar' class="search" style="background-color: #3366ff">
        </form>
        </body>
        </html>
    </div>
</div>
</body>
</html>