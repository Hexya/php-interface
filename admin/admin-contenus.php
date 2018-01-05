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
           <h3>Administrer les contenus:</h3>
           <!-- <div class="menu-top"><p>Avatar</p><p>Name</p><p>Last name</p></div> -->
           <div class="placement-tri">
             <select id="change-cat" onchange="filtreCat();">
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
           <?php
           //On récupère la liste des utilisateurs du site
           //1 Connexion

            //On recupere la liste des utilisateurdu site
            //1 connexion
            require("../core/libs/connexion.php");
            //2 Ecrire la requete
            //////// AFFICHE TOUTE LES INFOS SANS TRIER /////////
            // $sql = 'SELECT usr_id,usr_nom,usr_prenom,usr_avatar FROM users ORDER BY Usr_nom ASC';
            $sql= "SELECT * FROM contenus ORDER BY cont_titre ASC";
            //3 Executer la requete
            $req = mysqli_query($connexion, $sql) or die(mysqli_eror($connexion));
            //4 Traitements des données
            if(mysqli_num_rows($req)===0) { //Nombre de ligne que que renvoi la requete nb id
              echo 'Aucun contenu trouvé';
            } else {
              $i=0;
              while ($cont = mysqli_fetch_array($req)) { //On separe les ligne
                ($i%2 == 0) ? $class='cont1' : $class='cont2';
                echo "<div class='".$class."'><img class='avatar-img' src='../images/imgCont/".$cont['cont_img1']."'> ".$cont['cont_titre']." - ".$cont['cont_ss_titre']."
                <div class='delete-edit pull-right'>
                <a href='./edit-contenus.php?id=".$cont['cont_id']."'><span class='glyphicon glyphicon-pencil'></span></a>
                <a href='../core/libs/contenus-services.php?action=delete-contenus&id=".$cont['cont_id']."'><span class='glyphicon glyphicon-trash'></span></a>
                </div>
                <p>".$cont['cont_txt_court']."</p>
                <p>".$cont['cont_txt_long']."</p>
                <div class='cont-img2'>
                  <img class='avatar-img2' src='../images/imgCont/".$cont['cont_img2']."'>
                </div>
                </div>";
                $i++;
              }
            }

            ?>
         </div>
   </body>
 </html>
