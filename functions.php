<?php
	
session_start();

function loggedin(){
	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
		return true;
	}else{	
		return false;
	}
}
function get_resultados_by_questionario($pdo,$questionarioID){
    $statement = $pdo->prepare("SELECT * FROM `resultados` WHERE `QuestionarioID` = $questionarioID");
    $statement->execute();
    $seus_resultados = $statement->fetchAll();
    return $seus_resultados;
}
function get_perguntas_by_questionario($pdo,$questionarioID){
    $statement = $pdo->prepare("SELECT * FROM `pergunta` WHERE `QuestionarioID` = $questionarioID order by `PerguntaID`");
    $statement->execute();
    $suas_perguntas = $statement->fetchAll();
    return $suas_perguntas;
}
function get_respostas_by_pergunta($pdo,$perguntaid){
    $statement = $pdo->prepare("SELECT * FROM `resposta` WHERE `PerguntaID` = $perguntaid order by `RespostaID`");
    $statement->execute();
    $suas_respostas = $statement->fetchAll();
    return $suas_respostas;
}
function get_seus_questionarios($pdo, $user_id){
    $statement = $pdo->prepare("SELECT * FROM `questionario` WHERE `UserCriacao` = $user_id order by `QuestionarioID`");
    $statement->execute();
    $seus_questionarios = $statement->fetchAll();
    return $seus_questionarios;
}
function get_all_users($pdo){
	$statement = $pdo->prepare("SELECT * FROM users");
	$statement->execute();
	$all_users = $statement->fetchAll();
	return $all_users;
}

function get_all_resultados($pdo){
	$statement = $pdo->prepare("SELECT * FROM resultados");
	$statement->execute();
	$all_resultados = $statement->fetchAll();
	return $all_resultados;
}

function get_all_questionarios($pdo){
    $statement = $pdo->prepare("SELECT * FROM questionario");
    $statement->execute();
    $all_questionarios = $statement->fetchAll();
    return $all_questionarios;
}

function get_all_perguntas($pdo){
	$statement = $pdo->prepare("SELECT * FROM pergunta");
	$statement->execute();
	$all_perguntas = $statement->fetchAll();
	return $all_perguntas;
}

function get_all_respostas($pdo){
	$statement = $pdo->prepare("SELECT * FROM resposta");
	$statement->execute();
	$all_respostas = $statement->fetchAll();
	return $all_respostas;
}
function create_database_connection(){
	try {
		//local DB WampServer
	    $pdo = new PDO('mysql:host=localhost;dbname=androidquizbuilder', 'root', '');
		//$pdo = new PDO('mysql:host=localhost;dbname=androidquizbuilder', 'root', '');
	    return $pdo;
	} catch (PDOException $e) {
	    print $e->getMessage();
	    return false;
	}
}
