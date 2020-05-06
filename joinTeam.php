<?php

	session_start();
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: browseTeam.php');
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
	$teamID = $_POST['equipaID'];
	$cc = $_SESSION['user_cc'];

	$entry = "INSERT INTO role_in_team VALUES('$posicao', 2, 50, TRUE, '$teamID', '$cc') ";
    $join = $connection->query($entry);

	header('Location: browseTeam.php');
    exit();
?>


