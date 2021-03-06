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
        <form class="login" method='post'>
            <?php
            if (isset($_POST['submit'])) {
                $username=$_POST['username'];
                $password=$_POST['password'];
                if(empty($username) or empty($password)){
                    $message ="Por favor preencha todos os campos";
                }else{        

                    if(authenticateUser($pdo,$username,sha1($password)) == 1){ 
                        header('location: questionariosAtivos.php');
                    }else{
                        $message="Username ou Password incorreta";
                    }
                }
                if($message!=''){
                        echo"<div class='boxErrorLoginRegister'>$message</div>";
                }
            }
            ?>
            <br><br>
            <h3>Username:<br/></h3>
            <input type='text' class="claro" name='username' autocomplete="off" size="30" />
            <br/><br/>
            <h3>Password:<br/></h3>
            <input type='password' class="claro" name='password' size="30"/>
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