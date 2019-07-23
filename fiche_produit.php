<?php
/* Réaliser une fiche produit avec les informations suivantes :image titre couleur description tailles, public, prix*/


require_once("./include/init.php");

if(isset($_GET['id_produit']))
{
    $req = "SELECT * FROM produit WHERE id_produit=:id_categorie";
    $select = $bdd->prepare($req);
    $select->bindValue(":id_categorie",$_GET['id_produit'], PDO::PARAM_INT);
    $select-> execute();

    if($select->rowCount()==0)
    {
        header("Location:boutique.php");
        exit();
    }



    $fiche = $select->fetch(PDO::FETCH_ASSOC);

    echo "<pre>";print_r($fiche) ;echo "</pre>";

    extract($fiche);

    if ($select->rowCount() == 0)
    {
        header("Location:boutique.php ");
        exit();
    }


}



require_once("./include/header.php");
?>


<div class="container">

    <div class="row">

      <div class="col-lg-3">
        <h1 class="my-4">Shop Name</h1>
        <div class="list-group">
          <a href="#" class="list-group-item active">Category 1</a>
          <a href="#" class="list-group-item">Category 2</a>
          <a href="#" class="list-group-item">Category 3</a>
        </div>
      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div class="card mt-4">
          <img class="card-img-top img-fluid" src="<?=$photo?>" alt="">
          <div class="card-body">
            <h3 class="card-title"><?=$titre?></h3>
            <h4><?=$prix?></h4>
            <p class="card-text"><?=$description?></p>
              
          </div>
        </div>
        <div class="card-footer text-center text-white bg-secondary">
            <?php if ($stock>0): ?>
                    
                <form action="panier    .php" method="">
                    <input typ="hidden" name="id_produit" value="<?=$id_produit?>">
                    <select name="" id="exampleFormControlSelect2" class="form-control">
                    <?php
                    for($i=1; $i<=$stock && $i <= 30; $i++) //on stoppe la boucle si la quantité est inférieure a 30
                    {
                        echo "<option>$i</option>";
                    }
                    ?>
                    </select>
                    <button type="submit" class="col-md-12 btn btn-success mt-2">Ajouter au panier</button>
                </form>

            <?php else: ?>
            <p class="text-white">Rupture de Stock</p>
<?php endif; ?>
<a href="boutique.php?categorie=<?=$categorie?>" class="alert-link text-white text-center">Retour vers la catégorie <?=$categorie?></a><hr>
<a href="boutique.php" class="alert-link text-white text-center">Retour vers la boutique </a>


        </div>
        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            Détails
          </div>
          <div class="card-body">
          <strong>Référence: </strong><?=$reference?>
            <hr>
            <strong>Public: </strong><?=$public?>
            <hr>
            <strong>Taille: </strong><?=$taille?>
            <hr>
          
            <strong>Couleur: </strong><?=$couleur?>
            <hr>
            <a href="#" class="btn btn-success">Leave a Review</a>
          </div>
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col-lg-9 -->

    </div>

  </div>








<?php

require_once('include/footer.php');


?>