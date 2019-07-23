<?php
require_once('include/init.php');

extract($_SESSION);

echo '<pre>';
print_r($_SESSION);
echo '</pre>';



//Si l'internaute,n'est pas connecté, il n'a rien à faire sur la page profil, on le redirige vers la page connexion.php

if(!internauteEstConnecte())
{
    header("Location:" . URL . "connexion.php"); 
}


require_once('include/header.php');
?>

<!--
<h1 class="display-4 text-center mt-4">Bienvenue <strong class="text-success"><?= $membre['pseudo'] ?></strong>!! Détails de votre profil</h1>



<div class='col-md-6 offset-md-3 alert alert-secondary text-center p-4'>

<div class="cont-profil col-md-4 offset-md-4 alert alert-secondary text-center p-4"></div>
    <div class="row justify-content-between">
        <span><strong class="text-secondary mr-2">Pseudo: </strong class="ml-2"><?= $pseudo ?></span>
        <button class="btn btn-secondary">modifier</button>
    </div>
    <hr>
    <div class="row justify-content-between">
        <span><strong class="text-secondary mr-2">Nom: </strong><?= $nom ?></span>
        <button class="btn btn-secondary">modifier</button>
    </div>
    <hr>
    <div class="row justify-content-between">
        <span> <strong class="text-secondary mr-2"> Prenom: </strong><?= $prenom ?></span>
        <button class="btn btn-secondary">modifier</button>
    </div>
    <hr>
    <div class="row justify-content-between">
        <span> <strong class="text-secondary mr-2"> Email: </strong><?= $email ?></span>
        <button class="btn btn-secondary">modifier</button>
    </div>
    <hr>
    <div class="row justify-content-between">
        <span> <strong class="text-secondary mr-2"> Civilite: </strong>
            <?php
            if ($civilite == "m") {
                echo 'homme';
            } else {
                echo 'femme';
            }
            ?>
        </span>
        <button class="btn btn-secondary">modifier</button>
    </div>
    <hr>
   

    <div class="row justify-content-between">
        <span> <strong class="text-secondary mr-2">Adresse: </strong><?= $adresse ?></span>
        <button class="btn btn-secondary">modifier</button>
    </div>
    <hr>
    <div class="row justify-content-between">
        <span><strong class="text-secondary mr-2">Ville: </strong><?= $ville ?></span>
        <button class="btn btn-secondary">modifier</button>
    </div>
    <hr>
    <div class="row justify-content-between">
        <span> <strong class="text-secondary mr-2">Code Postal: </strong><?= $code_postal ?></span>
        <button class="btn btn-secondary">modifier</button>
    </div>

        </div>






</div>


        -->


        <h1 class="display-4 text-center my-4">Bienvenue <strong class="text-success"><?= $membre['pseudo'] ?></strong> !! Détail de votre profil</h1><hr>

<ul class="col-md-4 offset-md-4 list-group">
    <li class="list-group-item bg-dark text-center text-white">DETAIL DE VOTRE COMPTE</li>
    <?php foreach($membre as $key => $value): ?>

        <?php if($key != 'id_membre' && $key != 'statut'): ?>

            <li class="list-group-item text-center"><?= $key ?> : <strong><?= $value ?></strong></</li>

        <?php endif; ?>

    <?php endforeach; ?>
    <li class="list-group-item bg-secondary text-center text-white"><a href="#" class="alert-link text-white">MODIFIER DE VOTRE COMPTE</a></li>
</ul>



<?php
require_once('include/footer.php')
?>