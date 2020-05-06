<?php

	session_start();
	
	

   require_once "connect.php";
    
    
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0)
	{
		throw new Exception(mysqli_connect_errno());
	}        
        	
	//$str = $_GET['torneioID'];
	//echo $str . " ";
	//trim($str, );

	$sessaoCC = $_SESSION['user_cc'];

	$tnome = $_GET['torneioID'];
	$tnome = str_replace('%20', '', $tnome);

	$torneioName = $tnome;

    $query ="SELECT * FROM team_tatica WHERE tournament_name = '$tnome'";
    $result = $connection->query($query);

    $num_of_results = mysqli_num_rows($result);

    /*
	$row = mysqli_fetch_assoc($result);

	$nomeEquipa = $row['name'];
	$id = $row['id'];
	$tatica_atacante = $row['tatica_atacante'];
	$tatica_medio = $row['tatica_medio'];
	$tatica_defesa = $row['tatica_defesa'];
	$user_cc = $row['user_cc'];
	$tournament_name = $row['tournament_name'];
	*/

	if($t = $connection->query("SELECT datainicio,datafim FROM tournament WHERE name = '$tnome'")){
		$d = $t->fetch_assoc();
		$dataInicio = $d['datainicio'];
		$dataFim = $d['datafim'];
	}
	
	if($t = $connection->query("SELECT * FROM schedule WHERE tournament_name = '$tnome'")){
		$r = $t->fetch_assoc();
		$dia = $r['dayofweek'];
		$horas = $r['hour'];
		$minutos = $r['minutes'];
	}

	if($sitio = $connection->query("SELECT * FROM tournament_field WHERE tournament_name = '$tnome'")){
		$c = $sitio->fetch_assoc();
		$campo = $c['field_name'];
	}

	if($t = $connection->query("SELECT * FROM field,tournament_field WHERE tournament_field.field_name = field.name AND tournament_field.tournament_name = '$tnome' ")){
		$c = $t->fetch_assoc();
		$taxa = $c['tax'];
	}

	$cartao = $connection->query("SELECT * FROM team_tatica");
		
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Pesquisar Torneio</title>
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
	      <?php session_start(); if (isset($_SESSION['logged'])) : ?>
	       <li class="nav-item">
	        <a class="nav-link" href="myteams.php">Minhas equipas</a>
	      </li>

	       <li class="nav-item">
	        <a class="nav-link" href="mytournaments.php">Meus torneios</a>
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
	.torneio{
		background-color: gray;
		color: black;
		text-align: center;
		position: absolute; 
		width: 1349px;  
		height: 600px; 
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
	  .torneio {
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
	  alert("torneio:" +  torneioID); 
	  
	  str=location.href;
	  
	  var editPage = str.replace("browseT.php", "verTorneio.php?torneioID="+torneioID);   
	  location.replace(editPage);
	}
</script>

</head>

	<br /><br />
	<br /><br />

	<body>
		<div class="torneio">
		<br><h2>Torneio</h2>	
		<form method="post" action="joinTorneio.php">

			<div id="estado" style="color:#cc0000">
				<?php 
				// Change the line below to your timezone!
				date_default_timezone_set('Europe/Lisbon');
				$atualDate = date('d/m/Y', time());
				$atualHour = date('h:i', time());
				//echo $atualDate; echo $atualHour;

				$atualDate = date('Y-m-d');
				$atualDate=date('Y-m-d', strtotime($atualDate));
				//echo $paymentDate; // echos today! 
				//$contractDateBegin = date('Y-m-d', strtotime("01/01/2001"));
				//$contractDateEnd = date('Y-m-d', strtotime("01/01/2012"));
				//echo $atualDate;

				if (($atualDate >= $dataInicio) && ($atualDate <= $dataFim)){
				    echo "<h3>A DECORRER!</h3>";
				}else if ($atualDate < $dataInicio){
				    echo "<h3>NÃO INICIADO!</h3>";
				    $estado = TRUE;  
				} else{
					echo "<h3>FINALIZADO!</h3>";
				}
			?>
			</div>

			<input name="torneioName" type="hidden" value="<?php  echo $torneioName  ?>">

			<b>Nome do torneio: </b><?php echo $tnome ?><br>
			<b>Início: </b><?php echo $dataInicio ?><br>
			<b>Fim: </b><?php echo $dataFim ?><br>
			<b>Campo: </b><?php 
			echo $campo 
			?> <br>
			<b>Taxa: </b><?php echo $taxa ?> <br>
			<b>Dia da semana: </b><?php echo $dia; echo "ªfeira"; ?><br>
			<b>Horas: </b><?php echo $horas; echo ":"; echo $minutos ?><br>

			<b>Equipas: </b><?php
				for ($i = 1; $i <= $num_of_results; $i++) {
				 	$row = mysqli_fetch_assoc($result);
				 	$nomeEquipa = $row['name'];
				 	echo $nomeEquipa;
				 	echo "<br>";
				}?> <br>
		 	<br>
			
			<?php 
		    while ($row = $cartao->fetch_assoc()){
					$ccartao = $row['user_cc'];
				 	//echo $ccartao;echo" ";echo $sessaoCC; echo"<br>";
				 	if($ccartao == $sessaoCC){
				 		$capitao = TRUE;
				 	}
			}
			if ((isset($_SESSION['logged'])) and ($capitao == TRUE) and ($estado == TRUE)) : ?>
				<input type="submit" value="Inscrever a minha equipa!" style = "font-size:20px;border-radius:8px">	<br><br>
			<?php endif; ?> 	 
			<button type="cancel" onclick="window.location='browseT.php';return false;" style = "font-size:15px;border-radius:4px">Voltar</button>
		</form>
			
		</div>
	</body>
    
</html>