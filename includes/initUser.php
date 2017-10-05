<?php
//chargement des classes
require "lib/autoload.inc.php";

//Activation des sessions
session_start();

//Chargement de la bdd
$bdd = PDOFactory::getMySQLConnexion();

//Création du manager d'utilisateur
$user_manager = new UserManager($bdd);

/* Deconnecter l'utilisateur
------------------------------------------------------------------------------*/
if(isset($_GET['deconnexion'])){
	session_destroy();
	$message = "Votre êtes bien déconnecté !";
  	header('Location: index.php');
}
