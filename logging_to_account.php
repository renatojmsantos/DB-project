<?php

	session_start();
	
	if((!isset($_POST['input_user_login']))||(!isset($_POST['input_user_password'])))
	{
		header('Location: login.php');
		exit();
	}
	
	require_once "connect.php";
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$login = $_POST['input_user_login'];
		$pass = $_POST['input_user_password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($result= @$connection->query(
			sprintf("select * from user where username='%s' AND password = '%s'" , mysqli_real_escape_string($connection,$login),mysqli_real_escape_string($connection,$pass))))
		{
			$count_users = $result->num_rows;
			if($count_users>0)
			{
				$row = $result->fetch_assoc();
				
				//if (password_verify($pass, $row['password']))
				
					$_SESSION['logged'] = true;
					$_SESSION['user_login'] = $row['username'];
					$_SESSION['admin'] = $row['isadmin'];
					$_SESSION['user_name'] = $row['fname'];
					$_SESSION['user_surname'] = $row['lname'];
					$_SESSION['user_email'] = $row['email'];
					$_SESSION['user_cc'] = $row['cc'];
					$_SESSION['user_telefone'] = $row['telefone'];


					$nr = $_SESSION['user_cc'];
					//echo $nr;
					if($pos = $connection->query("SELECT * FROM posicaopreferida WHERE user_cc = $nr")){
						$p = $pos->fetch_assoc();
							$_SESSION['user_posicao'] = $p['posicao'];
					}

					unset($_SESSION['error_log']);
					$result->free_result();
					header('Location: user_main_page.php');
			} 
			else
			{
				$_SESSION['error_log'] = '<span style="color:red">Wrong login or username!</span>';
				header('Location: login.php');	
			}
		}
		else
		{
			$_SESSION['error_log'] = '<span style="color:red">no user</span>';
			header('Location: login.php');
		}
	
		$connection->close();
	}

	
?>