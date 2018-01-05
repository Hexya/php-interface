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
           <h3>Ajouter une catégorie:</h3>

         <form class="" action="../core/libs/categories-services.php" method="post" enctype="multipart/form-data">
         <input type="hidden" name="action" value="add-categorie">
           <div class="form-group">
              <label for="">Nom:</label>
              <input type="text" name="nom" class="form-control" required>
           </div>

           <div class="Photo(png,jpg)">
              <label for="">Photo:</label>
              <input type="file" name="photo" class="form-control" accept="image/jpeg,image/jpg,image/png,image/JPEG,image/JPG,image/PNG">
           </div>

           <div class="form-group checkbox">
             <label><input name="active" type="checkbox" checked>Active</label>
           </div>
           
           <div class="form-group">
              <input type="submit" value="Ajouter" class="btn btn-primary">
           </div>

         </form>
     </div>

   </body>
 </html>
