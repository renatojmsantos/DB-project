<?php

	session_start();
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: mytournaments.php');
		exit();
	}

	   require_once "connect.php";
        
        
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno != 0)
		{
			throw new Exception(mysqli_connect_errno());
		}        
        
	if (isset($_POST['input']))
		$input = $_POST['input'];
	else
		$input = '';	
	   

	$torneio = $_GET['torneioID'];
	$torneio = str_replace('%20', '', $torneio);


	$query ="DELETE FROM tournament_field WHERE tournament_name = '$torneio' ";
    $result = $connection->query($query);
    $query ="DELETE FROM schedule WHERE tournament_name = '$torneio' ";
	$result = $connection->query($query);
    $query ="DELETE FROM tournament WHERE name = '$torneio' ";
    $result = $connection->query($query);

    header('Location: mytournaments.php');
    exit();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Apagar Torneio</title>
</head>

<body>

</body>
    