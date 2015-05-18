<?php
	require_once ("public-bin/header.inc.php") ;
	
		if(!empty($_GET['dul']) && (int)($_GET['dul']) > 2 )
		try{
			$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'SUPPRIMER_LIGUE' ] );
			$sth->bindParam(':IdLigue', $_GET['dul'] , PDO::PARAM_INT);
			$sth->execute();
		}
		catch (Exception $err){}
		
		

	if( !isset( $_SESSION[ 'USER' ][ 'type_employe' ] ) || (int)$_SESSION[ 'USER' ][ 'type_employe' ] != 2 )
		redirect( "accueil" );
	
	if( !empty( $_POST[ 'nom_ligue' ] ) )
		try {
			$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'AJOUTER_LIGUE' ] );
			$sth->bindParam(':nom_ligue', $_POST[ 'nom_ligue' ], PDO::PARAM_STR);
			$sth->execute();
		} catch( Exception $err ){
			echo "Une erreur est survenue !" ;
		}

?>
		<br>
		<h1>Ajouter une ligue</h1>

	<div ALIGN="CENTER" class="identification">
	<form action="?" method="post">
			<table>
				<tr>
					<td>Nom de la ligue à ajouter :</td>
		            <td><input type="text" name="nom_ligue" required /> </td>
		            <td><input type="submit" value="Ajouter" /> </td>
				</tr>
			</table>	
	    </form>
		</div>
		
		<br><br><br>

<table align='center' id ="affichage">
		<thead>
			<td>Id</td>
			<td>Nom de la ligue</td>
		</thead>

	<?php
			try
			{
				$sth = $flux_bdd->prepare( $_SET[ 'SQL' ][ 'LIST_LIGUE' ] );
				$sth->execute();

				$all_ligue = $sth->fetchAll(  ) ;

				for ( $index = 0 ; $index < count( $all_ligue ) ; $index++ ){
					echo "<tr>" ;					
					echo "<td>".$all_ligue[$index]['id_ligue']."</td>" ;
					echo "<td>".$all_ligue[$index]['nom_ligue']."</td>" ;
					echo "<td><a onclick=\"return confirm('Voulez-vous réellement supprimer ".$all_ligue[$index]['nom_ligue']."?');\" href='?dul=" . $all_ligue[$index]['id_ligue'] . "'> <img id=\"logo\" src=\"public-bin/img/sup.png\"></a></td>" ;
					echo "</tr>" ;				
				}				
			} catch(Exception $err)	{
			}
			
	?>
</table>

<br><br>


<?php require_once ("public-bin/footer.inc.php") ;

