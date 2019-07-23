<?php
//-------- FONCTION MEMBRE CONNECTE


//cette fonction permet de savoir si l'internaute est passé par la page inscription et surtout sur la page connexion.php
function internauteEstConnecte()
{
    if(!isset($_SESSION['membre'])) // SI l'indice 'membre' dans la session n'est pas défini, cela veut dire que l'internaute n'est pas passé par la page connecxion.php
    {
        return false;
    }
    else // Dans tout les autres cas, cela veut dire que l'internaute est passé par la page connexion.php et que l'indice (tableau)'membre' a bien été défini dans la session
    {
        return true;
    }
}

//-------- FONCTION CONNECTE ET ADMIN

// Cette fonction permet de savoir si l'internaute està a fois connecté (indice 'membre' dans la session et si le champ 'statut' est bien égal à 1, donc il est ADMIN du site
function internauteEstConnecteEtEstAdmin()
{
    if (internauteEstConnecte() && $_SESSION['membre']['statut'] == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

?>