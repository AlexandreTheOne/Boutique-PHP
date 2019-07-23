<?php
require_once('../include/init.php');
extract($_POST);
extract($_GET);
//--------------------------- VERIFICATION ADMIN
//si le visiteur n'est pas connecté et n'est pas ADMIN, il n'a rien à faire ici, on le redirige vers la page de connexion
if (!internauteEstConnecteEtEstAdmin()) {
    header("Location: " . URL . "connexion.php");
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
}
//-----------SUPRESSION D'UN PRODUIT

// On entre dans le IF seulement dans le cas où on a cliqué sur le lien "suppression"

// On vérifie si l'indice 'action' est bien définit dans l'URL et qu'à cet indice , il ya our vakeur 'supression', alors on entre dans la condition

if (isset($_GET['action']) && $_GET['action'] == 'suppression') {

    $req1 = "SELECT reference FROM produit WHERE id_produit = :id";
    $select = $bdd->prepare($req1);
    $select->bindValue(':id', $_GET['id_produit'], PDO::PARAM_INT);
    $select->execute();

    echo '<pre>';
    print_r($select);
    echo '</pre>';

    $ref = $select->fetch(PDO::FETCH_ASSOC);

    echo '<pre>';
    print_r($ref);
    echo '</pre>';

    extract($ref);

    // Requête de suppression(requête préparée)
    $req2 = "DELETE FROM produit WHERE id_produit = :id";
    $del = $bdd->prepare($req2);
    $del->bindValue(':id', $_GET['id_produit'], PDO::PARAM_INT);
    $del->execute();

    header("Location: " . URL . "admin/gestion_boutique.php?action=affichage&ref=" . $reference); // $_GET['action'] = 'affichage'; // On redirige vrs l'affichage des produits


}

if (isset($_GET['action']) && isset($_GET['ref'])) {
    extract($_GET);
    $msg .= "<div class='col-md-4 mx-auto alert alert-warning text-center'>Le produit <strong>$ref</strong> a bien été effacé de la base de données !</div>";
}




//---------- ENREGISTREMENT DES PRODUITS

if ($_POST) {
    $photo_bdd = "";


    if (isset($_GET['action']) && $_GET['action'] == 'modification') 
    {
        $photo_bdd = $_POST['photo_actuelle'];
        
    }


    if (!empty($_FILES['photo']['name'])) {
        echo '<pre>';
        print_r($_FILES);
        echo '</pre>';
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';


        //on renomme la photo en concaténant la référenc saisie dans le formulaire rt le nom de la photo pioché dans la superglobale $_FILES
        $nom_photo = $reference . '-' . $_FILES['photo']['name'];
        echo $nom_photo . '<hr>';


        //On définit un URL de la photo , c'est ce que l'on conservera en BDD
        $photo_bdd = URL . "img/$nom_photo";
        echo $photo_bdd . '<hr>';


        //On définit le chemin physique de la photo vers le dossier 'img' sur le serveur
        $photo_dossier = RACINE_SITE . "img/$nom_photo";
        echo $photo_dossier . '<hr>';

        copy($_FILES['photo']['tmp_name'], $photo_dossier); // On fait une copie de la photo grâce à la fonction prédéfinie copy('nom_temporaire', chemin de la photo)


    }

    // ---- Exo : Insertion produit dans la BDD (reqête préparée) 

// On entre dans la condition IF que dans le cas d'un ajout , on contrôle si l'indice 'action' a été envoyé dans l'URL et que pour valeur, il a 'ajout'
    if (isset($_GET['action']) && $_GET['action'] == 'ajout') 
    {
        $req = "INSERT INTO produit (reference,categorie,titre,description,couleur,taille,public,prix,stock,photo) VALUES (:reference,:categorie,:titre,:description,:couleur,:taille,:public,:prix, :stock,:photo)";
        $insert = $bdd->prepare($req);
       $page= 'Ajout';
        $_GET['action'] = 'affichage';

        $msg .= "<div class='col-md-4 mx-auto alert alert-success text-center'>Le produit <strong>$reference</strong> a bien été enregistré !</div>";

    }
     else // Dans tous les autres cas , ce sera une requête de modification
    {
        echo '<pre>';
        print_r($_POST);
        echo $photo_bdd;
        echo '</pre>';
        $page = 'Modification';
        //requête de modifications
        $req = "UPDATE produit SET reference = :reference , categorie = :categorie ,titre = :titre, description = :description ,couleur = :couleur,taille = :taille, public = :public , prix =:prix,stock =:stock,photo = :photo WHERE id_produit = $_GET[id_produit]";
        $insert = $bdd-> prepare($req);

        $_GET['action'] = 'affichage';

        $msg .= "<div class='col-md-4 mx-auto alert alert-success text-center'>Le produit <strong>$reference</strong> a bien été modifié !</div>";



     }

    foreach ($_POST as $key => $value) // On passe en revue la superglobale $_POST donc le formulaire afin de générer les insertions dans les marqueurs
    {


        if (gettype($value) == 'string') // On teste si la valeur et de typer 'STRING'
            $type = PDO::PARAM_STR;
        else // Sinon si c'est un type 'INTEGER' 
            $type = PDO::PARAM_INT;

        if ($key != 'photo_actuelle') // On ejecte le champs 'hidden" du formulaire
        {
            $insert->bindValue(":$key", $value, $type);
        }
    }

    $insert->bindValue(":photo", $photo_bdd, PDO::PARAM_STR);

  

    $insert->execute();

}
require_once('../include/header.php');
?>


<h1 class="text-center display-4 ">Gestion Boutique</h1>
<hr>

<ul class="list-group col-md-4 m-4 mx-auto">
    <li class="list-group-item text-center bg-secondary text-white">BACK OFFICE</li>
    <li class="list-group-item text-center"><a class="text-dark" href="?action=affichage">Affichage produits</a></li>
    <li class="list-group-item text-center"><a class="text-dark" href="?action=ajout">Ajout Produit</a></li>
</ul>




<!---------------- AFFICHAGE DES PRODUITS ----------------->

<!-- 
    Exo : Afficher la table des prduits sous forme de tableau HTML, prevoir 2 colonnes 'modifier'  et 'supprimer' 
-->

<?php

// On entre dans le if seulement dans le cas où l'on a cliqué sur le lien "affichage produit"

// On vérifie si l'indice 'action' est bien définit dans l'URL et qu'à cet indice, il ya l'indice 'affichage'
if (isset($_GET['action']) && $_GET['action'] == 'affichage') :

    $req = "SELECT * FROM produit";
    $select = $bdd->query($req);
    $tab = $select->fetchAll(PDO::FETCH_ASSOC);
    echo '<pre>';
    print_r($tab);
    echo '</pre>';


    ?>








    <h3 class="display-4 text-center">Affichage des produits</h3>
    <hr>
    <?= $msg ?>
    <p class="text-center">Nombre de produits dans la boutique : <span class="badge badge-danger"><?= $select->rowCount() ?></span></p>



    <table class="text-center table table-border">

        <?php foreach ($tab[0] as $key => $value) : ?>
            <th><?= strtoupper($key) ?></th>
            <!--strtoupper() met en majuscule une string-->
        <?php endforeach; ?>
        <th>EDIT</th>
        <th>SUPP</th>
        <!-- $row receptionne un tableau ARRAY d'un employé par tour de boucle -->
        <?php foreach ($tab as $produit) : ?>
            <tr>
                <!-- la 2ème boucle foreach permet de passer en revue chaque tableau ARRAY de chaque emloyé -->
                <?php foreach ($produit as $key => $value) : ?>

                    <?php if ($key == 'photo') : ?>
                        <td><img src="<?= $value ?>" width="50" alt="<?= $produit['titre'] ?>"></td>
                        <!--on stocke chaque information dans une cellule -->
                    <?php else : ?>
                        <td><?= $value ?></td>
                    <?php endif; ?>


                <?php endforeach; ?>
                <td><a class='text-dark' href="?action=modification&id_produit=<?= $produit['id_produit'] ?>"><i class="fas fa-edit"></a></td>
                <td><a class='text-dark' href="?action=suppression&id_produit=<?= $produit['id_produit'] ?>"><i class="fas fa-trash-alt"></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<!-- <style>
main {
    margin-bottom : 100px;
}
</style> -->




<!---------------- AFFICHAGE DU FORMULAIRE POUR INSERER UN PRODUIT DANS LA BDD ----------------->
<?php if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) :

    if (isset($_GET['id_produit'])) // On contrôle que l'indice 'id_produit' a bien été envoyé dans l'URL, cela vut dire que l'on a cliqué sur le bouton modification
    {
        $result = $bdd->prepare("SELECT* FROM produit WHERE id_produit = :id_produit");
        $result->bindValue('id_produit', $_GET['id_produit'], PDO::PARAM_INT);
        $result->execute();

        $produit_actuel = $result->fetch(PDO::FETCH_ASSOC);

        echo '<pre>';
        print_r($produit_actuel);
        echo '</pre>';
    }
    if (isset($_GET['action']) && ($_GET['action'] == 'modification')) {


        // On passe en revue le produit actuel pour crée une variable
        foreach ($produit_actuel as $key => $value) {
            $$key = (isset($produit_actuel[$key])) ? $produit_actuel[$key] : "";
        }
        // 1er toutde boucle 
        //$id_produit= (isset($produit_actuel['id_produit'])) ? $produit_actuel['id_produit']: "";
        //ect....
        //$$key : on utilise la valeur renvoyée par $key pour en faire un nom de variable
    }


    ?>
    <!--
    1.Réaliser un formulaire HTML correspondant à la table "produit" (sauf 'id_produit')
    2. print_r($_POST)
-->
    <h1 class="display-4 text-center"> <?= $_GET['action'] ?> d'un produit</h1> <!-- ucfirst(): fonction qui met la 1ère lettre en majuscule --->
    
    <hr>
    <form method="post" enctype="multipart/form-data" class="col-md-6 offset-md-3">
        <div class="form-group">
            <label for="reference">Référence</label>
            <input type="text" class="form-control" id="reference" name="reference" placeholder="Saisir votre référence" value="<?php if (isset($reference)) echo $reference; ?>">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="categorie">Catégorie</label>
                <input type="text" class="form-control" id="categorie" name="categorie" placeholder="Saisir votre catégorie" value="<?php if (isset($categorie)) echo $categorie; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" placeholder="Confirmer votre titre" value="<?php if (isset($titre)) echo $titre; ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Saisir votre nom" value="<?php if (isset($description)) echo $description; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="couleur">Couleur</label>
                <input type="text" class="form-control" id="couleur" name="couleur" placeholder="Saisir votre prénom" value="<?php if (isset($couleur)) echo $couleur; ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="taille">Taille</label>
                <select id="taille" class="form-control" name="taille">
                    <option value="s" <?php if (isset($taille) && $taille == 's') echo 'selected'; ?>>S</option>
                    <option value="m" <?php if (isset($taille) && $taille == 'm') echo 'selected'; ?>>M</option>
                    <option value="l" <?php if (isset($taille) && $taille == 'l') echo 'selected'; ?>>L</option>
                    <option value="xl" <?php if (isset($taille) && $taille == 'xl') echo 'selected'; ?>>XL</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="public">Public</label>
                <select id="public" class="form-control" name="public">
                    <option value="m" <?php if (isset($public) && $public == 'm') echo 'selected'; ?>>Homme</option>
                    <option value="f" <?php if (isset($public) && $public == 'f') echo 'selected'; ?>>Femme</option>
                    <option value="mixte" <?php if (isset($public) && $public == 'mixte') echo 'selected'; ?>>Mixte</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group col-md-6">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        <?php if (!empty($photo)) : ?>
            <em>Vous pouvez uploader une nouvelle photo si vous souhaitez la changer</em>
            <div class="col-md-12 text-center mb-5"><img src="<?= $photo ?>" alt="<?php if (isset($titre)) echo $titre; ?>"> </div>
            <hr>
        <?php endif; ?>

        <!-- Le champ type 'hidden' permettra de récupérer l'URL de la photo actuelle du produit si l'internaute ne modifie pas la photo (impossible de récupérer la valeur dans un champ de type 'file') -->
        <input type="hidden" id="photo_actuelle" name="photo_actuelle" value="<?php if (isset($photo)) echo $photo ?>">


        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="prix">Prix</label>
                <input type="text" class="form-control" id="prix" name="prix" placeholder="Saisir votre prix" value="<?php if (isset($prix)) echo $prix; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="stock">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" placeholder="Saisir votre stock" value="<?php if (isset($stock)) echo $stock; ?>">
            </div>
        </div>
        <button type="submit" class="col-md-12 btn btn-dark my-4"><?= ucfirst($_GET['action']);?></button>
    </form>
    <?= $msg ?>
<?php endif; ?>
<?php
require_once('../include/footer.php');
?>