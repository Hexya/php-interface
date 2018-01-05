<?php
  if(file_exists('./inc/protect.inc.php')){
    include('./inc/protect.inc.php');
  }
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <?php
     if(file_exists('./inc/head.inc.php')){
       include('./inc/head.inc.php');
     }?>
     <script type="text/javascript" src="./js/form.js"></script>
   </head>
   <body>
       <div class="container bg-grey">
         <header class="row">ADMIN</header>
         <?php include('./inc/bande-log.inc.php'); ?>
         <div class="row">
         <div class="col-xs-3">
           <?php include('./inc/nav.inc.php'); ?>
         </div>
         <div class="col-xs-9"></div>

         <div class="formulaire">
           <?php
             if (isset($_SESSION['msg_error'])) {
               echo $_SESSION['msg_error'];
               // echo '<script type="text/javascript">alert("'.$_SESSION['msg_error'].'");</script>';
               unset($_SESSION['msg_error']);
             }
            ?>
           <h3>Ajouter un utilisateur:</h3>

         <form class="" action="../core/libs/contenus-services.php" method="post" enctype="multipart/form-data">
         <input type="hidden" name="action" value="add-contenus">
           <div class="form-group">
              <label for="">Titre:</label>
              <input type="text" name="titre" class="form-control" required>
           </div>
           <div class="form-group">
              <label for="">Sous-titre:</label>
              <input type="text" name="ss_titre" class="form-control" required>
           </div>
           <div class="form-group">
              <label for="">Text court:</label>
              <textarea name="txt_court" class="form-control"></textarea>
           </div>
           <div class="form-group">
              <label for="">Text long:</label>
              <textarea name="txt_long" class="form-control"></textarea>
           </div>
           <div class="Avatar(png,jpg)">
              <label for="">Image 1:</label>
              <input type="file" name="img1" class="form-control" accept="image/jpeg,image/jpg,image/png,image/JPEG,image/JPG,image/PNG">
           </div>
           <div class="Avatar(png,jpg)">
              <label for="">Image 2:</label>
              <input type="file" name="img2" class="form-control" accept="image/jpeg,image/jpg,image/png,image/JPEG,image/JPG,image/PNG">
           </div>
           <div class="form-group checkbox">
             <label><input name="active" type="checkbox" checked>Publié</label>
           </div>
           <div class="form-group">
              <label for="">Categories:</label>
              <select name="categorie" class="form-control" >

                  <?php
                   //On recupere la liste des catégorie site
                   //1 connexion
                   require("../core/libs/connexion.php");
                   //2 Ecrire la requete
                   $sql= "SELECT * FROM categories ORDER BY cat_nom ASC";
                   //3 Executer la requete
                   $req = mysqli_query($connexion, $sql) or die(mysqli_eror($connexion));
                   //4 Traitements des données
                      //Boucle sur les entrées remontées de la BDD
                      while($cat = mysqli_fetch_array($req)){

                        echo "<option value='".$cat['cat_id']."' >".$cat['cat_nom']."</option>";

                      }
                    ?>

              </select>
           </div>
           <div class="form-group">
              <input type="submit" value="Ajouter" class="btn btn-primary">
           </div>

         </form>
     </div>

   </body>
 </html>
