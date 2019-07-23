<?php

require_once('include/init.php');

// 1.récupérer le templte boostrap: https://startbootstrap.com/previews/shop-homepage/

// 2. Placer les images dans le slider

// 3. Faites en sorte de n'avoir qu'une seule card puisque l'on va boucler sur chaque produit

// 4. Afficher à gauche les catégories distinctes da la table produit








$req2 = "SELECT DISTINCT categorie FROM produit";
$select = $bdd->query($req2);
$cat = $select->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>';
print_r($cat);
echo '</pre>';


if (empty($_GET['categorie'])) // Si il n'y a pas de catégorie dans l'url , on selectionne tous les produits , en cas de remiere visite sur la boutique , tous les produits seront affichés
{
$req1 = "SELECT * FROM produit";
$select = $bdd->query($req1);
$tab = $select->fetchAll(PDO::FETCH_ASSOC);
}
else // On entre dans le ELSE seulement dans le cas où l'on a cliqué sur une catégorie, donc que l'on a transmit l'indice 'categorie" dans l'URL
{
    $req1 = "SELECT * FROM produit WHERE categorie=:categorie";
     $select = $bdd->prepare ($req1);
     $select->bindValue (':categorie',$_GET['categorie'],PDO::PARAM_STR);
     $tab = $select->execute();
     $tab = $select->fetchAll(PDO::FETCH_ASSOC);

     if ($select->rowCount() == 0)
     {
         header("Location:boutique.php ");
         exit();
     }
}

require_once('include/header.php');


?>


<div class="container">

    <div class="row">

        <div class="col-lg-3">

            <h1 class="my-4">Shop Name</h1>
            <div class="list-group text-center  ">
                <p class="list-group-item bg-secondary text-white text-center">CATEGORIES</p>
                <?php foreach ($cat as $row) : ?>

                    <a href='?categorie=<?= $row['categorie'] ?>' class="list-group-item text-dark"><?= $row['categorie'] ?></a>

                <?php endforeach; ?>

                <a href="boutique.php" class="list-group-item bg-warning text-dark">Afficher toutes les categories </a>
                 
            </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <!----- Caroussel ---->

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <!----fin du carousel ----->





            <div class="row">

                <?php foreach ($tab as $produit) : extract($produit);/*echo '<pre>';print_r($produit);echo '</pre>';*/ ?>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a href="fiche_produit.php?id_produit=<?=$id_produit?>"><img class="card-img-top" src="<?= $photo ?>" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="fiche_produit.php?id_produit=<?=$id_produit?>"><?= $titre ?></a>
                                </h4>
                                <h5><?= $prix ?> €</h5>
                                <p class="card-text"><?= $description ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="fiche_produit.php?id_produit=<?=$id_produit?>" class="alert-link text-dark">En savoir plus</a>&nbsp;<i class="fas fa-angle-double-right"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>


            </div>
            <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

</div>

<?php

require_once('include/footer.php');


?>