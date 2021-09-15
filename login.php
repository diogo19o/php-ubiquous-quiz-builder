<html xmlns:font-size="http://www.w3.org/1999/xhtml">
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="style.css?ver=<?php echo filemtime('style.css');?>">
    <meta charset=utf-8>
</head>
<body>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();

if(!loggedin()){
?>
<div class='container'>
    <div class="container_login">
        <h1>Login</h1>
        <form method='post'>
            <?php
            if (isset($_POST['submit'])) {
                $username=$_POST['username'];
                $password=$_POST['password'];
                if(empty($username) or empty($password)){
                    $message ="Por favor preencha todos os campos";
                }else{
                    /*
                    $users=get_all_users($pdo);

                    foreach($users as $user){
                        if($user["nome"]==$username && $user["password"]==sha1($password)){
                            if($user["tipo"]=="user"){
                                echo "<h1>user</h1>";
                            }else if($user["tipo"]=="admin"){
                                echo "<h1>admin</h1>";
                            }
                            $message="";
                            $user_id=$user["id"];
                            $_SESSION['user_id']=$user_id;
                            header('location: questionariosAtivos.php');
                        }else{
                            $message="Username ou Password incorreta";
                        }
                    }
                    */
                    $pwdHash = sha1($password);
                    try {
                        $sql = "SELECT * from users WHERE (nome=:nome AND password=:pwd)";
                        $statement = $pdo->prepare($sql);
                        $statement->bindParam(':nome', $username);
                        $statement->bindParam(':pwd', $pwdHash);
                        $statement->execute();
                        $users = $statement->fetchAll();
                    } catch (Exception $ex) { echo $ex->getMessage(); }

                    if(sizeof($users) == 1){ 
                        // Se encontrou um utilizador com as 
                        // credenciais inseridas entao faz login
                        
                        if($users[0]['tipo'] == 1){
                            echo "<h1>admin</h1>";
                        }else{
                            echo "<h1>user</h1>";
                        }
                        $message="";
                        $user_id=$users[0]["id"];
                        $_SESSION['user_id']=$user_id;
                        header('location: questionariosAtivos.php');
                    }else{
                        $message="Username ou Password incorreta";
                    }
                }
                if($message!=''){
                        echo"<div class='box'>$message</div>";
                }
            }
            ?>
            <br><br>
            <h3>Username:<br/></h3>
            <input type='text' class="claro" name='username' autocomplete="off" size="25" />
            <br/><br/>
            <h3>Password:<br/></h3>
            <input type='password' class="claro" name='password' size="25"/>
            <br/><br/><br>
            <input type='submit' name='submit' class="search" value='Login' style="background-color: #3366ff">
        </form>
    </div>
</div>
<?php
}else{
	header('location: questionariosAtivos.php');
}
?>
</body>
</html>