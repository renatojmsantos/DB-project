<?php
session_start();
if (!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
	}


	 require_once "connect.php";
        
        
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0)
	{
		throw new Exception(mysqli_connect_errno());
	}        
        	

    $query ="select * from user where cc=".$_SESSION['user_cc'];

  //   echo "<script type='text/javascript'>alert('$query');</script>"; 

    $result = $connection->query($query);

              $row = mysqli_fetch_assoc($result);
         
		      $cc = $row['cc'];
		      $username = $row['username'];
		      $password = $row['password'];
	          $fname = $row['fname'];
	          $lname = $row['lname'];
	          $telefone = $row['telefone'];
	          $email = $row['email'];


          $nr = $cc;
          //echo $nr;
          if($pos = $connection->query("SELECT * FROM posicaopreferida WHERE user_cc = $nr")){
            $p = $pos->fetch_assoc();
              $posicao = $p['posicao'];
          }


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>BD 2019/20</title>
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
	        <a class="nav-link" href="mytournaments.php">Meus torneios</a>
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

    
	    <li class="form-inline mx-4 my-lg-0 nav-item dropdown" >
	  	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	      <?php echo $_SESSION['user_login']; ?>
	    </a>
	    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	      <a class="dropdown-item" href="user_account.php">User account</a>
	      <a class="dropdown-item" href="logout.php">Logout</a>
	    </div>
      	</li>
	  	

	  </div>
	</nav>
  </form>

  <script type="text/javascript">
	function editUSER() {

		userID=document.getElementById("cc").innerHTML;
		//alert("userID:" +  userID); 

		str=location.href;

		var editPage = str.replace("user_account.php", "insertEdit.php?userID="+userID);   
		location.replace(editPage);
	}
  </script>

</head>


<body>
	<br /><br />
	<br /><br />
	<center style= "color:white"> 
		<b>
		<div id = "detalhesUSER">

			<?php 
			//$_SESSION['user_name'];
			?>


			Username: <?php echo $username; ?> </b> <br>

			Name: <?php echo $fname; echo " "; echo $lname?> <br>

			Your email: 
			<?php echo $email;?> <br>

			Numero cartao cidadao: <div id="cc">
			<?php echo $_SESSION['user_cc'];?> </div><br>

			Telefone: 
			<?php echo $telefone;?> <br>


			Posição favorita: 
			<?php 
				echo $posicao; 
			?>
			<br><br>
			<input type="submit" value="Editar" onclick="editUSER()">
		</div>



	</center>
	<br />

	<center>
		<form action="index.php">
		<button type="submit">Home</button>
		</form>
	</center>

	<br />

</body>
</html>