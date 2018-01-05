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
  <div class="home">
    <p>THIS IS THE <span>HOME</span> MOTHA F***A</p>
  </div>

</body>
</html>
