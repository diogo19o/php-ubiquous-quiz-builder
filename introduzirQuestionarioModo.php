<html>
<head>
    <title>Introduzir Questionário</title>
    <link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
    <script language="JavaScript" type="text/javascript">
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
    <h1>Introduzir Questionário:</h1>
    <?php
        if(isset($_POST['submit']))
        {
            $modo = $_POST['modo'];
            print($modo);
            header('location: introduzirQuestionario.php?modo='.$modo);
        }
    ?>
    <form action="" method="post">
        <h2>Modo de Jogo:</h2>
        <p>
            <select name="modo">
                <option value="questionario">Questionário</option>
                <option value="classico">Clássico</option>
                <option value="contra_relogio">Contra Relógio</option>
                <option value="morte_subita">Morte Súbita</option>
            </select>
        </p>
        <input type='submit' name='submit' value='Escolher Modo de Jogo' class="boxBom" style="width: 9%">
    </form>
    <a href='questionariosAtivos.php' class='box'>Voltar</a>
</div>
</body>
</html>