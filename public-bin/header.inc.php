<?php
	@session_start() or die("Erreur interne vérifier que vous avez activé les cookies !");

	require_once( "./set.inc.php" ) ;

	if( !isset( $_SESSION['USER'] ) OR count($_SESSION['USER']) == 0 )
		redirect( "index" ) ;

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Gestion du personnel des ligues </title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="public-bin/css/style_main.css" />
	</head>
	<body>

		<header id="left_block" class="blocks"> 
			<img id="logo" src="public-bin/img/logo.png">
		<br>
		
		<div id="conecter">
			Bienvenue,
			<span style="color:red;">
				<?php echo $_SESSION[ 'USER' ][ 'nom_employe' ] . " " .  $_SESSION[ 'USER' ][ 'prenom_employe' ] ; ?>	<!-- indique le nom et prenom de la personne connecter -->	
			</span>
			<br>
				<?php
			
				switch( (int)$_SESSION[ 'USER' ][ 'type_employe' ] ) { 
					case 2 : // Super-Administrateur
						echo "<font color=\"#FF00FF\">Super-Administrateur</font>" ;
					break ;
					
					case 1 : // Administrateur de ligues
						echo "<font color=\"#000080\">Administrateur </font>de la Ligue de <br> " ;
						echo '<span style="color:#228B22;">'.$_SESSION[ 'USER' ][ 'nom_ligue' ].'</span>';	
					break ;
					
					case 0  : // Membre
					default :
						echo "<font color=\"#C71585\">Membre</font> de la Ligue de " ;
						echo '<span style="color:#228B22;">'.$_SESSION[ 'USER' ][ 'nom_ligue' ].'</span>';
					break ;
				}
				?>
		</div>

			<div id="menu">
				<div class="options"><a href="accueil">Accueil</a></div>
				<div class="options"><a href="information">Mes informations</a></div>	
				<div class="options"><a href="liste">Gestion des employés</a></div>	
				<?php
					if( $_SESSION['USER']['type_employe'] ==  2 || $_SESSION['USER']['type_employe'] ==  1) // Si le type_employe et un Super-Admin alors on affiche l'ongler pour ajouter un employé
						echo"<div class=\"options\"><a href=\"ajouter\">Ajouter un employé</a></div>";

				 	if( $_SESSION['USER']['type_employe'] ==  2 ) // Il y'a que le Super-admin qui peux avoir acces a l'ongler "Gestion des ligues"
				 		echo"<div class=\"options\"><a href=\"ajouter_ligue\">Gestion des ligues</a></div>";
				?>
				<div class="options deco"><a href="index?dsession&">D&eacute;connection</a></div>
			</div>
		</header>	

		<div id="main_block" class="blocks" style="position:relative;top:0">
		
