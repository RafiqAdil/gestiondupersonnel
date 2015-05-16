/*
	Définission d'un jeu de donnée de test
*/

SET NAMES utf8 ;

USE LigueLorraine ; -- Selection de la base de donnée

-- On insert les ligues
INSERT INTO
	 ligue ( nom_ligue )
VALUES
( 'Tennis '     ),
( 'Football '   ),
( 'Basketball ' ),
( 'Badminton '  )
;

INSERT INTO
	employe ( nom_employe, prenom_employe, mdp_sha1_employe , mdp_md5_employe, mail_employe, telephone_employe,date_naiss_employe, type_employe, id_ligue )
VALUES
	( 'Rafiq'     , 'Adil'     , SHA1( 'admin' ) , MD5( 'admin' ) , 'rafiq@adil.com'         , "0615455866" , '1990-04-02', 2 , NULL  ),
	( 'Lassalle'  , 'Quentin'  , SHA1( 'test' ) , MD5( 'test' ) , 'quentin@lassalle.com'     , "0612365478" , '1991-06-09', 1 , 1     ),
	( 'Bayart'    , 'Nicolas'  , SHA1( 'test' ) , MD5( 'test' ) , 'bayart@nicolas.com'       , "0612255894" , '1989-02-12', 0 , 1     ),
	( 'Lenfant'   , 'Valentin' , SHA1( 'test' ) , MD5( 'test' ) , 'valentin@lenfant.com'     , "0712895821" , '1985-01-21', 1 , 2     ),
	( 'Rihet'     , 'Alexandre', SHA1( 'test' ) , MD5( 'test' ) , 'rihet@alexandre.com'      , "0612255813" , '1989-04-01', 0 , 2     ),
	( 'Bedrignans', 'Thibault' , SHA1( 'test' ) , MD5( 'test' ) , 'thibault@bedrignans.com'  , "0719728355" , '1980-09-03', 1 , 3     ),
	( 'Bartolomei', 'Emmanuel' , SHA1( 'test' ) , MD5( 'test' ) , 'bartolomei@emmanuel.com'  , "0667851898" , '1994-08-17', 0 , 3     ),
	( 'Kerrad'    , 'Mamed'    , SHA1( 'test' ) , MD5( 'test' ) , 'mamed@kerrad.com'         , "0778255814" , '1993-11-09', 1 , 4     ),
	( 'Silva' 	  , 'Sonia'    , SHA1( 'test' ) , MD5( 'test' ) , 'Sonia@Silva.com'          , "0681069870" , '1990-06-19', 0 , 1     ),
	( 'Mehmood'   , 'Sarah'    , SHA1( 'test' ) , MD5( 'test' ) , 'Sarah@Mehmood.com'        , "0619964055" , '1989-02-16', 0 , 1     ),
	( 'Elbahri'   , 'Sabrina'  , SHA1( 'test' ) , MD5( 'test' ) , 'Sabrina@Elbahri.com'      , "0718852012" , '1987-01-27', 0 , 2     ),
	( 'Zafar'     , 'Katia'    , SHA1( 'test' ) , MD5( 'test' ) , 'Katia@Zafar.com'          , "0612036904" , '1980-04-05', 0 , 2     ),
	( 'Gauchet'   , 'Pauline'  , SHA1( 'test' ) , MD5( 'test' ) , 'Pauline@Gauchet.com'      , "0719710055" , '1984-01-09', 0 , 3     ),
	( 'Donofrio'  , 'Aurore'   , SHA1( 'test' ) , MD5( 'test' ) , 'Aurore@Donofrio.com'      , "0667632178" , '1978-01-13', 0 , 3     ),
	( 'Arango'    , 'Tatiana'  , SHA1( 'test' ) , MD5( 'test' ) , 'Tatiana@Arango.com'       , "0776633886" , '1993-12-19', 0 , 4     ),
	( 'Hamed'     , 'Farid'    , SHA1( 'test' ) , MD5( 'test' ) , 'Hamed@Farid.com'          , "0644558877" , '1991-04-29', 0 , 1     ),
	( 'Logan'     , 'Paul'     , SHA1( 'test' ) , MD5( 'test' ) , 'Logan@Paul.com'           , "0696314899" , '1989-06-22', 0 , 1     ),
	( 'Charef'    , 'Mohamed'  , SHA1( 'test' ) , MD5( 'test' ) , 'charef@mohamed.com'       , "0633289336" , '1985-01-31', 0 , 2     ),
	( 'Oliveira'  , 'Sebastien', SHA1( 'test' ) , MD5( 'test' ) , 'pereira@sebastien.com'    , "0674145813" , '1989-04-11', 0 , 2     ),
	( 'Pereira'   , 'Oceane'   , SHA1( 'test' ) , MD5( 'test' ) , 'thibault@bedrignans.com'  , "0796147655" , '1986-06-23', 0 , 3     ),
	( 'Hussain'   , 'Ahmed'    , SHA1( 'test' ) , MD5( 'test' ) , 'hussain@ahmed.com'        , "0668857858" , '1988-01-27', 0 , 3     ),
	( 'Alves'     , 'Nicolas'  , SHA1( 'test' ) , MD5( 'test' ) , 'nicolas@alves.com'        , "0699842854" , '1990-10-19', 0 , 4     )
;


