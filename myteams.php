

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
	.myTeams{
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
	  .myTeams {
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

	table td.first { display: none; }
</style>


<script>
	function verEquipa(r) {
	  var i = r.parentNode.parentNode.rowIndex;
	  equipaID=document.getElementById("equipas").rows[i].cells[0].innerHTML;
	  //alert("equipa:" +  equipaID); 
	  
	  str=location.href;
	  
	  var editPage = str.replace("browseTeam.php", "verEquipa.php?equipaID="+equipaID);   
	  location.replace(editPage);
	}

	function apagaEquipa(r){
	    var i = r.parentNode.parentNode.rowIndex;
	    equipaID=document.getElementById("equipas").rows[i].cells[0].innerHTML;   
	    //alert("emp:" +  empid);

	    if (confirm("Apagar equipa?")) {
	        document.getElementById("equipas").deleteRow(i);
			
	 	location.replace("apagaEquipa.php?equipaID="+equipaID);
	        // apaga tb o empregado da BD
	    } else {
	        //alert("I am an alert box!");
	    }    
	}

</script>

</head>

<body>
	<div class="myTeams">
	<br><h2>Minhas Equipas</h2>	

		<?php 
			//$sql = mysqli_query($connection, "SELECT team_tatica.name FROM team_tatica, user where team_tatica.user_cc = user.cc and user.username = \'{$_SESSION['user_login']}\'");
			require_once "connect.php";
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			//$query = $connection->query("SELECT team_tatica.name FROM team_tatica");
			if ($connection->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}   
      		
      		session_start();

      		if ($_SESSION['admin'] == TRUE)  {
				$query = $connection->query("SELECT * FROM team_tatica ORDER BY name");

			    $num_of_results = mysqli_num_rows($query);
				

			    if($num_of_results>0){
			    	echo '<center><table id="equipas" >
			    	<col width="150"> <col width="75"> <col width="140"> <tr>
                    <th>Nome</th>
                    <th>Tatica</th>
                    <th>Torneio</th>
		        	</tr>';

					while ($row = $query->fetch_assoc()){
						//echo '<div class="my_class" id = "teamID">'.$row['id'].'</div>';
						echo '<tr> 
						<td class="first">'.$row['id'].'</td>
			            <td>'.$row['name'].' </td>  
			            <td>'.$row['tatica_defesa'].'-'.$row['tatica_medio'].'-'.$row['tatica_atacante'].'</td> 
			            <td>'.$row['tournament_name'].' </td>

			            <td><input type="submit" value="Apagar" onclick="apagaEquipa(this)"></td>
			            </tr> ';
					}
					echo "</table></center>";
			    }else{
			    	echo "Sem equipas";
			    }	
      		}
      		else{
      			//echo"nao admin";
      			$query = $connection->query("SELECT team_tatica.name,team_tatica.tatica_atacante, team_tatica.tatica_medio,team_tatica.tatica_defesa, team_tatica.tournament_name, team_tatica.id,role_in_team.team_id FROM team_tatica,user,role_in_team WHERE role_in_team.user_cc=user.cc AND role_in_team.team_id = team_tatica.id AND user.username = '{$_SESSION['user_login']}' ");

			    $num_of_results = mysqli_num_rows($query);
				

			    if($num_of_results>0){
			    	echo '<center><table id="equipas" >
			    	<col width="150"> <col width="75"> <col width="140"> <tr>
                    <th>Nome</th>
                    <th>Tatica</th>
                    <th>Torneio</th>
		        	</tr>';

					while ($row = $query->fetch_assoc()){
						//echo '<div class="my_class" id = "teamID">'.$row['id'].'</div>';
						echo '<tr> 
						<td class="first">'.$row['id'].'</td>
			            <td>'.$row['name'].' </td>  
			            <td>'.$row['tatica_defesa'].'-'.$row['tatica_medio'].'-'.$row['tatica_atacante'].'</td> 
			            <td>'.$row['tournament_name'].' </td>

			            </tr> ';
					}
					echo "</table></center>";
			    }else{
			    	echo "Sem equipas";
			    }
      		}
		?>
		<br>
		<form action="criarEquipa.php">
			<button type="submit" style = "font-size:20px;border-radius:8px">Criar Equipa</button>
			
	    </form>
	</div>
</body>
</html>