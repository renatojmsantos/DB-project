<?php
    session_start();
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
    {
        header('Location: user_main_page.php');
        exit();
	}
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Login</title>
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

	      <?php if (isset($_SESSION['logged'])) : ?>
	       <li class="nav-item">
	        <a class="nav-link" href="myteams.php">Minhas equipas</a>
	      </li>

	       <li class="nav-item">
	        <a class="nav-link" href="mytournaments">Meus torneios</a>
	      </li>

	       <li class="nav-item">
	        <a class="nav-link" href="#">Mensagens</a>
	      </li>
	  	<?php endif; ?>
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
	
	<center style="color:white"><b>Login</b><br /><br /></center>
	
	<form action="logging_to_account.php" method="post">
	
		<center>Login: <br /> <input type="text" name="input_user_login" align = "center"/> <br /></center>
		<center>Password: <br /> <input type="password" name="input_user_password" align="center" /> 
		
		<br/><br/></center>
		<center><input type="submit" value="Log in" align="center" /></center>
	
	</form>
	<center>
	<?php
    if(isset($_SESSION['error_log']))
	{
		echo '</br>';
		echo $_SESSION['error_log'];
		unset($_SESSION['error_log']);
	}
	?>
	</center> 
	</br>
	
	<center><a href="register.php" >Sign in - Create free account!</a>
	<br /><br /></center>
	<center><a href="index.php" >Back to main</a></center>


</body>
</html>