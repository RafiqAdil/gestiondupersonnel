<?php require_once ("public-bin/header.inc.php") ; ?>
		<br>
		<h1>Mes informations</h1>

		<div class="identification">
		<table align="center">
					<tr>
						<td class="left_info">Id:</td> 
						<td class="right_info"> <?php echo $_SESSION[ 'USER' ][ 'id_employe' ]?>  </td>
					</tr>	
					<tr>
						<td class="left_info">Nom:</td> 
						<td class="right_info"> <?php echo $_SESSION[ 'USER' ][ 'nom_employe' ]?></td>
					</tr>	
					<tr>
						<td class="left_info">Prenom: </td> 
						<td class="right_info"><?php echo $_SESSION[ 'USER' ][ 'prenom_employe' ]?>  </td>
					</tr>
					
					
					<tr>
						<td class="left_info"><?php if( (int) $_SESSION['USER']['type_employe'] == 0 ||  (int) $_SESSION['USER']['type_employe'] == 1 ) echo'jeton:'; ?></td>
						<td class="right_info"><?php if( (int) $_SESSION['USER']['type_employe'] == 0 ||  (int) $_SESSION['USER']['type_employe'] == 1 ) echo $_SESSION[ 'USER' ][ 'jeton_employe' ]?>  </td>
					</tr>
							
					<tr>
						<td class="left_info" ><?php if( (int) $_SESSION['USER']['type_employe'] == 0 ||  (int) $_SESSION['USER']['type_employe'] == 1 ) echo'Nom de la ligue:'; ?></td> 
						<td class="right_info"><?php if( (int) $_SESSION['USER']['type_employe'] == 0 ||  (int) $_SESSION['USER']['type_employe'] == 1 ) echo $_SESSION[ 'USER' ][ 'nom_ligue' ]?>  </td>
					</tr>
					<tr>
						<td class="left_info">Télephone:</td>
						<td class="right_info"><?php echo $_SESSION[ 'USER' ][ 'telephone_employe' ]?>  </td>
					</tr>
					
					<tr>
						<td class="left_info">Adresse mail:</td> 
						<td class="right_info"><?php echo $_SESSION[ 'USER' ][ 'mail_employe' ]?>  </td>
					</tr>
					
					<tr>
						<td class="left_info">Date de naissance:</td>
						<td class="right_info"><?php echo $_SESSION[ 'USER' ][ 'date_naiss_employe' ]?>  </td>
					</tr>
					<tr>
						<td class="left_info">Date d'inscription:</td>
						<td class="right_info"><?php echo $_SESSION[ 'USER' ][ 'date_inscri_employe' ]?>  </td>
					</tr>
					
				
				</table>
				
					<tr>
						<td></td>	
						<td><br><input type="submit" value="Modifier" onclick="javascript:top.location.href='modifier.php?u=<?php echo $_SESSION[ 'USER' ]['id_employe']; ?>';" /></td>
					</tr>
		</div>
<?php require_once ("public-bin/footer.inc.php") ;