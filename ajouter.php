<?php require_once ("public-bin/header.inc.php") ;

	// Si le type_employé un administrateur ou un Super-admin alors il peux ajouter un employé 
	if( !isset( $_SESSION[ 'USER' ][ 'type_employe' ] ) || ( (int)$_SESSION[ 'USER' ][ 'type_employe' ] != 2 && (int)$_SESSION[ 'USER' ][ 'type_employe' ] != 1 ) )
		redirect( "accueil" ); // si un membre force il et redirectioné ver l'accueil
	
	if( !empty( $_POST[ 'nom_employe' ] ) AND !empty($_POST['prenom_employe']) AND !empty($_POST['mail_employe']) 
	AND !empty($_POST['date_naiss_employe']) AND !empty($_POST['telephone_employe']) AND !empty($_POST['mdp_employe']) )
	
	{
			
		try {
			// Controle de saisie pour le nom"
			if(!preg_match("#^([A-Za-z]+(\\s|\\-)*){3,}$#iu", trim( $_POST['nom_employe'] ) )) 
				throw new Exception("_Votre nom et incorect !");
			
			// Controle de saisie pour le prenom"
			if(!preg_match("#^([A-Za-z]+(\\s|\\-)*){3,}$#iu", trim( $_POST['prenom_employe'] ) ) ) 
				throw new Exception("_Votre prenom et incorect !");

			// Controle de saisie pour l'email
			if(!filter_var($_POST['mail_employe'], FILTER_VALIDATE_EMAIL))  // la fonction "FILTER_VALIDATE_EMAIL" s'occupe deja du bon format de l'adresse mail
				throw new Exception("_Votre E-mail et incorect !");
			
			// Controle de saisie pour la date de naissance
			if(!preg_match("#^(([0-9]){4}(\/|\-|\s)(0?0|0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12){1}(\/|\-|\s)([0-9]){2}){1}$#", trim( $_POST['date_naiss_employe'] ) ) ) // 4 chifre de 0 a 9 pour l'année / le mois si le premier chifre et 0 de o a 9 si sa commence par 1 de 0 a 2/ le jour si le chifre commence par 1 ou 2 le suivant peux allez juska 9 si sa commence par un 3 peux allez de 0 a 1
				throw new Exception("_Votre date de naissance et incorect !");
			
			// Controle de saisie si le numéro de téléphone 
			if (!preg_match("#^0[1-9]([-. ]?[0-9]{2}){4}$#", trim( $_POST['telephone_employe'] ) ) ) // commancant par un 0 ensuite un nombre de 1 a 9 pui 4 fois 2 nombre prenant en compte les tiret les espace et les points
				throw new Exception("_Votre numéro de téléphone et incorect !");
			
			// Controle de saisie si le mot de passe a au moin 4 caractere
			if( trim( strlen($_POST['mdp_employe'] ) ) < 4) 
				throw new Exception("_Votre mots de passe et incorect !");
			
			 // Controle de saisie si le mot de passe et la confirmation de mot de passe sont les meme
			if( trim( $_POST['mdp_employe'] ) != trim( $_POST['mdp_conf_employe'] ) )
				throw new Exception("_La confirmation de mots de passe et incorrect !");

			$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'AJOUTER_EMPLOYE' ] );
			$sth->bindValue(':nom_employe', $_POST[ 'nom_employe' ], PDO::PARAM_STR);
			$sth->bindValue(':prenom_employe', $_POST[ 'prenom_employe' ], PDO::PARAM_STR);
			$sth->bindValue(':mail_employe', $_POST[ 'mail_employe' ], PDO::PARAM_STR);
			$sth->bindValue(':date_naiss_employe', $_POST[ 'date_naiss_employe' ], PDO::PARAM_STR);
			$sth->bindValue(':telephone_employe', $_POST[ 'telephone_employe' ], PDO::PARAM_STR);
			$sth->bindValue(':mdp_sha1_employe', (string)sha1( $_POST[ 'mdp_employe' ] ), PDO::PARAM_STR);
			$sth->bindValue(':mdp_md5_employe', (string)md5( $_POST[ 'mdp_employe' ] ), PDO::PARAM_STR);
			
			if( (int)$_SESSION['USER']['type_employe'] ==  1 ) // si le type_employe et un Administrateur 
				$sth->bindValue(':id_ligue',( (int)$_SESSION[ 'USER' ][ 'id_ligue' ] ), PDO::PARAM_INT);
			elseif ((int)$_SESSION['USER']['type_employe'] ==  2 ) // si le type_employe et un Super-Admin 
			{
				if ( !empty( $_POST[ 'id_ligue' ] ) )
					$sth->bindValue(':id_ligue', $_POST[ 'id_ligue' ], PDO::PARAM_INT);
				else
					throw new Exception() ; 
			}
				
			if( $_SESSION['USER']['type_employe'] ==  2 )
				$sth->bindValue(':type_employe', (int)( ( $_POST[ 'administrateur' ] == 'oui' ) ? 1 : 0 ) , PDO::PARAM_STR);
			else 
				$sth->bindValue(':type_employe',0, PDO::PARAM_STR);
			$sth->execute();
			echo "<script>window.onload=function(){alert('Votre utilisateur a bien éte ajouter');};</script>";
		} catch( Exception $err ){
			if( $err.getMessage().substr(0,1) == '_' )
				echo $err.getMessage().substr(1) ;
			else
				echo "Une erreur est survenue !" ;
		}
}
 ?>

		<br>
		<h1>Ajouter un employé</h1>
		<br>
		
		<script>
			var regExp = {
				"name"     : new RegExp( "([A-Za-z]+(\\s|\\-)*){3,}" ) ,
				"email"    : new RegExp( "[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,4}" , 'i' ) ,
				"phone"    : new RegExp( "0[1-9]([-. ]?[0-9]{2}){4}" , 'gi' ) ,
				"borndate" : new RegExp( "(([0-9]){4}(\/|\-|\s)(0?0|0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12){1}(\/|\-|\s)([0-9]){2}){1}" ) ,
				"password" : new RegExp( "(.){4,}" ) 
			} ;
			
			function checkValues(){
				var err_msg = "" ;
				
				if( !regExp[ "name" ].test( document.getElementById('nom_employe').value.trim() ) ) 
					err_msg += "\n - Nom incorrect" ;
					
				if( !regExp[ "name" ].test( document.getElementById('prenom_employe').value.trim() ) ) 
					err_msg += "\n - Prénom incorrect" ;
					
				if( !regExp[ "email" ].test( document.getElementById('mail_employe').value.trim() ) ) 
					err_msg += "\n - Adresse e-mail incorrect" ;
					
				if( !regExp[ "phone" ].test( document.getElementById('telephone_employe').value.trim() ) ) 
					err_msg += "\n - Numéto de téléphone incorrect" ;
					
				if( !regExp[ "borndate" ].test( document.getElementById('date_naiss_employe').value.trim() ) ) 
					err_msg += "\n - Date de naissance incorrect" ;
					
				if( !regExp[ "password" ].test( document.getElementById('mdp_employe').value.trim() ) ) 
					err_msg += "\n - Mot de passe incorrect" ;

				if( document.getElementById('mdp_employe').value.trim() != document.getElementById('mdp_conf_employe').value.trim() ) 
					err_msg += "\n - Confirmation incorrect" ;
				
				if( err_msg.trim() == "" ) 
					return true ;
				else {
					alert( "Merci de bien vouloir remplir correctement le formule : " + err_msg );
					return false ;
				}
			}
		</script>
		
	<div ALIGN="CENTER" class="identification">
	<form onsubmit="return checkValues();" method="post">
			<table>
				<tr>
					<td>Nom:</td>
					<td><input type="text" name="nom_employe" id="nom_employe" required /></td>
				</tr>	
				<tr>
					<td>Prenom:</td>
		            <td><input type="text" name="prenom_employe" id="prenom_employe" required /></td>
				</tr>
				<tr>
					<td>E-Mail</td>
					<td><input type="text" name="mail_employe"  id="mail_employe" required /></td>
				</tr>
				
				<tr>
					<td>Date de naissance:</td>
					<td><input type="date" name="date_naiss_employe" id="date_naiss_employe" placeholder="AAAA-MM-JJ" required></td>
				</tr>
				
				<tr>
					<td>Téléphone:</td>
					<td><input type="tel" name="telephone_employe" id="telephone_employe" required ></td>
				</tr>
				
				<tr>
					<td>Password:</td>
		            <td><input type="password" name="mdp_employe" id="mdp_employe" required /></td>
				</tr>
				
				<tr>
					<td>Confirmation Password:</td>
		            <td><input type="password" name="mdp_conf_employe" id="mdp_conf_employe" required /></td>
				</tr>
				<?php
					// Si c'est un super admin afficher le bouton si l'employé qu'il ajoute et un admin ou un membre
					if( $_SESSION['USER']['type_employe'] ==  2 ) 
					echo"<tr>
						<td>Administrateur:</td>
						<td>Oui<input type=\"radio\" name=\"administrateur\" value=\"oui\" id=\"administrateur\" required/>
						Non<input type=\"radio\" name=\"administrateur\" value=\"non\" id=\"administrateur\" /><br/></td>	
					</tr>	"; 
					
					// Si l'utilisateur et bien un super admin alors afficher la liste des ligues dans un menu déroulant
					if( $_SESSION['USER']['type_employe'] ==  2 ) 
					try{	
						$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'LIST_LIGUE' ] );
						$sth->execute();
						$ligues = $sth->fetchAll(  ) ;
				
						echo"<tr>";
							echo"<td>Ligue:</td>";
							echo"<td>";
								echo"<select name='id_ligue'>";
								for ( $index = 0 ; $index < count( $ligues ) ; $index++ ) 
								echo "<option value='" . $ligues[$index]['id_ligue']  . "'> " .$ligues[$index]['nom_ligue']  . " </option>";		
								echo"</select>";
							echo"</td>";
						echo"</tr> ";
					}
					catch( Exception $err ){}
				?>	
			</table>	
			
			<br>
<input type="submit" value="Valider"/>
			
	    </form>
		</div>
<?php require_once ("public-bin/footer.inc.php") ; 