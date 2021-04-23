<html>
<head>
    <title>Editar Perfil</title>
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
    <h1>Editar Perfil</h1><br>
    <?php
    $message = "";
    $users = get_all_users($pdo);
    $my_id = $_SESSION['user_id'];

    foreach ($users as $user) {
        if ($user['id'] == $my_id) {
            if ($user['tipo'] == 0) {
                $nome = $user['nome'];
                $email = $user['email'];
            }
        }
    }
    if (isset($_POST['submit'])) {
        $password = $_POST['password'];

        if (!empty($_POST['nome']) && (!empty($_POST['email'])) && (!empty($_POST['password']))) {
            if ($_POST['password'] == $_POST['password2']) {
                $password = sha1($password);
                $statement = $pdo->prepare("UPDATE users set nome=:nome, email=:email,password=:password where id=:id");
                $statement->bindParam(':nome', $nome);
                $statement->bindParam(':email', $email);
                $statement->bindParam(':password', $password);
                $statement->bindParam(':id', $my_id);
                $statement->execute();
                header("location: questionariosAtivos.html");

            } else {
                $message = "Password nao coincidem";
            }
        } else {
            $message = "Os campos nao podem estar vazis";
        }
    }
    ?>
    <?php
    if ($message != "") {
        echo "<div class='box'>$message</div>";
    }
    ?>
    <html>
    <body>

    <form action="" method="post">
        Nome:<br/>
        <input type="text" name="nome" value="<?php echo "$nome"; ?>">
        <br/><br/>
        Email:<br/>
        <input type="email" name="email" value="<?php echo "$email"; ?>">
        <br/><br/>
        Password:<br/>
        <input type="password" name="password">
        <br/><br/>
        Comfirmar Password:<br/>
        <input type="password" name="password2">
        <br/><br/>
        <input type='submit' style="background: #3366ff" name='submit' value='Guardar'>  <?php echo "<a href='index.php' class='box'>Voltar</a>"; ?>
    </form>
    </body>
</div>
</body>
</html>