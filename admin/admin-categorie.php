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
           <h3>Administrer les catégories:</h3>
           <div class="placement-tri">
             <select id="change-cat" onchange="filtreCat();">
               <option value="all">Toutes</option>
               <option value="0">Inactive</option>
               <option value="1">Active</option>

             </select>
           </div>
           <?php
            //On recupere la liste des catégorie site
            //1 connexion
            require("../core/libs/connexion.php");
            //2 Ecrire la requete
            $sql= "SELECT * FROM categories ORDER BY cat_nom ASC";
            //3 Executer la requete
            $req = mysqli_query($connexion, $sql) or die(mysqli_eror($connexion));
            //4 Traitements des données
            if(mysqli_num_rows($req)>0){
               //Boucle sur les entrées remontées de la BDD
               while($cat = mysqli_fetch_array($req)){
                   //Avec un if on vérifie si la catégorie est active ou non
                   //en fonction de cela on détermine une variable $class à la active ou
                   //no-active, ces valeurs servirons au filtre javascript :)
                    if($cat['cat_active']==1){
                        $class="active";
                    }else{
                        $class="no-active";
                    }
                echo "<div class='div-cat ".$class."'><img class='avatar-img' src='../images/photoCat/".$cat['cat_img']."'> ".$cat['cat_nom']."
                <div class='delete-edit pull-right'>
                <a href='./edit-categorie.php?id=".$cat['cat_id']."'><span class='glyphicon glyphicon-pencil'></span></a>
                <a href='../core/libs/categories-services.php?action=delete-cat&id=".$cat['cat_id']."'><span class='glyphicon glyphicon-trash'></span></a>
                </div>
                </div>";
                $i++;
              }
            }
            ?>
         </div>
   </body>
 </html>
