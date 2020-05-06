<?php

	session_start();
	
   require_once "connect.php";
    
    
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno != 0)
	{
		throw new Exception(mysqli_connect_errno());
	}        
       

	$equipaID = $_GET['equipaID'];

    if($sql = $connection->query("SELECT * FROM team_tatica WHERE id = '$equipaID'")){
		$team = $sql->fetch_assoc();
		$teamNAME = $team['name'];
		$tatica_atacante = $team['tatica_atacante'];
		$tatica_medio = $team['tatica_medio'];
		$tatica_defesa = $team['tatica_defesa'];
		$capitaoCC = $team['user_cc'];
	}

	if($sql = $connection->query("SELECT username,fname,lname FROM user WHERE cc = '$capitaoCC'")){
		$player = $sql->fetch_assoc();
		$usernameCapitao = $player['username'];
		$nomeCapitao = $player['fname'];
		$apelidoCapitao = $player['lname'];
	}


	$papelP = $connection->query("SELECT role_in_team.user_cc, user.fname, user.lname FROM role_in_team,user WHERE user.cc = role_in_team.user_cc AND team_id = '$equipaID' ORDER BY user.fname ASC");
		
	//$pos = $connection->query("SELECT role FROM role_in_team WHERE team_id = '$equipaID'");

	/*
	if($pos = $connection->query("SELECT role FROM role_in_team WHERE team_id = '$equipaID'")){
		$p = $pos->fetch_assoc();
		$posicao = $p['role'];
		
		$num_posicoes = mysqli_num_rows($pos);
	}*/

	/*
	$n_gr = 0;
	$n_def = 0;
	$n_med = 0;
	$n_ata = 0;
	while ($row = $pos->fetch_assoc()){
		$position = $row['role'];
	 	if($position == "Guarda-Redes"){
	 		$n_gr++;
	 	}else if($position == "Defesa"){
	 		$n_def++;
	 	}else if($position == "Médio"){
	 		$n_med++;
	 	}else if($position == "Avançado"){
	 		$n_ata++;
	 	}
	}
	*/
	
	if($gr = $connection->query("SELECT count(role) as conta FROM role_in_team WHERE team_id = '$equipaID' and role = 'Guarda-Redes' ")){
		$c = $gr->fetch_assoc();
		$n_gr = $c['conta'];
	}

	if($def = $connection->query("SELECT count(role) as conta FROM role_in_team WHERE team_id = '$equipaID' and role = 'Defesa' ")){
		$c = $def->fetch_assoc();
		$n_def = $c['conta'];
	}

	if($med = $connection->query("SELECT count(role) as conta FROM role_in_team WHERE team_id = '$equipaID' and role = 'Médio' ")){
		$c = $med->fetch_assoc();
		$n_med = $c['conta'];
	}
	if($ata = $connection->query("SELECT count(role) as conta FROM role_in_team WHERE team_id = '$equipaID' and role = 'Avançado' ")){
		$c = $ata->fetch_assoc();
		$n_ata = $c['conta'];
	}

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
			<?php if (isset($_SESSION['logged'])) : ?>
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
	.equipa{
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
	  .equipa {
	    font-size: 15px;
	    width: 600px;  
		height: 300px; 
		z-index: 2; 
		left: 20px;
		right: 20px;
		top: 100px;
	  }
	}

	.equipas{
		text-align: center;
		margin: 0 auto;
	}

</style>

<script>
	function verEquipa(r) {
	  var i = r.parentNode.parentNode.rowIndex;
	  equipaID=document.getElementById("teamID").rows[i].cells[0].innerHTML;
	  //alert("equipa:" +  equipaID); 
	  
	  str=location.href;
	  
	  var editPage = str.replace("browseTeam.php", "verEquipa.php?equipaID="+equipaID);   
	  location.replace(editPage);
	}
</script>

</head>

	<br /><br />
	<br /><br />

<body>
		<div class="equipa">
		<br><h2>Equipa</h2>	
		<form method="post" action="joinTeam.php">

			<input name="equipaID" type="hidden" value="<?php  echo $equipaID  ?>">

			<b>Equipa: </b><?php echo $teamNAME; ?><br>
			<b>Capitão: </b><?php  echo $nomeCapitao; echo " ";echo $apelidoCapitao; ?><br>
			<b>Tática: </b><?php  echo $tatica_defesa;echo"-";echo$tatica_medio;echo"-";echo$tatica_atacante;?><br>
			<b>Guarda-Redes: </b><?php echo $n_gr; ?><br>
			<b>Defesas: </b><?php  echo $n_def; ?> <br>
			<b>Médios: </b><?php echo $n_med; ?><br>
			<b>Atacantes: </b><?php echo $n_ata; ?><br>

			<b>Jogadores: </b><?php
				echo $num_players;

				while ($row = $papelP->fetch_assoc()){
					$nome = $row['fname'];
				 	$apelido = $row['lname'];
				 	echo $nome;echo" ";echo $apelido;
				 	echo "<br>";
				}

				?> <br>
		 	
		 	<?php if (isset($_SESSION['logged'])) : ?>
				<input type="submit" value="Inscrever na equipa" style = "font-size:20px;border-radius:8px"><br><br>
			<?php endif; ?> 
			<button type="cancel" onclick="window.location='browseTeam.php';return false;" style = "font-size:15px;border-radius:4px">Voltar</button>
		</form>
			
		</div>
</body>
    
</html>