<?php


//--------------- CONNEXION BDD
$bdd = new PDO('mysql:host=localhost;dbname=site', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


//------------------ SESSION
session_start();



//----------------- CHEMIN
define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . "/PHP/10 - BOUTIQUE/");

//echo RACINE_SITE;
// CEtte constnte retourne le chemin physique du dossier 10 - BOUTIQUE sur le serveur
// Lors de l'enrgistrement de photos/ images, nous aurons besoin du chemin complet du dossier 'photo' afin d'enregister la photo dans le bon dossier 


define ("URL", " http://localhost/PHP/10 - BOUTIQUE/");
//echo URL;

// cette constante servira, par exemple à enregister l'URL des images/photos dans la BDD, on ne conserve jamais la photo elle même, ca serait trop our pour la BDD

// ----------VARIABLES
$content='';
$error='';
$msg='';

//---------------------PARADE VS FAILLES XSS

foreach($_POST as $key=>$value)
{
    $_POST[$key] =  strip_tags(trim($value));
}

// strip_tags supprime les balises HTML
// trim : supprime les espaces en début et fin de chaîne


//------------- INCLUSIONS

require_once('fonction.php');
// En appelantl fichier 'init.php', on appelle dans le même temps le fichier 'fonctions.php'
?>



