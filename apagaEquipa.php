<?php

	session_start();
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: myteams.php');
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
	   
    $query ="DELETE FROM team_tatica where id=".$_GET['equipaID'];
    $result = $connection->query($query);

    header('Location: myteams.php');
    exit();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Apagar Equipa</title>
</head>

<body>

</body>
    