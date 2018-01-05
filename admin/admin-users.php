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
           <h3>Administrer les utilisateurs:</h3>
           <!-- <div class="menu-top"><p>Avatar</p><p>Name</p><p>Last name</p></div> -->
           <div class="placement-tri">
             <form action="" method="GET" id="filtre">

                 <select onchange="filtre();" name="r">
                     <?php
                        if(empty($_GET['r'])){
                            echo '<option value="all">Tous</option>
                            <option value="1">Utilisateur</option>
                            <option value="2">Administrateur</option>';
                        }else{
                            if($_GET['r']=="1"){
                                echo ' <option value="all">Tous</option>
                                <option value="1" selected>Utilisateur</option>
                                <option value="2">Administrateur</option>';
                            }
                            if($_GET['r']=="2"){
                             echo ' <option value="all">Tous</option>
                             <option value="1" >Utilisateur</option>
                             <option value="2" selected>Administrateur</option>';
                            }
                            if($_GET['r']=="all"){
                             echo '<option value="all" selected>Tous</option>
                             <option value="1">Utilisateur</option>
                             <option value="2">Administrateur</option>';
                            }
                        }
                     ?>

                 </select>
             </form>
         </div>

           <?php
           //On récupère la liste des utilisateurs du site
           //1 Connexion
           require('../core/libs/connexion.php');
           //2 Ecrire la requète
           $sql = 'SELECT usr_id,usr_nom,usr_prenom,usr_avatar FROM users ORDER BY usr_nom ASC';
           if(empty($_GET['r']) ){
                $sql = 'SELECT usr_id,usr_nom,usr_prenom,usr_avatar FROM users ORDER BY usr_nom ASC';
           }else{
             if($_GET['r']=="all"){
               $sql = 'SELECT usr_id,usr_nom,usr_prenom,usr_avatar FROM users ORDER BY usr_nom ASC';
             }else{
                  $sql = 'SELECT usr_id,usr_nom,usr_prenom,usr_avatar FROM users WHERE usr_role='.($_GET['r']-1).' ORDER BY usr_nom ASC';
             }

           }
            //On recupere la liste des utilisateurdu site
            //1 connexion
            require("../core/libs/connexion.php");
            //2 Ecrire la requete
            //////// AFFICHE TOUTE LES INFOS SANS TRIER /////////
            // $sql = 'SELECT usr_id,usr_nom,usr_prenom,usr_avatar FROM users ORDER BY Usr_nom ASC';
            //3 Executer la requete
            $req = mysqli_query($connexion, $sql) or die(mysqli_eror($connexion));
            //4 Traitements des données
            if(mysqli_num_rows($req)===0) { //Nombre de ligne que que renvoi la requete nb id
              echo 'Aucun utilisateur trouvé';
            } else {
              $i=0;
              while ($user = mysqli_fetch_array($req)) { //On separe les ligne
                ($i%2 == 0) ? $class='alt1' : $class='alt2';
                echo "<div class='".$class."'><img class='avatar-img' src='../images/avatars/".$user['usr_avatar']."'> ".$user['usr_nom']." - ".$user['usr_prenom']."
                <div class='delete-edit pull-right'>
                <a href='./edit-user.php?id=".$user['usr_id']."'><span class='glyphicon glyphicon-pencil'></span></a>
                <a href='../core/libs/users-services.php?action=delete-user&id=".$user['usr_id']."'><span class='glyphicon glyphicon-trash'></span></a>
                </div>
                </div>";
                $i++;
              }
            }

            ?>
         </div>
   </body>
 </html>
