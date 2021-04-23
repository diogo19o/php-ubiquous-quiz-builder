<html>
<head>
    <title>Estatisticas</title>
    <link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
    <script>
        function myFunction(radio) {
            var table, tr, i,td , j, cnt, mapa;
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            mapa = new Map();
            if (radio.value == 2) {
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td");
                    if(!mapa.has(td[0].innerHTML)) {
                        mapa.set(td[0].innerHTML, td[5].innerHTML);
                        //tr[i].style.display = "";
                    }else if((parseInt(td[5].innerHTML)) > parseInt(mapa.get(td[0].innerHTML))){
                        mapa.set(td[0].innerHTML,td[5].innerHTML);
                    }
                }
               // window.alert("aqui4");
                for (j = 0; j < tr.length; j++) {
                    td = tr[j].getElementsByTagName("td");
                    //window.alert("aqui3");
                    if(j===0){
                        tr[j].style.display = "";
                    }
                    else
                    {
                        if((parseInt(td[5].innerHTML)) === parseInt(mapa.get(td[0].innerHTML))){
                            tr[j].style.display = "";
                            //window.alert("aqui");
                        }else {
                            // window.alert("aqui2");
                            tr[j].style.display = "none";
                        }
                    }
                }
            } else {
                for (i = 0; i < tr.length; i++) {
                    tr[i].style.display = "";
                }
            }
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
    <?php
    $users = get_all_users($pdo);
    $resultados = get_all_resultados($pdo);
    $questionarios = get_all_questionarios($pdo);
    if (isset($_GET['user']) && !empty($_GET['user'])) {
        $userid = $_GET['user'];
    } else {
        $userid = $_SESSION['user_id'];
    }//ver se no link esta o id da pessoa de que se esta a ver as estatiticas(se formos admin) ou se nao (se formos user) o que so nos elva para as nossas estatisticas

    $my_id = $_SESSION["user_id"];
    foreach ($users as $user) {
        if ($user["tipo"] == 1) {
            $utilizador = $user;
        }
    }

    $respondidos = 0;
    foreach ($resultados as $resultado) {
        if ($userid == $resultado["UtilizadorID"]) {
            $respondidos = $respondidos + 1;
        }
    }
    echo "<h1>Qustionários Respondidos: $respondidos</h1>";
    $certas = 0;
    $erradas = 0;
    echo "<h1>Estatísticas dos Seus questionários: </h1>";
    ?>
    <label for="button one"><input onclick="myFunction(this)" type="radio" name="radio" id="r1" value="1"
                                   checked="true"/> Todos</label> <br>
    <label for="button one"><input onclick="myFunction(this)" type="radio" name="radio" id="r2" value="2"/> Melhores por
        Questionário</label>
    <br>
    <table style="margin-top: 15px" border="1" id="myTable">
        <tr>
            <td align="middle" width="250" style="font-weight: bold">Nome Questionário</td>
            <td align="middle" width="150" style="font-weight: bold" >Modo Jogo</td>
            <td align="middle" width="175" style="font-weight: bold">Respostas Certas</td>
            <td align="middle" width="175" style="font-weight: bold">Respostas Erradas</td>
            <td align="middle" width="150" style="font-weight: bold">Percentagem das Respostas</td>
            <td align="middle" width="150" style="font-weight: bold">Pontuação</td>
            <td align="middle" width="150" style="font-weight: bold">Data</td>
        </tr>
        <?php
        foreach ($resultados as $resultado) {
            if ($userid == $resultado["UtilizadorID"]) {
                $certas = $resultado["RespostasCertas"];
                $erradas = $resultado["RespostasErradas"];
                $nome = "";
                foreach ($questionarios as $questionario) {
                    if ($resultado["QuestionarioID"] == $questionario["QuestionarioID"]) {
                        $nome = $questionario["Titulo"];
                    }
                }
                $modo="";
                if($resultado["Modo"]=="questionario"){
                    $modo="Questionário";
                }else  if($resultado["Modo"]=="classico"){
                    $modo="Clássico";
                }else  if($resultado["Modo"]=="contra_relogio"){
                    $modo="Contra Relógio";
                }else {
                    $modo="Morte Súbita";
                }
                $percentagem = number_format(($certas / ($certas + $erradas)) * 100, 2, '.', '');
                ?>
                <tr>
                    <td align="middle" width="250"><?php echo $nome ?></td>
                    <td align="middle" width="150"><?php echo $modo ?></td>
                    <td align="middle" width="175"><?php echo $certas ?></td>
                    <td align="middle" width="175"><?php echo $erradas ?></td>
                    <td align="middle" width="150"><?php echo $percentagem ?>%</td>
                    <td align="middle" width="150"><?php echo $resultado['Score'] ?></td>
                    <td align="middle" width="150"><?php echo $resultado['DataDePreenchimento'] ?></td>
                </tr>
                <?php
            }
        }
        ?></table>
    </br><br>
    <?php
    echo "<a href='questionariosAtivos.php' class='box' >Voltar</a>";
    ?>
</div>
</body>
</html>