<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include './inc/head.inc.php';?>
</head>
<body>
  <div class="container">
    <div class="block-log col-xs-12">
      <form action="../core/libs/users-services.php" method="POST">
      <input type="hidden" name="action" value="log-admin" id="log">
          <div class="form-group">
            <?php echo '<label for="log">Identifiant:</label>'; ?>
              <input id="log" value="" type="text" name="identifiant" class="form-control" placeholder="Entrez votre identifiant">
          </div>

          <div class="form-group">
            <label for="pass">Mot de passe:</label>
              <input id="pass" type="password" name="password" class="form-control" placeholder="Mot de passe">
          </div>

        <div class="form-group">
          <input type="submit" value="Se connecter" class="btn btn-default btn-primary" id="validate">
        </div>

      </form>
      <?php
        if (isset($_SESSION['msg_error'])) {
          echo $_SESSION['msg_error'];
          // echo '<script type="text/javascript">alert("'.$_SESSION['msg_error'].'");</script>';
          unset($_SESSION['msg_error']);
        }
       ?>
    </div>
  </div>
</body>
</html>
