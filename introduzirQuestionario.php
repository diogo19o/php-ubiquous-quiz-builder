<html>
<head>
    <title>Introduzir Questionário</title>
    <link rel='stylesheet' href='style.css'/>
    <script language="JavaScript" type="text/javascript">
        <meta charset=utf-8">
        function checkDelete() {
            return confirm('Tem a certeza que quer apagar este questionário?');
        }
    </script>
    <head>
<body>
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
    <h1>Introduza as Seguites Informações:<br></h1>
    <?php
    $message = "";
    $my_id = $_SESSION['user_id'];
    $modo = $_GET['modo'];
    if ($modo == "contra_relogio") {
        echo "<h2>Modo: Contra Relógio</h2>";
    } else if ($modo == "morte_subita") {
        echo "<h2>Modo: Morte Súbita</h2>";
    } else if ($modo == "questionario") {
        echo "<h2>Modo: Questionário</h2>";
    } else if ($modo == "classico") {
        echo "<h2>Modo: Clássico</h2>";
    }
    ?>
    <form action="" method="post">
        Acesso:<br/>
        <p>
            <select name="acesso">
                <option value="publico">Publico</option>
                <option value="privado">Privado</option>
            </select>
        </p>
        Título:<br/>
        <input type="text" name="titulo" autocomplete="off">
        <br/><br/>
        Descrição:<br/>
        <input type="text" name="descricao" autocomplete="off">
        <br/><br/><?php
        if ($modo == "contra_relogio") {
            ?>
            Tempo total do Questionario :<br/><br>
            Minutos:
            <input type="text" name="timer" size="1" value="0" class="tempo">
            Segundos:
            <input type="text" name="timer1" size="1" value="0" class="tempo">
            <br/><br/>
            <?php
        } else {
            ?>
            Tempo por pergunta (pode ficar nulo no Modo Questionario):<br/><br>
            Minutos:
            <input type="text" name="timer" size="1" value="0" class="tempo">
            Segundos:
            <input type="text" name="timer1" size="1" value="0" class="tempo">
            <br/><br/>
            <?php
        }
        ?>
        Dificuldade:<br/>
        <p>
            <select name="dificuldade">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </p>
        <input type='submit' name='submit' style="background: #3366ff" value='Inserir'>
    </form>
    <?php
    $questionarios = get_all_questionarios($pdo);
    $existe = 0;
    if (isset($_POST['submit'])) {
        if (!empty($_POST['titulo']) && !empty($_POST['descricao'])) {
            $aux = $_POST['timer'];
            $aux1 = $_POST['timer1'];
            if ($aux >= 0 && $aux < 60 && $aux1 < 60 && $aux1 >=0) {
                foreach ($questionarios as $questionario) {
                    if (($_POST['titulo']) == ($questionario['Titulo'])) {
                        $message = "Já exsite um questionario registado com esse titulo";
                        $existe = 1;
                    }
                }
                if ($existe != 1) {
                    $timer = $_POST['timer'];
                    $timer1 = $_POST['timer1'];
                    $timerfinal = $timer.":".$timer1;
                    if ($modo != "questionario" && (empty($timer)) && (empty($timer1))) {
                        $message = "O Tempo por pergunta nao pode ser nulo";
                    } else {
                        $id = sizeof($questionarios) + 1;
                        //$estado = "rascunho";
                        $data = date('Y-m-d');
                        $statement = $pdo->prepare("INSERT INTO questionario VALUES(:id, :userid, :modo,:titulo,:descricao,:data,:acesso,:dificuldade,:timer,:timer1)");
                        $statement->bindParam(':id', $id);
                        $statement->bindParam(':userid', $my_id);
                        $statement->bindParam(':modo', $modo);
                        $statement->bindParam(':titulo', $_POST['titulo']);
                        $statement->bindParam(':descricao', $_POST['descricao']);
                        $statement->bindParam(':data', $data);
                        $statement->bindParam(':acesso', $_POST['acesso']);
                        $statement->bindParam(':dificuldade', $_POST['dificuldade']);
                        $statement->bindParam(':timer', $aux);
                        $statement->bindParam(':timer1', $aux1);
                        $statement->execute();
                        $message = "Questionario inserido com sucesso";
                        header("location: adicionarPergunta.php?questionario=" . $id);
                    }
                }
            } else {
                $message = "Tempo inválido";
            }
        } else {
            $message = "Por favor preencha todos os campos";
        }
    }
    if ($message != '') {
        echo "<div class='erro'>$message</div>";
    }
    ?>
    <br><a href='introduzirQuestionarioModo.php' class='box'>Voltar</a>
</div>
</body>
</html>