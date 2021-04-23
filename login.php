<html xmlns:font-size="http://www.w3.org/1999/xhtml">
<head>
<title>Login</title>
<link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
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
        <h1 style="text-align: center">Login</h1>
        <form method='post'>
            <?php
            if (isset($_POST['submit'])) {
                $username=$_POST['username'];
                $password=$_POST['password'];
                if(empty($username) or empty($password)){
                    $message ="Por favor preencha todos os campos";
                }else{
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
                }
                if($message!=''){
                        echo"<div class='box'>$message</div>";
                }
            }
            ?>
            <br><br>
            <h3>Username:<br/></h3>
            <input type='text' name='username' autocomplete="off" size="30" />
            <br/><br/>
            <h3>Password:<br/></h3>
            <input type='password' name='password' size="30"/>
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