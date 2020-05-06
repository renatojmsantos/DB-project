<?php

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

	session_start();
	
	if (isset($_POST['email']))
	{
		//validation flag
		$flag_everything_OK = true;

		//check username
		$username = $_POST['username'];
		
		//length of username
		if ((strlen($username)<4) || (strlen($username)>20))
		{
			$flag_everything_OK = false;
			$_SESSION['e_username'] = "Username under 4 or over 20 characters!";
		}
		
		if (ctype_alnum($username) == false)
		{
			$flag_everything_OK = false;
			$_SESSION['e_username'] = "Username has to consist of only letters and numbers!";
		}

		//check password
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1)<4) || (strlen($password1)>20))
		{
			$flag_everything_OK = false;
			$_SESSION['e_password'] = "Password under 4 or over 20 characters!";
		}
		
		if ($password1 != $password2)
		{
			$flag_everything_OK = false;
			$_SESSION['e_pass'] = "Passwords are different!";
		}	
	
		//$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		$password_hash = $password1;


		//check email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB!=$email))
		{
			$flag_everything_OK = false;
			$_SESSION['e_email'] = "Incorrect email address!";
		}

		//check name
		$name = $_POST['name'];
		if ((strlen($name)<1))
		{
			$flag_everything_OK = false;
			$_SESSION['e_name'] = "Name field cannot be empty!";
		}

		//check surname
		$surname = $_POST['surname'];
		if ((strlen($surname)<1))
		{
			$flag_everything_OK = false;
			$_SESSION['e_surname'] = "Surname field cannot be empty!";
		}
		
		// check CC
		$cc = $_POST['cc'];
		if ((strlen($cc)<1))
		{
			$flag_everything_OK = false;
			$_SESSION['e_cc'] = "Numero de cartao de cidadão tem de ser preenchido!";
		}

		//check telefone
		$telefone = $_POST['telefone'];
		if ((strlen($telefone)<1))
		{
			$flag_everything_OK = false;
			$_SESSION['e_telefone'] = "You need a phone number!";
		}

		// check posicao preferida
		//$posicao_favorita = $_POST['posicao_favorita'];
		
		//(isset($_POST["posicao_favorita"])) ? $posicao_favorita = $_POST["posicao_favorita"] : $posicao_favorita=1;


		
		$posicao = $_POST['posicao'];
		//if(isset($_POST['posicao'])){
    	//	$posicao=$_POST['posicao'];
    	//}

		//check if terms accepted
		if (!isset($_POST['terms']))
		{
			$flag_everything_OK  = false;
			$_SESSION['e_terms'] = "You have to accept terms and conditions!";
		}
		

		//save insterted data
		$_SESSION['input_username'] = $username;
		$_SESSION['input_password1'] = $password1;
		$_SESSION['input_password2'] = $password2;
		$_SESSION['input_email'] = $email;
		$_SESSION['input_name'] = $name;
		$_SESSION['input_surname'] = $surname;
		$_SESSION['input_cc'] = $cc;
		$_SESSION['input_telefone'] = $telefone;
		//$_SESSION['input_posicao'] = $posicao;

		if (isset($_POST['terms'])) $_SESSION['input_terms'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		console_log( $flag_everything_OK );

		try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//check if email exists
				$result = $connection->query("SELECT username FROM user WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
				
				$count_emails = $result->num_rows;
				if($count_emails > 0)
				{
					$flag_everything_OK = false;
					$_SESSION['e_email'] = "Account with this email already exists!";
				}		

				//check if login taken
				$result = $connection->query("SELECT username FROM user WHERE username='$username'");
				
				if (!$result) throw new Exception($connection->error);
				
				$count_usernames = $result->num_rows;
				if($count_usernames > 0)
				{
					$flag_everything_OK = false;
					$_SESSION['e_username']="Login already exists. Pick another one!";
				}
				
				console_log( $flag_everything_OK );
				
				if ($flag_everything_OK == true)
				{
					//Add to database
										
					$sql="INSERT INTO user VALUES('$cc', '$username', FALSE, '$password_hash', '$name', '$surname', '$telefone', '$email', 0, FALSE)";
					console_log( $sql );					

					$sql = "INSERT INTO posicaopreferida VALUES('$posicao','$cc')";
					console_log( $sql );					
					
					
					if ($connection->query("INSERT INTO user VALUES('$cc', '$username', FALSE, '$password_hash', '$name', '$surname', '$telefone', '$email', 0, FALSE)") && $connection->query("INSERT INTO posicaopreferida VALUES('$posicao','$cc')"))
					{
						$_SESSION['registration_success'] = true;
						header('Location: welcome.php');
						//echo $nick." ".$haslo_hash;
						//die();
					}
					else
					{
						throw new Exception($connection->error);
					}

				
				}
				
				$connection->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server error! Try later</span>';
			echo '<br />Developer info: '.$e;
		}
		
	}
	
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Registo</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<!-- BOOTSTRAP -->

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link href ="navbar.css" rel = "stylesheet" type = "text/css">

	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>


	<!-- MENU -->
	<nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color: #e9e9e9;">
	  <a class="navbar-brand" href="index.php">BD 2019/20</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">

	      <li class="nav-item dropdown">
	      	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          Procurar
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="browse.php">Procurar torneio</a>
	          <a class="dropdown-item" href="browse.php">Procurar equipa</a>
	        </div>
	      </li>

	      <li class="nav-item">
	        <a class="nav-link" href="#">Perfil</a>
	      </li>

	       <li class="nav-item">
	        <a class="nav-link" href="#">Minhas equipas</a>
	      </li>

	       <li class="nav-item">
	        <a class="nav-link" href="#">Meus torneios</a>
	      </li>

	       <li class="nav-item">
	        <a class="nav-link" href="#">Mensagens</a>
	      </li>
	    </ul>
	    <!--
	    <form class="form-inline my-2 my-lg-0">
	        <a class="nav-link" href="register.php">Registar</a>
	        <a class="nav-link" href="login.php">Login</a>
	    </form> -->

	    <div class="form-inline my-2 my-lg-0">
		    <form action="login.php">
		      <input type="text" name="input_user_login" placeholder="Username">
		      <input type="password" name="input_user_password" placeholder="Password">
		      <button type="submit">Login</button>
		    </form>
		    <form action="register.php">
		      <button type="submit">Register</button>
		    </form>
	  	</div>
	  </div>
	</nav>
  </form>
 
</head>


<body>
	<br /><br />
	<center style="color: white"><h2><b>Register</b></h2><br/></center>
	<center>
		<form method="post" style="color: white">
			Username: <br /> <input type="text" value="<?php
			if (isset($_SESSION['input_username']))
			{
				echo $_SESSION['input_username'];
				unset($_SESSION['input_username']);
			}
		?>" name="username" /><br />
		<?php
			if (isset($_SESSION['e_username']))
			{
				echo '<div class="error">'.$_SESSION['e_username'].'</div>';
				unset($_SESSION['e_username']);
			}
		?>

		Your password: <br /> <input type="password"  value="<?php
			if (isset($_SESSION['input_password1']))
			{
				echo $_SESSION['input_password1'];
				unset($_SESSION['input_password1']);
			}
		?>" name="password1" /><br />
		
		<?php
			if (isset($_SESSION['e_password1']))
			{
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
		?>		
		
		Repeat password: <br /> <input type="password" value="<?php
			if (isset($_SESSION['input_password2']))
			{
				echo $_SESSION['input_password2'];
				unset($_SESSION['input_password2']);
			}
		?>" name="password2" /><br />

		
		E-mail: <br /> <input type="text" value="<?php
			if (isset($_SESSION['input_email']))
			{
				echo $_SESSION['input_email'];
				unset($_SESSION['input_email']);
			}
		?>" name="email" /><br />
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		
		Nome: <br /> <input type="text" value="<?php
			if (isset($_SESSION['input_name']))
			{
				echo $_SESSION['input_name'];
				unset($_SESSION['input_name']);
			}
		?>" name="name" /><br />
		<?php
			if (isset($_SESSION['e_name']))
			{
				echo '<div class="error">'.$_SESSION['e_name'].'</div>';
				unset($_SESSION['e_name']);
			}
		?>
		
		Apelido: <br /> <input type="text" value="<?php
			if (isset($_SESSION['input_surname']))
			{
				echo $_SESSION['input_surname'];
				unset($_SESSION['input_surname']);
			}
		?>" name="surname" /><br />
		<?php
			if (isset($_SESSION['e_surname']))
			{
				echo '<div class="error">'.$_SESSION['e_surname'].'</div>';
				unset($_SESSION['e_surname']);
			}
		?>


		Cartão de cidadão: <br /> <input type="text" value="<?php
			if (isset($_SESSION['input_cc']))
			{
				echo $_SESSION['input_cc'];
				unset($_SESSION['input_cc']);
			}
		?>" name="cc" /><br />
		<?php
			if (isset($_SESSION['e_cc']))
			{
				echo '<div class="error">'.$_SESSION['e_cc'].'</div>';
				unset($_SESSION['e_cc']);
			}
		?>
		
		Telefone: <br /> <input type="text" value="<?php
			if (isset($_SESSION['input_telefone']))
			{
				echo $_SESSION['input_telefone'];
				unset($_SESSION['input_telefone']);
			}
		?>" name="telefone" /><br />
		<?php
			if (isset($_SESSION['e_telefone']))
			{
				echo '<div class="error">'.$_SESSION['e_telefone'].'</div>';
				unset($_SESSION['e_telefone']);
			}
		?>
	
		Posição preferida: <br />
		  <select name="posicao" >
		    <option value="Guarda-Redes" >Guarda-Redes</option>
			<option value="Defesa" >Defesa</option>
		    <option value="Médio" >Médio</option>
		    <option value="Avançado" >Avançado</option>>
		  </select>  

		<br>

		<label><br>
			<input type="checkbox" name="terms" <?php
			if (isset($_SESSION['input_terms']))
			{
				echo "checked";
				unset($_SESSION['input_terms']);
			}
				?>/> I accept <a href="terms_and_conditions.txt" onClick="MyWindow=window.open('terms_and_conditions.txt','Termos','width=600,height=300'); return false;"> terms and conditions </a> of platform<br />
				
		</label>
		<br />
		<?php
			if (isset($_SESSION['e_terms']))
			{
				echo '<div class="error">'.$_SESSION['e_terms'].'</div>';
				unset($_SESSION['e_terms']);
			}
		?>	
		<br />
		

		<br />
		
		<input type="submit" value="Sign in" />
		
	</form></center>
	<br><br/>
	
	<center><form action="index.php">
    		<input type="submit" value="back to HOME" />
			</form>
	</center>
	</br></br>
</body>
</html>