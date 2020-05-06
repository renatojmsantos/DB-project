<?php

	session_start();
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: browseT.php');
		exit();
	}

	require_once "connect.php";
	 
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0)
	{
		throw new Exception(mysqli_connect_errno());
	}        
        	
	//$entry = "UPDATE user SET username = '".$_POST['username']."' WHERE team_id = '".$_POST['equipaID']."'";
	/*
	if($sql = $connection->query("SELECT * FROM team_tatica WHERE id = '$equipaID'")){
		$team = $sql->fetch_assoc();
		$teamNAME = $team['name'];
		$tatica_atacante = $team['tatica_atacante'];
		$tatica_medio = $team['tatica_medio'];
		$tatica_defesa = $team['tatica_defesa'];
		$capitaoCC = $team['user_cc'];
	}

	$_SESSION['user_cc'];
	$_SESSION['user_posicao'];
	*/

	$posicao =  $_SESSION['user_posicao'];
	$cc = $_SESSION['user_cc'];

	$nomeTorneio = $_POST['torneioName'];

	$equipa = $connection->query("SELECT * FROM team_tatica WHERE user_cc = '$cc'");
	while ($row = $equipa->fetch_assoc()){
		$nomeEquipa = $row['name'];
	 	$id = $row['id'];
	 	$pedido = $row['pedidoaceite'];
	 	$tatica_atacante = $row['tatica_atacante'];
	 	$tatica_medio = $row['tatica_medio'];
	 	$tatica_defesa = $row['tatica_defesa'];
	 	$ccartao = $row['user_cc'];
	}

	$entry = "INSERT INTO team_tatica VALUES('$nomeEquipa',NULL, '$pedido','$tatica_atacante','$tatica_medio','$tatica_defesa','$ccartao','$nomeTorneio') ";
    $join = $connection->query($entry);

	header('Location: browseT.php');
    exit();
?>


