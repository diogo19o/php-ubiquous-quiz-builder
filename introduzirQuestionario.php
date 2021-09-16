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
    $message = "";    
    $my_id = $_SESSION['user_id'];
    $modo = $_GET['modo'];
        $questionarios = get_all_questionarios($pdo);
        $existe = 0;
        if (isset($_POST['submit'])) {
            $modo = $_GET['modo'];
            if ($modo != "questionario"){
                if (!empty($_POST['titulo']) && !empty($_POST['descricao'])) {
                    $timer = $_POST['timer'];
                    $timer1 = $_POST['timer1'];
                    if ($timer >= 0 && $timer < 60 && $timer1 < 60 && $timer1 >=0) {
                        foreach ($questionarios as $questionario) {
                            if (($_POST['titulo']) == ($questionario['Titulo'])) {
                                $message = "Já exsite um questionario registado com esse titulo";
                                $existe = 1;
                            }
                        }
                        if ($existe != 1) {
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
                                $statement->bindParam(':timer', $timer);
                                $statement->bindParam(':timer1', $timer1);
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
            } else {
                if (!empty($_POST['titulo']) && !empty($_POST['descricao'])) {

                        foreach ($questionarios as $questionario) {
                            if (($_POST['titulo']) == ($questionario['Titulo'])) {
                                $message = "Já exsite um questionario registado com esse titulo";
                                $existe = 1;
                            }
                        }

                        if ($existe != 1) {
                                $id = sizeof($questionarios) + 1;
                                //$estado = "rascunho";
                    
                                $dificuldade = "1";
                                $timer = 0;
                                $timer1 = 0;

                                $data = date('Y-m-d');
                                $statement = $pdo->prepare("INSERT INTO questionario VALUES(:id, :userid, :modo,:titulo,:descricao,:data,:acesso,:dificuldade,:timer,:timer1)");
                                $statement->bindParam(':id', $id);
                                $statement->bindParam(':userid', $my_id);
                                $statement->bindParam(':modo', $modo);
                                $statement->bindParam(':titulo', $_POST['titulo']);
                                $statement->bindParam(':descricao', $_POST['descricao']);
                                $statement->bindParam(':data', $data);
                                $statement->bindParam(':acesso', $_POST['acesso']);
                                $statement->bindParam(':dificuldade', $dificuldade);
                                $statement->bindParam(':timer', $timer);
                                $statement->bindParam(':timer1', $timer1);
                                $statement->execute();
                                $message = "Questionario inserido com sucesso";
                                header("location: adicionarPergunta.php?questionario=" . $id);
                        }else{
                            $message = "Por favor preencha todos os campos";
                        }
                } else {
                    $message = "Por favor preencha todos os campos";
                }
            }
            
        }
        if ($message != '') {
            echo "<br><br><div class='erro'>$message</div>";
        }
        ?>
    <div class='container'>
        <h1>Introduza as Seguites Informações:<br></h1>
        <?php
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
            <input type="text" name="titulo" size="33" value="<?php echo isset($_POST['titulo']) ? $_POST['titulo'] : ''; ?>" autocomplete="off" class="claro">
            
            <br/><br/>
            Descrição:<br/>
            <textarea name="descricao" class="caixa_descricao" rows="3" cols="35"><?php if(isset($_POST['descricao'])) {echo htmlentities($_POST['descricao']);}?></textarea>
            <br/><br/><?php
            if ($modo == "contra_relogio") {
            ?>
                Tempo total do questionário :<br/><br>
            <?php
            } else if ($modo != "questionario"){
            ?>
                Tempo por pergunta:<br/><br>
            <?php
            }
            
            if($modo != "questionario"){?>
            Minutos:
            <input type="text" name="timer" size="1" value="<?php echo isset($_POST['timer']) ? $_POST['timer'] : '0'; ?>" class="tempo">
            Segundos:
            <input type="text" name="timer1" size="1" value="<?php echo isset($_POST['timer1']) ? $_POST['timer1'] : '0'; ?>" class="tempo">
            <br/><br/>
            Dificuldade:<br/>
            <p>
                <select name="dificuldade">
                <?php
                    if(!isset($_POST['dificuldade']) || $_POST['dificuldade'] == '1'){
                        ?>
                        <option  selected="true" value="1">1</option>
                        <option  value="2">2</option>
                        <option  value="3">3</option>
                        <?php
                    }else if($_POST['dificuldade'] == '2'){
                        ?>
                        <option value="1">1</option>
                        <option  selected="true" value="2">2</option>
                        <option  value="3">3</option>
                        <?php
                    }else{
                        ?>
                        <option  value="1">1</option>
                        <option  value="2">2</option>
                        <option  selected="true" value="3">3</option>
                        <?php
                    }
                ?>
                </select>
                <script type="text/javascript">document.getElementById('dificuldade').value = "<?php echo $_POST['dificuldade'];?>";</script>
            </p>
            <?php
            }
            ?>
            <input type='submit' name='submit' style="background: #3366ff" value='Inserir'>
        </form>
        <br><a href='introduzirQuestionarioModo.php' class='box'>Voltar</a>
    </div>
</body>
</html>