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
           <h3>Editer un utilisateur:</h3>
           <?php
            //1 Connexion
            require('../core/libs/connexion.php');
            //2 requete
            $sql = 'SELECT * FROM users WHERE usr_id='.$_GET['id'];
            //3 Execution de la requete
            $req = mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
            //4 On va chercher les donées
            $user = mysqli_fetch_array($req);
            ?>
         <form class="" action="../core/libs/users-services.php" method="post" enctype="multipart/form-data" onsubmit="return checkAddUserForm();">
         <input type="hidden" name="action" value="modify-user">
         <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
           <div class="form-group">
              <label for="">Nom:</label>
              <input type="text" name="nom" class="form-control" value="<?php echo $user['usr_nom'] ?>" required>
           </div>
           <div class="form-group">
              <label for="">Prénom:</label>
              <input type="text" name="prenom" class="form-control" value="<?php echo $user['usr_prenom'] ?>" required>
           </div>
           <div class="form-group">
              <label for="">Identifiant:</label>
              <input type="text" name="login" class="form-control" value="<?php echo $user['usr_log'] ?>" required>
           </div>
           <div class="form-group">
              <label for="">Mot de passe (5 à 10 caractères):</label>
              <input pattern=".{5,10}" type="password" name="password" id="password" class="form-control">
           </div>
           <div class="form-group">
              <label for="">Confirmation du mot de passe:</label>
              <input type="password" name="password-confirm" id="password-confirm" class="form-control">
           </div>
           <div class="form-group">
              <label for="">Email:</label>
              <input type="email" name="email" class="form-control" value="<?php echo $user['usr_mail'] ?>" required>
           </div>
           <div class="form-group">
              <label for="">Avatar(png,jpg):</label>
              <input type="file" name="avatar" class="form-control" accept="image/jpeg,image/jpg,image/png,image/JPEG,image/JPG,image/PNG">
           </div>
           <div class="form-group">
              <label for="">Statut:</label>
              <select name="role" class="form-control" >
                <option value="0">Utilisateur simple</option>
                <?php
                  if($user[usr_role]==1){
                  echo '<option value="1" selected>Administrateur</option>';
                }else {
                  echo '<option value="1">Administrateur</option>';
                }
                 ?>
              </select>
           </div>
           <div class="form-group">
              <input type="submit" value="Modifier" class="btn btn-primary">
           </div>

         </form>
     </div>

   </body>
 </html>
