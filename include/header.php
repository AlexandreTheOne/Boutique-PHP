<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>10 - BOUTIQUE</title>


<?php
//     echo "<pre>";
//     print_r ($_SERVER['PHP_SELF']);
//     echo "</pre>";
//     if ($_SERVER['PHP_SELF'] == '/PHP/10 - BOUTIQUE/admin/gestion_boutique.php' || $_SERVER['PHP_SELF'] == '/PHP/10 - BOUTIQUE/admin/gestion_commande.php' || $_SERVER['PHP_SELF'] == '/PHP/10 - BOUTIQUE/admin/gestion_membre.php')
//    $css = '../include/CSS/style.css';
    
//     else $css='./include/CSS/style.css';
    ?>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="<?=URL?>/include/CSS/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"> 



</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Ma boutique de OUFF !!!</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto">

                <?php if(internauteEstConnecte()):?>
                <!--Accès à l'internaute membre, donc qui est inscrit sur le site --->

                
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>profil.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>boutique.php">Boutique<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>panie.php">Panier<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>connexion.php?action=deconnexion">Déconnexion</a>
                </li>
                
                

                <?php else: ?>
                <!--Accès visiteur lambda, donc visiteur non inscrit ou connecté au site-->

                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>inscription.php">Inscription</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>connexion.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>boutique.php">Boutique<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>panier.php">Panier<span class="sr-only">(current)</span></a>
                </li>

                <?php endif;?>

                <?php if(internauteEstConnecteEtEstAdmin()):?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">BACK OFFICE</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="<?=URL ?>admin/gestion_boutique.php">Gestion Boutique</a>
                        <a class="dropdown-item" href="<?= URL ?>admin/gestion_membre.php">Gestion Membres</a>
                        <a class="dropdown-item" href="<?= URL ?>admin/gestion_commande.php">Gestion Commandes</a>
                    </div>
                </li>

                <?php endif;?>


            </ul>
            <form class="form-inline my-2 my-md-0">
                <input class="form-control" type="text" placeholder="Search">
            </form>
        </div>
    </nav>

                   


    <main class="container mon-conteneur">