<?php 
	@session_start() or die("Erreur interne vérifier que vous avez activé les cookies !");

	require_once( "set.inc.php" ) ;

	if( isset( $_GET[ 'dsession' ] ) ){
		session_unset();
		session_destroy() ;
	}
	
	if( isset( $_SESSION[ 'USER' ] ) )
		redirect( "index.php" ) ;
	
	if ( !empty($_POST['username']) and !empty($_POST['password']) )
	{
		try 
		{
			$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'CONNEXION' ] );
			$sth->bindParam(':username', $_POST['username'], PDO::PARAM_STR); 
			$sth->bindParam(':password', $_POST['password'], PDO::PARAM_STR); 
			$sth->execute();

			if( $sth->rowCount() == 0 ) 
				$error_connexion = true ;
			else {
				$_SESSION[ 'USER' ] = $sth->fetch(PDO::FETCH_ASSOC); // Récupération des informations du compte
				redirect( "accueil" ) ; // redirection ver la page accueil
			}
		} catch(Exception $err) { // Si les informations saisie sont incorect  un message d'erreur saffiche en rouge
			echo '<p style="color:red;"> Une erreur et survenue ! </p>';
		}
	}

?>

<!doctype html>
<html>
	
<head>
        <title>Gestion du personnel des ligues </title>	
			<link rel="stylesheet" href="public-bin/css/style_main.css" />
			<meta charset="utf-8" />
</head>



<body>
		<header id="left_block" class="blocks">
			<img id="logo" src="public-bin/img/logo.png">
		</header>	
		
		<div id="main_block" class="blocks" style="position:fixed;top:0">
		
			<div class="identification">
			
			<img src="public-bin/img/identification.png" width="200" height="200">
			
				<p><h4>Pour accéder à votre compte, merci de saisir vos identifiants </h4></p>

				<form align="center" method="post" action="?">
			   <p>
			   	<?php 
			   		if ( isset( $error_connexion ) ) // Si il y'a une erreur de connection un message rouge s'affiche
			   			echo '<p style="color:red;"> Erreur de connection !  </p>';
			   	?>

				<table  align="center">
					<tr>
						<td>Identifiant:</td> 
						<td><input type="user" name="username" required /><td>
					</tr>
					
					<tr>
						<td>Mot de passe :</td>
						<td><input type="password" name="password" required /></td>
					</tr>
				
					<tr>
						<td></td>
						<td><input type="submit" value="Valider"/><td>
					<tr>
				</table>
				</p>
			</form>	

		</div>
	
<?php require_once ("public-bin/footer.inc.php") ;