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
        	
	   
    //$sql = "UPDATE user SET fname = 'Renato' where cc='44444444'";
    //$sql = "UPDATE user SET username = '".$_POST['username'].",password = '".$_POST['password']."',telefone = '".$_POST['telefone']."',email = '".$_POST['email']."',fname = '".$_POST['fname']."', lname = '".$_POST['lname']."' WHERE cc = '".$_POST['cc']."'";

	//$sql = "UPDATE user SET fname = '".$_POST['fname']."', lname = '".$_POST['lname']."', telefone = '".$_POST['telefone']."', email = '".$_POST['email']."' WHERE cc = '".$_POST['cc']."'";
	$u = "UPDATE user SET username = '".$_POST['username']."' WHERE cc = '".$_POST['cc']."'";
    $result = $connection->query($u);
    $p = "UPDATE user SET password = '".$_POST['password']."' WHERE cc = '".$_POST['cc']."'";
    $result = $connection->query($p);
    $fn = "UPDATE user SET fname = '".$_POST['fname']."' WHERE cc = '".$_POST['cc']."'";
    $result = $connection->query($fn);
    $ln = "UPDATE user SET lname = '".$_POST['lname']."' WHERE cc = '".$_POST['cc']."'";
    $result = $connection->query($ln);
    $telf = "UPDATE user SET telefone = '".$_POST['telefone']."' WHERE cc = '".$_POST['cc']."'";
    $result = $connection->query($telf);
    $mail = "UPDATE user SET email = '".$_POST['email']."' WHERE cc = '".$_POST['cc']."'";
    $result = $connection->query($mail);

    $pos = "UPDATE posicaopreferida SET posicao = '".$_POST['posicao']."' WHERE user_cc = '".$_POST['cc']."'";
    $result = $connection->query($pos);

	header('Location: user_account.php');
    exit();
?>


