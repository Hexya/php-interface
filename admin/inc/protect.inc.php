<?php
session_start();
// echo "<p style='color:white;'>".$_SESSION['user']['islog']."</p>";
//On verifie que islog est true sinon on renvoi a l'index
if (empty($_SESSION['user']['islog'])) {
  header('Location:index.php');
} else {
  if ($_SESSION['user']['islog']!=true) {
    header('Location:index.php');
  }
}
?>
