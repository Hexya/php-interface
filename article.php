<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
    if(file_exists('./inc/head.inc.php')){
      include('./inc/head.inc.php');
    }?>
  </head>
<body>
  <header>
    <nav id="nav-principal">
    <ul class="dropdown">
      <li> <a href="index.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Acceuil</a></li>
      <li> <span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Catégorie
        <ul class="sous-menu">
          <?php
           //On recupere la liste des catégorie site
           //1 connexion
           require("./core/libs/connexion.php");
           //2 Ecrire la requete
           $sql= "SELECT * FROM categories ORDER BY cat_nom ASC";
           //3 Executer la requete
           $req = mysqli_query($connexion, $sql) or die(mysqli_eror($connexion));
           //4 Traitements des données
              //Boucle sur les entrées remontées de la BDD
              while($cat = mysqli_fetch_array($req)){

                echo "<li><a href='contenu.php?idcat=".$cat['cat_id']."'>".$cat['cat_nom']."</a></li>";
              }
            ?>
        </ul>
      </li>
    </ul>
  </nav>
  </header>
  <div class="container">
    <div class="center-content">
      <div class="article">

      <?php
      //On récupère la liste des utilisateurs du site
      //1 Connexion

       //On recupere la liste des utilisateurdu site
       //1 connexion
       require("./core/libs/connexion.php");
       //2 Ecrire la requete
       //////// AFFICHE TOUTE LES INFOS SANS TRIER /////////
       // $sql = 'SELECT usr_id,usr_nom,usr_prenom,usr_avatar FROM users ORDER BY Usr_nom ASC';
       $sql= "SELECT * FROM contenus WHERE cont_id = ".$_GET['idcat']." ORDER BY cont_titre ASC";
       //3 Executer la requete
       $req = mysqli_query($connexion, $sql) or die(mysqli_eror($connexion));
       //4 Traitements des données
       if(mysqli_num_rows($req)===0) { //Nombre de ligne que que renvoi la requete nb id
         echo 'Aucun contenu trouvéuh';
       } else {
         $i=0;
         while ($cont = mysqli_fetch_array($req)) { //On separe les ligne
           ($i%2 == 0) ? $class='cont1' : $class='cont2';
           echo "<div class='article-target'><img class='avatar-img' src='./images/imgCont/".$cont['cont_img1']."'> <span>".$cont['cont_titre']."</span> ".$cont['cont_ss_titre']."
           <div class='delete-edit pull-right'>
           </div>
           <p>".$cont['cont_txt_court']."</p>
           <p>".$cont['cont_txt_long']."</p>
           <div class='cont-img2'>
             <img class='avatar-img2' src='./images/imgCont/".$cont['cont_img2']."'>
           </div>
           <div class='pdf'><p>Download</p></div>
           </div>";
           $i++;
         }
       }

       ?>
     </div>
    </div>
  </div>
  <!-- $_GET['idcat'] -->

</body>
</html>
