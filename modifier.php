<?php
	require_once ("public-bin/header.inc.php") ;

	if( (int)(@$_GET['u']) != (int)$_SESSION[ 'USER' ][ 'id_employe' ] && (int)$_SESSION['USER']['type_employe'] == 0 )
		redirect( "home" ) ;
	
?>
		<br>
		<h1>Modifier un employé</h1>
<?php
		if(!empty($_GET['u']) && (int)($_GET['u']) > 0 )
		{
			if( count( $_POST ) == 0 ) // Afficher un profit au vu d'une modification
			{
				try{
					$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'DISPLAY_USER' ] );
						$sth->bindParam(':id', $_GET['u'] , PDO::PARAM_INT ) ;
					$sth->execute();
					
					if( $sth->rowCount() == 0 )
						echo "Utilisateur inconnu !" ;
					else {
						$_datas = $sth->fetch(PDO::FETCH_ASSOC);

						?>
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
					
				if( document.getElementById('mdp_employe').value.trim() != "" && !regExp[ "password" ].test( document.getElementById('mdp_employe').value.trim() ) ) 
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
					<td><input type="text" name="nom_employe" id="nom_employe" value="<?php echo $_datas["nom_employe"] ; ?>" required /></td>
				</tr>	
				<tr>
					<td>Prenom:</td>
		            <td><input type="text" name="prenom_employe" id="prenom_employe" value="<?php echo $_datas["prenom_employe"] ; ?>" required /></td>
				</tr>
				<tr>
					<td>E-Mail</td>
					<td><input type="text" name="mail_employe"  id="mail_employe" value="<?php echo $_datas["mail_employe"] ; ?>" required /></td>
				</tr>
				
				<tr>
					<td>Date de naissance:</td>
					<td><input type="date" name="date_naiss_employe" id="date_naiss_employe" value="<?php echo $_datas["date_naiss_employe"] ; ?>" placeholder="AAAA-MM-JJ" required></td>
				</tr>
				
				<tr>
					<td>Téléphone:</td>
					<td><input type="tel" name="telephone_employe" id="telephone_employe" value="<?php echo $_datas["telephone_employe"] ; ?>" required ></td>
				</tr>
				
				<tr>
					<td>Password:</td>
		            <td><input type="password" name="mdp_employe" id="mdp_employe"  /></td>
				</tr>
				
				<tr>
					<td>Confirmation Password:</td>
		            <td><input type="password" name="mdp_conf_employe" id="mdp_conf_employe"  /></td>
				</tr>
				<?php
					// Si c'est un super admin afficher le bouton si l'employé qu'il ajoute et un admin ou un membre
					if( $_SESSION['USER']['type_employe'] ==  2 ) 
					echo"<tr>
						<td>Administrateur:</td>
						<td>Oui<input type=\"radio\" name=\"administrateur\" value=\"oui\" id=\"administrateur\" />
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
						<?php
					}				
				}
				catch (Exception $err){
					echo $err ;
				}
			} else { // Valider un changement d'information(TODO: verif champs POST)
				try {
				
					$flux_bdd->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				
					$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'MODIFIER' ] );
						$sth->bindValue(':id_employe'        , $_GET[ 'u' ]                            , PDO::PARAM_INT);
						$sth->bindValue(':nom_employe'       , $_POST[ 'nom_employe' ]                 , PDO::PARAM_STR);
						$sth->bindValue(':prenom_employe'    , $_POST[ 'prenom_employe' ]              , PDO::PARAM_STR);
						$sth->bindValue(':mail_employe'      , $_POST[ 'mail_employe' ]                , PDO::PARAM_STR);
						$sth->bindValue(':telephone_employe' , $_POST[ 'telephone_employe' ]           , PDO::PARAM_STR);
						$sth->bindValue(':DateNaiss'         , $_POST[ 'date_naiss_employe' ]          , PDO::PARAM_STR);
						
						if( empty( $_POST[ 'mdp_employe' ] ) ) {
							$sth->bindValue(':mdp_sha1_employe'  , (string)$_SESSION['USER'][ 'mdp_sha1_employe' ] , PDO::PARAM_STR);
							$sth->bindValue(':mdp_md5_employe'   , (string)$_SESSION['USER'][ 'mdp_md5_employe' ] , PDO::PARAM_STR);
						} else {
							$sth->bindValue(':mdp_sha1_employe'  , (string)sha1( $_POST[ 'mdp_employe' ] ) , PDO::PARAM_STR);
							$sth->bindValue(':mdp_md5_employe'   , (string)md5( $_POST[ 'mdp_employe' ] )  , PDO::PARAM_STR);
						}

						if( (int)$_SESSION['USER']['type_employe'] == 2 ) // si le type_employe est un super Administrateur 
							$sth->bindValue(':id_ligue', ( (int)$_POST[ 'id_ligue' ] ), PDO::PARAM_INT); // Changer de ligue
						else 
							$sth->bindValue(':id_ligue',( (int)$_SESSION[ 'USER' ][ 'id_ligue' ] ), PDO::PARAM_INT);
						
						if( (int)$_SESSION['USER']['type_employe'] == 0 )
							$sth->bindValue(':type_employe', 0 , PDO::PARAM_STR); 
						else if( (int)$_SESSION['USER']['type_employe'] == 1 && (int)$_GET['u'] == (int)$_SESSION['USER']['id_employe'] )
							$sth->bindValue(':type_employe', 1 , PDO::PARAM_STR); 
						else if( (int)$_SESSION['USER']['type_employe'] == 1 && (int)$_GET['u'] != (int)$_SESSION['USER']['id_employe'] )
							$sth->bindValue(':type_employe', 0 , PDO::PARAM_STR); 
						else if( (int)$_SESSION['USER']['type_employe'] == 2 )
							$sth->bindValue(':type_employe', (int)( ( $_POST[ 'administrateur' ] == 'oui' ) ? 1 : 0 ) , PDO::PARAM_STR); // Changer status membre
						else
							throw new Exception( "Erreur interne !" ) ;
					
					$sth->execute();
				
					if( (int)$_GET['u'] == (int)$_SESSION['USER']['id_employe'] ) // Remise à jour de ses propres informations
					{
						$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'DISPLAY_USER' ] );
							$sth->bindParam(':id', $_GET['u'], PDO::PARAM_INT); 
						$sth->execute();

						if( $sth->rowCount() == 0 ) 
							throw new Exception() ;
						else 
							$_SESSION[ 'USER' ] = $sth->fetch(PDO::FETCH_ASSOC); // Récupération des informations du compte
					}

					?>
						<script>
							window.onload = function(){
								alert( "Modification effectuées !" );
								top.location.href="liste" ;
							} ;
						</script>
					<?php
				} catch( PDOException $e ) {
					echo $e ;
				} catch( Exception $e ) {
					echo $e->getMessage() ;
				}
			}
		}
?>	

	
<?php require_once ("public-bin/footer.inc.php") ;