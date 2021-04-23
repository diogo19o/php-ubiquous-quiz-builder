<?php

include("functions.php");

$pdo= create_database_connection();

define("RESULT_SUCCESS", 0);
define("RESULT_ERROR", 1);
define("RESULT_USER_EXISTS", 2);


$action = $_POST["action"];
$result = RESULT_ERROR;

if(isset($action)){
	$username = $_POST["username"];
	
	$pwd = $_POST["password"];
	
	if("add" == $action){
		$email = $_POST["email"];
		if(isExistUser($pdo, $email)){
			$result = RESULT_USER_EXISTS;		
		}else{
			insertUser($pdo, $username,$email, $pwd);
			$result = RESULT_SUCCESS;
		}
	}else if("login" == $action){
		$users=get_all_users($pdo);
		$admin=0;
			foreach($users as $user){
				if($user["nome"]==$username && $user["password"]==$pwd && $user['tipo']==1){
					$admin=1;
				}
			}
			if($admin==1){
				$result= 3;
			}else{
				if(login($pdo, $username, $pwd)){
					$result = RESULT_SUCCESS;
				}else{
					$result = RESULT_ERROR;
				}
			}
	}
}

echo(json_encode(array('result' => $result)));

function insertUser($pdo, $username,$email, $pwd){
	$tipo=0;
	$id=0;
	$statement=$pdo->prepare("INSERT INTO users VALUES(:id,:nome,:email,:password,:tipo)");
		$statement->bindParam(':id',$id);
		$statement->bindParam(':nome',$username);
		$statement->bindParam(':email',$email);
		$statement->bindParam(':password',$pwd);
		$statement->bindParam(':tipo',$tipo);
		$statement->execute();
}

function isExistUser($pdo, $email){
	$users=get_all_users($pdo);
	foreach($users as $user){
		if($user["email"]==$email){
			return 1;
		}
	}
}

function login($pdo, $username, $pwd){
	$users=get_all_users($pdo);

	foreach($users as $user){
		if($user["nome"]==$username && $user["password"]==$pwd){
			return 1;
		}
	}
}
