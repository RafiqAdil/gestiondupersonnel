<?php require_once ("public-bin/header.inc.php") ;

	if(!empty($_GET['du']) && (int)($_GET['du']) > 0 )
		try{
			$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'SUPPRIMER' ] );
			$sth->bindParam(':IdEmploye', $_GET['du'] , PDO::PARAM_INT);
			$sth->execute();
		}
		catch (Exception $err){}

	?>
	
	
	
		<br>
		<h1>Liste des employés de la Ligue de  <?php echo $_SESSION[ 'USER' ][ 'nom_ligue' ] ?></h1>
		
	<br>
	<table align='center' id ="affichage">
		<thead>
			<tr>
				<td>Prenom </td>
				<td>Nom </td>
				<td>Email</td>
				<td>Telephone </td>
				<td>Type employés</td>
				<?php
				
					switch( (int) $_SESSION['USER']['type_employe'] ){
						case 1 : //admin
							echo "<td>Date de naissance</td>";
						break;
						
						case 2 : //super-admin
							echo '<td>Ligue</td>' ;
							echo "<td>Date de naissance</td>";
							echo "<td>Date d'inscription</td>";
						break;
						
						default:
						break;
					} ;

				?>			
			</tr>
		</thead>

		<?php
		
			if( (int) $_SESSION['USER']['type_employe'] == 0 ||  (int) $_SESSION['USER']['type_employe'] == 1 )
				try
				{
					$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'DISPLAY_USERS_SAME_LIGUE' ] );
					$sth->bindParam(':id', $_SESSION[ 'USER' ][ 'id_ligue' ], PDO::PARAM_INT);
					$sth->execute();

					$all_users_on_ligue = $sth->fetchAll(  ) ;

					for ( $index = 0 ; $index < count( $all_users_on_ligue ) ; $index++ ){
						echo "<tbody>" ;
						echo "<tr>" ;
							
						echo "<td>".$all_users_on_ligue[$index]['nom_employe']."</td>" ;
						echo "<td>".$all_users_on_ligue[$index]['prenom_employe']."</td>" ;
						echo "<td>".$all_users_on_ligue[$index]['mail_employe']."</td>" ;
						echo "<td>".$all_users_on_ligue[$index]['telephone_employe']."</td>" ;
						
						switch ( (int) $all_users_on_ligue[$index]['type_employe'] ){
							case 0:
								echo '<td>Membre</td>';
							break;
							
							case 1:
								echo '<td>Admin</td>';
							break;
							
							default: break;
						}
						
						if( (int) $_SESSION['USER']['type_employe'] == 1 )
							echo "<td>".$all_users_on_ligue[$index]['date_naiss_employe']."</td>" ;	
						if( (int) $_SESSION['USER']['type_employe'] == 1 )
							echo "<td><a href='modifier.php?u=" . $all_users_on_ligue[$index]['id_employe'] . "'><img id=\"logo\" src=\"public-bin/img/modifier.png\"></a></td>" ;
						if( (int) $_SESSION['USER']['type_employe'] == 1 )
							echo "<td><a onclick=\"return confirm('Voulez-vous réellement supprimer ".$all_users_on_ligue[$index]['prenom_employe']." ".$all_users_on_ligue[$index]['nom_employe']." ?');\" href='?du=" . $all_users_on_ligue[$index]['id_employe'] . "'> <img id=\"logo\" src=\"public-bin/img/sup.png\"></a></td>" ;
							echo "</tr>" ;
							echo "</tbody>" ;		
					}		
				} catch(Exception $err)	{
				}
				
				
				
				
				
				
			
			if( (int) $_SESSION['USER']['type_employe'] == 2 )
				try
				{
					$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'DISPLAY_SUPER_ADMIN' ] );
					$sth->bindParam(':id', $_SESSION[ 'USER' ][ 'id_ligue' ] , PDO::PARAM_INT);
					$sth->execute();

					$all_users_on_ligue = $sth->fetchAll(  ) ;

					for ( $index = 0 ; $index < count( $all_users_on_ligue ) ; $index++ ){
						echo "<tbody>" ;
							echo "<tr>" ;
								echo "<td>".$all_users_on_ligue[$index]['nom_employe']."</td>" ;
								echo "<td>".$all_users_on_ligue[$index]['prenom_employe']."</td>" ;
								echo "<td>".$all_users_on_ligue[$index]['mail_employe']."</td>" ;
								echo "<td>".$all_users_on_ligue[$index]['telephone_employe']."</td>" ;	
								switch ( (int) $all_users_on_ligue[$index]['type_employe'] ){
									case 0:
										echo '<td>Membre</td>';
									break;
									
									case 1:
										echo '<td>Admin</td>';
									break;
									
									case 2 :
										echo '<td>Super-Admin</td>' ;
									break ;
									
									default: break;
								}
								
								echo "<td>".$all_users_on_ligue[$index]['nom_ligue']."</td>" ;	
								echo "<td>".$all_users_on_ligue[$index]['date_naiss_employe']."</td>" ;	
								echo "<td>".$all_users_on_ligue[$index]['date_inscri_employe']."</td>" ;
								echo "<td><a href='modifier.php?u=" . $all_users_on_ligue[$index]['id_employe'] . "'><img id=\"logo\" src=\"public-bin/img/modifier.png\"></a></td>" ;
								echo "<td><a onclick=\"return confirm('Voulez-vous réellement supprimer ".$all_users_on_ligue[$index]['prenom_employe']." ".$all_users_on_ligue[$index]['nom_employe']." ?');\" href='?du=" . $all_users_on_ligue[$index]['id_employe'] . "'> <img id=\"logo\" src=\"public-bin/img/sup.png\"></a></td>" ;
							echo "</tr>" ;
						echo "</tbody>" ;		
					}		
				} catch(Exception $err)	{
				}
?>
	</table>
	

<BR><BR><BR>
		
<?php require_once ("public-bin/footer.inc.php") ; 