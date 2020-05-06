<?php

	session_start();
	
	if (!isset($_SESSION['registration_success']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['registration_success']);
	}

		$_SESSION['input_username'] = $username;
		$_SESSION['input_password1'] = $password1;
		$_SESSION['input_password2'] = $password2;
		$_SESSION['input_email'] = $email;
		$_SESSION['input_name'] = $name;
		$_SESSION['input_surname'] = $surname;
		$_SESSION['input_cc'] = $cc;
		$_SESSION['input_telefone'] = $telefone;
		$_SESSION['input_posicao_favorita'] = $posicao_favorita;



	if (isset($_SESSION['input_username'])) unset($_SESSION['input_username']);
	if (isset($_SESSION['input_email'])) unset($_SESSION['input_email']);
	if (isset($_SESSION['input_password1'])) unset($_SESSION['input_password1']);
	if (isset($_SESSION['input_password2'])) unset($_SESSION['input_password2']);
	if (isset($_SESSION['input_name'])) unset($_SESSION['input_name']);
	if (isset($_SESSION['input_surname'])) unset($_SESSION['input_surname']);
	if (isset($_SESSION['input_terms'])) unset($_SESSION['input_terms']);
	if (isset($_SESSION['input_cc'])) unset($_SESSION['input_cc']);
	if (isset($_SESSION['input_telefone'])) unset($_SESSION['input_telefone']);
	if (isset($_SESSION['input_posicao_favorita'])) unset($_SESSION['input_posicao_favorita']);


	

	if (isset($_SESSION['e_surname'])) unset($_SESSION['e_username']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	if (isset($_SESSION['e_name'])) unset($_SESSION['e_name']);
	if (isset($_SESSION['e_surname'])) unset($_SESSION['e_surname']);
	if (isset($_SESSION['e_terms'])) unset($_SESSION['e_terms']);
	if (isset($_SESSION['e_cc'])) unset($_SESSION['e_cc']);
	if (isset($_SESSION['e_telefone'])) unset($_SESSION['e_telefone']);
	//if (isset($_SESSION['e_posicao_favorita'])) unset($_SESSION['e_posicao_favorita']);
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Welcome</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<!-- BOOTSTRAP -->

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link href ="navbar.css" rel = "stylesheet" type = "text/css">

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
	          <a class="dropdown-item" href="browseT.php">Procurar torneio</a>
	          <a class="dropdown-item" href="browseTeam.php">Procurar equipa</a>
	        </div>
	      </li>

	       <li class="nav-item">
	        <a class="nav-link" href="myteams.php">Minhas equipas</a>
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
	<br /><br />
	<center>Obrigado por se registar! Agora pode iniciar sessão!<br/><br/>
	
	<form action="login.php">
	<button type="submit">Log in into your account!</button>
	</form>
	<br /><br /> </center>

</body>
</html>