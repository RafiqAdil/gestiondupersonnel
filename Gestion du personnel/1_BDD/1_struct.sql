/*
	Définission de la structure de la base de données
*/

SET NAMES utf8 ;

-- Suppression de la base de donnée si existante
DROP DATABASE IF EXISTS m2lpersonnel ;

-- Création de la base de données avec l'encodage UTF-8
CREATE DATABASE m2lpersonnel CHARACTER SET utf8 COLLATE utf8_general_ci ;

-- Utilisation de la base de donnée nouvellement créer
USE m2lpersonnel ;

-- Suppression de toutes les tables et relations
DROP TABLE IF EXISTS employe ; -- Suppression de la table des employés
DROP TABLE IF EXISTS ligue   ; -- Suppression de la table des ligues

-- Création de la table des ligues
CREATE TABLE IF NOT EXISTS ligue (
  id_ligue            INT(2)      NOT     NULL  AUTO_INCREMENT  , -- ID de la ligue
  nom_ligue           VARCHAR(20) DEFAULT NULL                  , -- le nom de ma ligue
  PRIMARY KEY (id_ligue)
) ENGINE=InnoDB CHARACTER SET=utf8 ;

-- Création de la table des employés
CREATE TABLE IF NOT EXISTS employe (
  id_employe        	INT(3)       NOT     NULL  AUTO_INCREMENT , -- Id de l'employé
  nom_employe       	VARCHAR(20)  DEFAULT NULL                 , -- Nom de l'employé
  prenom_employe    	VARCHAR(20)  DEFAULT NULL                 , -- Prenom de l'employé
  mail_employe      	VARCHAR(30)  DEFAULT NULL                 , -- Adresse mail de l'employé
  date_naiss_employe	DATE		     DEFAULT NULL 			  , -- Date de naissance de l'employé
  datejeton_employe 	DATE         DEFAULT NULL				  , -- Date de génération du jeton
  date_inscri_employe 	TIMESTAMP    DEFAULT CURRENT_TIMESTAMP 	  , -- La datte d'inscription de l'employé 
  telephone_employe 	VARCHAR(50)  DEFAULT NULL  				  , -- Numéro de téléphone de l'employé
  jeton_employe     	VARCHAR(100) DEFAULT NULL                 , -- Jeton de connexion à l'interface intranet
  mdp_sha1_employe  	VARCHAR(100) NOT     NULL                 , -- Hash du mot de passe en SHA1 pour l'application mobile
  mdp_md5_employe   	VARCHAR(32)  NOT     NULL                 , -- Hash du mot de passe en MD5  pour l'application mobile
  type_employe        TINYINT(1)   DEFAULT "0"				      , -- Type d'employé : 0 (Membre), 1 (Admin) , 2 (SuperAdmin)
  id_ligue            INT(2)                                      , -- Ligue d'appartenance
  PRIMARY KEY ( id_employe )                                      , -- Identifiant unique de l'employe
  FOREIGN KEY (id_ligue) REFERENCES ligue (id_ligue)              -- id_ligue fait réference a id_ligue de la table LIGUE
) ENGINE=InnoDB CHARACTER SET=utf8 ;