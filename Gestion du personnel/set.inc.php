<?php

	/*
		Fichier de configuration du site intranet
		et d'instantiation de la connexion à la base de donnée
	*/

	$_SET = Array(
		"BDD" => Array(
			"TYPE" => "mysql"         ,
			"HOST" => "localhost"     ,
			"BASE" => "LigueLorraine" ,
			"USER" => "root"          ,
			"PASS" => ""              ,
			"PORT" => 3306 
		) ,
		// Requette SQL pour la connexion pour un super-admin le mdp et pour un admin ou un membre le jeton
		"SQL" => Array(
			"CONNEXION" => 
				"SELECT * " .
				"FROM employe E, ligue L " .
				"WHERE " .
				"( ". // Admin ou membre
					"E.mail_employe = :username AND ".
				    "E.jeton_employe = :password AND ".
				    "E.datejeton_employe > DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND ".
				    "E.type_employe < 2 AND ".
				    "L.id_ligue = E.id_ligue ".
				") OR ( ". // Super-admin
					"E.mail_employe = :username AND ".
				    "E.mdp_md5_employe = MD5(:password) AND ".
				    "E.mdp_sha1_employe = SHA1(:password) AND ".
				    "E.type_employe = 2 AND ".
					"E.id_ligue is NULL " .
				") LIMIT 1;" ,

			// Requette SQL pour affichage des information pour les personnes qui sont dans la meme ligue admin et membre
			"DISPLAY_USERS_SAME_LIGUE" => 
				"SELECT id_employe ,".
				"nom_employe, prenom_employe, mail_employe, telephone_employe, type_employe, date_naiss_employe ".
				"FROM employe ".
				"WHERE id_ligue = :id ;",
				
			// Requette SQL pour affichage des information pour le super-admin
			"DISPLAY_SUPER_ADMIN" => 
				"SELECT id_employe ,".
				"nom_ligue, nom_employe, prenom_employe, mail_employe, telephone_employe, type_employe, date_naiss_employe, date_inscri_employe ".
				"FROM employe E, ligue L WHERE E.id_ligue = L.id_ligue ;",
		
			// Requette SQL pour
			"LIST_LIGUE" => 
				"SELECT * FROM ligue ;",

			// Requette SQL pour afficher les ligues
			"AJOUTER_LIGUE" => 
				"INSERT INTO ligue ( nom_ligue ) VALUES( :nom_ligue ) ;",
				
			// Requette SQL pour ajouter un employé
			"AJOUTER_EMPLOYE" => 
				"INSERT INTO employe ( nom_employe, prenom_employe, mail_employe, date_naiss_employe, telephone_employe, mdp_sha1_employe, mdp_md5_employe, type_employe, id_ligue ) ". 
				"VALUES( :nom_employe, :prenom_employe, :mail_employe, :date_naiss_employe, :telephone_employe, :mdp_sha1_employe, :mdp_md5_employe, :type_employe, :id_ligue ) ; " ,

			// Requette SQL pour suprimer un employé
			"SUPPRIMER" =>
				"DELETE FROM employe WHERE id_employe = :IdEmploye;",	
			
			// Requette SQL pour modifier un employé
			"MODIFIER" =>	
				"UPDATE employe ".
				"SET nom_employe = :nom_employe, prenom_employe = :prenom_employe, telephone_employe = :telephone_employe, mail_employe = :mail_employe, mdp_sha1_employe = :mdp_sha1_employe, ".
				"mdp_md5_employe = :mdp_md5_employe, date_naiss_employe = :DateNaiss , id_ligue = :id_ligue, type_employe = :type_employe WHERE id_employe = :id_employe ;" ,
			
			// Requette SQL pour afficher tout les employé de la ligue souhaité
			"DATA_EMPLOYE" =>
				"SELECT * FROM EMPLOYE, LIGUE WHERE id_employe = :idemploye ;",
			
			// Requette SQL pour supprimer une ligue
			"SUPPRIMER_LIGUE" =>
				"DELETE FROM ligue WHERE id_ligue = :IdLigue ;",
			
			// Requette SQL pour modifier une ligue		
			"MODIFIER_LIGUE" =>
				"UPDATE ligue ".
				"SET nom_ligue = :NomLigue ;" ,
				
			// Afficher un utilisateur
			"DISPLAY_USER" => 
				"SELECT * FROM employe E, ligue L WHERE E.id_employe = :id AND L.id_ligue = E.id_ligue " 
		)
	) ;

	// connexion a la basse de donné
	try {
		$flux_bdd = new PDO(
			$_SET['BDD']['TYPE'] . ':host=' . $_SET['BDD']['HOST'] . ";dbname=" . $_SET['BDD']['BASE'] ,
			$_SET['BDD']['USER'] , $_SET['BDD']['PASS']
		) ;
	} catch( PDOException $e ){ // Si erreur lors de la connexion
		print "Err : " . $e->getMessage() ;
 		die( "Erreur connexion à la base de donnée !" ) ; // ... Alors on arrête tout, car cette dernière est obligatoire !
	} ;

	// Redirection
	function redirect( $url ){
		header( "Location: " . $url ) ;

		die(
			"<meta http-equiv=\"refresh\" content=\"3; URL=" . $url . "\">" .
			"<script> top.location.href = \"" . $url . "\" ; </script>"
		) ;
	} ;