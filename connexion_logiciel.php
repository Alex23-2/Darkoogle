<?php

$host = ""; /* L'adresse du serveur */
$login = ""; /* Votre nom d'utilisateur */
$password = ""; /* Votre mot de passe */
$base = "darkoogle"; /* Le nom de la base */

$mysqli = new mysqli($host, $login, $password, $base);

if ($mysqli->connect_error) 
	die('Erreur de connexion ( '.$mysqli->connect_errno.')'. $mysqli->connect_error);		
?>