<?php

	session_start();

 	require_once "connect.php";    

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0){
		throw new Exception(mysqli_connect_errno());
	}        
   
	if (isset($_POST['nomeTorneio'])){

		$nomeTorneio = $_POST['nomeTorneio'];
		$descricao = $_POST['descricao'];
		$dataInicio = $_POST['dataInicio'];
		$dataFim = $_POST['dataFim'];
		$diaSemana = $_POST['diaSemana'];
		$hora = $_POST['hora'];
		$minutos = $_POST['minutos'];
		$campo = $_POST['campo'];
		$taxa = $_POST['taxa'];


		$sql = "INSERT INTO tournament VALUES('$nomeTorneio', '$descricao',STR_TO_DATE('$dataInicio', '%d-%m-%Y'),STR_TO_DATE('$dataFim', '%d-%m-%Y'))";
		//$sql = "INSERT INTO team_tatica VALUES('Braga', NULL, TRUE, '3','3','4','$cc','liga academica')";
		if ($connection->query($sql)){	

		    $f = "INSERT INTO field VALUES('$campo', '$taxa') ";
		    //$joinF = $connection->query($f);
		    if($connection->query($f)){
		    	$fieldT = "INSERT INTO tournament_field VALUES('$nomeTorneio', '$campo') ";
		    	$joinFT =  $connection->query($fieldT);

		    	$horario = "INSERT INTO schedule VALUES('$diaSemana', '$hora','$minutos','$nomeTorneio') ";
		    	$joinH = $connection->query($horario);
		    }
		    
			header('Location: browseT.php');
			//echo $nick." ".$haslo_hash;
			//die();
		}
		else{
			throw new Exception($connection->error);
		}
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


	    <?php session_start(); if (isset($_SESSION['logged'])) : ?>
		    <li class="form-inline mx-4 my-lg-0 nav-item dropdown" >
		  	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		      <?php echo $_SESSION['user_login']; ?>
		    </a>
		    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		      <a class="dropdown-item" href="user_account.php">User account</a>
		      <a class="dropdown-item" href="logout.php">Logout</a>
		    </div>
	      	</li>

		<?php else: ?>
	      	<div class="form-inline my-2 my-lg-0">
			    <form action="logging_to_account.php" method="post">
			      <input type="text" name="input_user_login" placeholder="Username">
			      <input type="password" name="input_user_password" placeholder="Password">
			      <button type="submit" value="Log in" >Login</button>
			      <?php
			    if(isset($_SESSION['error_log']))
				{
					echo '</br>';
					echo $_SESSION['error_log'];
					unset($_SESSION['error_log']);
				}
				?>

			    </form>
			    <form action="register.php">
			      <button type="submit">Register</button>
			    </form>
		  	</div>


	    <?php endif; ?>
	  </div>
	</nav>
  </form>


<style> 
	.myT{
		background-color: gray;
		color: black;
		text-align: center;
		position: absolute; 
		width: 1349px;  
		height: 800px; 
		z-index: 2; 
		left: 40px;
		right: 40px;
		top: 100px;
		margin: 0 auto;
		background-color:rgba(255,255,255,.4);/* modern browser */
		-ms-filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#66FFFFFF,endColorstr=#66FFFFFF);/*IE fix */
		filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#66FFFFFF,endColorstr=#66FFFFFF);     /* IE Fix */
	}


	/* If the screen size is 600px wide or less, set the font-size of <div> to 30px */
	@media screen and (max-width: 800px) {
	  .myT {
	    font-size: 15px;
	    width: 600px;  
		height: 300px; 
		z-index: 2; 
		left: 20px;
		right: 20px;
		top: 100px;
	  }
	}

	.torneios{
		text-align: center;
		margin: 0 auto;
	}

</style>


<script>
	
	function verTorneio(r) {
	  var i = r.parentNode.parentNode.rowIndex;
	  torneioID=document.getElementById("torneios").rows[i].cells[0].innerHTML;
	  //alert("emp:" +  empid); 
	  
	  str=location.href;
	  
	  var editPage = str.replace("browseT.php", "verTorneio.php?torneioID="+torneioID);   
	  location.replace(editPage);
	}

	function apagaTorneio(r){
	    var i = r.parentNode.parentNode.rowIndex;
	    torneioID=document.getElementById("torneios").rows[i].cells[0].innerHTML;   
	    //alert("emp:" +  empid);

	    if (confirm("Apagar torneio?")) {
	        document.getElementById("torneios").deleteRow(i);
			
	 	location.replace("apagaTorneio.php?torneioID="+torneioID);
	        // apaga tb o empregado da BD
	    } else {
	        //alert("I am an alert box!");
	    }    
	}

</script>
</head>

<body>
	<div class="myT"><br>
	<center><h2><b>Criar torneio</b></h2><br/></center>
	<center>
		<form method="post" >
		<b>Nome: </b> <br/> <input type="text" name="nomeTorneio" /> <br/>
		<b>Descrição: </b><br><input type="text" name="descricao" /> <br/>
		<b>Data de início [DD-MM-YYYY]: </b><br><input type="text" name="dataInicio" /> <br/>
		<b>Data final [DD-MM-YYYY]:  </b><br><input type="text" name="dataFim" /> <br/>

		<b>Dia da semana: </b> <br />
         <select name="diaSemana" >
		    <option value="1" >Domingo</option>
		    <option value="2" >Segunda-feira</option>
		    <option value="3" >Terça-feira</option>
		    <option value="4" >Quarta-feira</option>
		    <option value="5" >Quinta-feira</option>
		    <option value="6" >Sexta-feira</option>
		    <option value="7" >Sábado</option>
		  </select> 
		<br>
		<b>Hora: </b><br><input type="text" name="hora" /> <br/>
		<b>Minutos: </b><br><input type="text" name="minutos" /> <br/>

		<b>Campo: </b><br><input type="text" name="campo" /> <br/>
		<b>Taxa: </b><br><input type="text" name="taxa" /> <br/>
		
		<br>

		<br>
		<input type="submit" value="Criar torneio!" style = "font-size:20px;border-radius:8px"/>
		
	</form></center>
	<br>
	
	<center><form action="mytournaments.php">
    		<input type="submit" value="voltar aos meus torneios" style = "font-size:13px;border-radius:8px" />
			</form>
	</center>
	</br></br>

	</div>
</body>
</html>