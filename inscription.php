<?php

require_once('include/init.php');

//Si l'internaute,est connecté, il n'a rien à faire sur la page connexion, on le redirige vers la page profil.php

if(internauteEstConnecte())
{
    header("Location:" . URL . "profil.php"); 
}

if ($_POST) {

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    extract($_POST);

    /*
        1. Réaliser un formulaire HTML qui correspond à la table 'membre de la BDD 'site' (sauf id_membre et statut)
        2. Contrôler en PHP que l'on réceptionne bien toute les données du formulaire
        3. COntrôler la validité du pseudo et de l'email
    */



    $result = $bdd->prepare("SELECT * FROM membre WHERE email = :email || pseudo = :pseudo");
    $result->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $result->bindValue(':email', $email, PDO::PARAM_STR);
    $result->execute();

    $row = $result->rowCount();

    if ($row > 0) {
        $error .= "<div class='col-md-6 offset-md-3 alert alert-danger text-center'>Un compte est déja existant, vérifier le pseudo <strong>$pseudo</strong> ou l'email <strong>$email</strong></div>";
    }

    // 4. Faites en sorte d'informer l'internaute si les mots de passe ne sont pas identiques 

    if ($mdp !== $mdpbis) {
        $error .= "<div class='col-md-6 offset-md-3 alert alert-danger text-center'>Vos mots de passe ne sont pas identiques</div>";
    }




    //5.  S'il n'y a pas d'erreurs , formuler les reqête d'insertion (requête préparée)
    if (!$error) 
    {
       // $mdp = password_hash($mdp,PASSWORD_DEFAULT);
        $_POST['mdp'] = password_hash($_POST['mdp'],PASSWORD_DEFAULT);// On ne conserve jamais le mot de passe en clair dans la BDD
        //password_hash() permet de créer un clé de hachage
        //password_verify() permet de comparer une clé de hachage à une chaîne de caractère


        $req = "INSERT INTO membre (pseudo,mdp,nom, prenom,civilite, email, code_postal,adresse,ville) VALUES (:pseudo, :mdp, :nom, :prenom ,:civilite,:email, :code_postal, :adresse, :ville)";

        $insert = $bdd->prepare($req);

        foreach ($_POST as $key => $value) // On passe en revue la superglobale $_POST donc le formulaire afin de générer les insertions dans les marqueurs
        {
            if ($key != 'mdpbis') // On ejecte le champ 'mdpbis'
            {
                if (gettype($value) == 'string') // On teste si la valeur et de typer 'STRING'
                    $type = PDO::PARAM_STR;
                else // Sinon si c'est un type 'INTEGER' 
                    $type = PDO::PARAM_INT;

                $insert->bindValue(":$key", $value, $type);
            }
        }



        $insert->execute(); // on execute la requete
     //   header("location:".URL."connexion.php?inscription=valid");// une fois l'insertion executée, on redirige l'internaute vers la page connexion
    }
    


}
require_once('include/header.php');
?>



<h1 class="display-4 text-center">Inscription</h1><hr>
<?= $error ?>
<form method="POST" action="" class="col-md-6 offset-md-3  alert alert-primary">
    <div class="form-group">
        <label for="pseudo">Pseudo</label>
        <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Saisir votre pseudo">
    </div>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="mdp">Mot de passe</label>
            <input type="text" class="form-control" id="mdp" name="mdp" placeholder="Saisir votre mot de passe">
        </div>
        <div class="form-group col-md-6">
            <label for="mdpbis">Confirmation Mot de passe</label>
            <input type="text" class="form-control" id="mdpbis" name="mdpbis" placeholder="Confirmer votre mot de passe">
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Saisir votre nom">
        </div>

        <div class="form-group col-md-6">
            <label for="prenom">Prenom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Saisir votre prénom">
        </div>
    </div>
    <hr>
    <div class="form-row justify-content-around">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="civilite" id="f" value="f">
            <label class="form-check-label" for="f">Femme</label>
        </div>
        <div class="form-check form-check-inline ">
            <input class="form-check-input" type="radio" name="civilite" id="m" value="m">
            <label class="form-check-label" for="m">Homme</label>
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Saisir votre e-mail">
        </div>
        <div class="form-group col-md-6">
            <label for="adresse">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Saisir votre adresse">
        </div>
    </div>
    <hr>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="ville">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" placeholder="Saisir votre ville">
        </div>
        <div class="form-group col-md-6">
            <label for="code_postal">Code Postal</label>
            <input type="text" class="form-control" id="code_postal" name="code_postal" placeholder="Saisir votre code postal">
        </div>
    </div>








    <button type="submit" class="col-md-12 btn btn-primary">Inscription</button>

    <!-- Il ne faut surtout pas oublier les attributs 'name' sur le formulaire HTML-->
</form>






<?php
require_once('include/footer.php');
?>