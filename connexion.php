<?php
require_once('include/init.php');
extract($_POST);
// si l'indice 'action' est definit dans l'URL, cela veut dire que l'on a clique sur le lien deconnexion et dans ce cas là, on supprime la session
if(isset($_GET['action']) && $_GET['action']=='deconnexion')
{
    extract ($_GET);


    session_destroy();
}
if (isset($action)){
    echo "deco";
}
//Si l'internaute,est connecté, il n'a rien à faire sur la page connexion, on le redirige vers la page profil.php

if(internauteEstConnecte())
{
    header("Location:" . URL . "profil.php"); 
}

//-------------MESSAGE VALIDATION INSCRIPTION

if(isset($_GET['inscription']) && $_GET['inscription'] == 'valid')
{
    $content .= "<div class='col-md-6 offset-md-3 mt-4 alert alert alert-success text-center'>Vous êtes maintenant inscrit sur notre site ! Vous pouvez dès à présent vous connecter !</div>";
}


if($_POST)
{
    $verif = $bdd->prepare("SELECT * FROM membre WHERE email = :email || pseudo = :pseudo");
    $verif -> bindValue(':email', $pseudo_email, PDO::PARAM_STR);
    $verif -> bindValue(':pseudo',$pseudo_email,PDO::PARAM_STR);
    $verif->execute();

    if($verif->rowCount()>0)
    {
        $membre = $verif->fetch(PDO::FETCH_ASSOC);
        echo'<pre>'; print_r($membre); echo '</pre>';
        //if (password_verify($mdp,$membre['mdp'])) // si password hashé dans la page inscrption , permet de comparer un clé de hachage en BDD par rapport à la donnée saisie dans le champ 'mdp
        //if($mdp == $membre['mdp'])
        if (password_verify($mdp,$membre['mdp'])) // Si le mot de passe est correcte on entre dans le IF
        {
           //echo 'mdp OK!!';
           //On parcours les données récupérées en BDD
           foreach($membre as $key => $value)
           {
               if($key != 'mdp') // On exclue le mot de passe
               {
                   $_SESSION['membre'][$key] = $value; // On crée dans le fichier SESSION, un indice 'membre' dans lequel est stocké toute les données de l'internaute
               }
           }
           header("Location:".URL. "profil.php"); // Une fois la connexion reussie, on redirige l'internaute vers sa page profil
           echo'<pre>'; print_r($_SESSION); echo '</pre>';
        }
        else // On tombe dans le else dans le cas où l'internaute a saisi un mauvais mot de passe
        {
            $error .= "<div class='col-md-4 offset-md-4 alert alert-danger text-center'><strong>Mot de passe erroné</strong></div>";
        }
    }
    else  // on tombe dans le else dans le cas ou l'internaute a saisie un mauvais email
    {
      $error .= "<div class='col-md-4 offset-md-4 alert alert-danger text-center'><strong>Pseudo ou Email inexistant!!</strong></div>";
    }
}


require_once('include/header.php');

?>
<h1 class='display-4 text-center'>Connexion</h1><hr>
<?= $content ?>
<?= $error ?>
<form method="post" action="" class="col-md-4 offset-md-4 text-center alert alert-primary">
<div class="form-group">
        <label for="pseudo_email">Pseudo ou E-mail</label>
        <input type="text" class="form-control" id="pseudo_email" name="pseudo_email" placeholder="Saisir votre Pseudo ou Email">
    </div>
    <div class="form-group">
        <label for="mdp">Mot de passe</label>
        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Saisir votre mot de passe">
    </div>
    <button type="submit" class="col-md-12 btn btn-primary">Connexion</button>









</form>

<?php
require_once('include/footer.php');
?>