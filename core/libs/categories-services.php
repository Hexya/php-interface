<?php
  //Démarage de la session (tableau de mémorisation de données pour
  //les rendres accessibles de page en page)
  //Le démarage de session doit toujours etre la première commande exécutée
  session_start();
  // $_POST['nom de la variable']
  // $_GET['nom de la variable']
  // $_SESSION['nom de la variable']
  // echo $_POST['action'];

  //Analyse de la variable action pouvant etre recu en POST ou en GlobIterator
  $action="";
  if(isset($_POST['action'])){
    $action = $_POST['action'];
  }
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
  }
  switch($action) {
    case 'add-categorie':
    addCat();
    break;
    case 'delete-cat':
    deleteCat();
    break;
    case 'modify-categorie':
    modifyCat();
    break;
    default:
    //Aucune valeur de la variable action identifiés
    //on renvoir a la home page du site
    header('Location:../../index.php');
  }
  //METHODES DU SERVICE
  function modifyCat() {
    //1 Connexion
    require('connexion.php');
    //2 requete
    //Specialchars protection injection
    $active = 0;
    if(!empty($_POST['active'])){
       $active = 1;
    }
    $nom = mb_convert_case(htmlspecialchars(addslashes($_POST['nom'])),MB_CASE_TITLE, 'utf-8');// Recup le name de l'input firstMaj
    $sql = 'UPDATE categories SET cat_nom="'.$nom.'", cat_active='.$active.' WHERE cat_id='.$_POST['id'];
    //3 Execution requete
    mysqli_query($connexion,$sql) or die(mysqli_error($connexion));

    //4 Gestion photo
      //Supression de l'ancien si existant
    if(!empty($_FILES['photo']['tmp_name'])){
      if(file_exists('../../images/photoCat/cat_img_'.$_POST['id'].'.jpg')) {
        unlink('../../images/photoCat/cat_img_'.$_POST['id'].'.jpg');
      }
      if(file_exists('../../images/photoCat/cat_img_'.$_POST['id'].'.jpeg')) {
        unlink('../../images/photoCat/cat_img_'.$_POST['id'].'.jpeg');
      }
      if(file_exists('../../images/photoCat/cat_img_'.$_POST['id'].'.png')) {
        unlink('../../images/photoCat/cat_img_'.$_POST['id'].'.png');
      }
      //Remplacement
      //On récupère l'extension
      $ext = pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION);
      //On déplace le fichier
      $nom = 'cat_img_'.$_POST['id'].'.'.$ext;
      move_uploaded_file($_FILES['photo']['tmp_name'], '../../images/photoCat/'.$nom);
      //5 Mise à jour du nom de l'image dans la BDD pour l'utilisateur que l'on vient de créer
      $sql ='UPDATE categories SET cat_img="'.$nom.'" WHERE cat_id='.$_POST['id'];
      mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    }
    $_SESSION['msg_error'] = "Catégorie modifié";
    header('Location:'.$_SERVER['HTTP_REFERER']);
  }

  function deleteCat() {
    //1 Connexion
    require("connexion.php");
    //2 Requete
    $sql = 'DELETE FROM categories WHERE cat_id='.$_GET['id'];
    //3 Execution
    mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
    //3bis Supression avatar si up
    if(file_exists('../../images/photoCat/cat_img_'.$_GET['id'].'.jpg')) {
      unlink('../../images/photoCat/cat_img_'.$_GET['id'].'.jpg');
    }
    if(file_exists('../../images/photoCat/cat_img_'.$_GET['id'].'.jpeg')) {
      unlink('../../images/photoCat/cat_img_'.$_GET['id'].'.jpeg');
    }
    if(file_exists('../../images/photoCat/cat_img_'.$_GET['id'].'.png')) {
      unlink('../../images/photoCat/cat_img_'.$_GET['id'].'.png');
    }
    //4 Message
    $_SESSION['msg_error'] = "Catégorie bien suprimé.";
    header('Location:'.$_SERVER['HTTP_REFERER']);
  }


  function addCat(){
    //1 connexion
    require("connexion.php");
    //2 requete
    //Specialchars protection injection
    $nom = mb_convert_case(htmlspecialchars(addslashes($_POST['nom'])),MB_CASE_TITLE, 'utf-8');// Recup le name de l'input firstMaj
    if(empty($_POST['active'])){
        $sql='INSERT INTO categories (cat_nom, cat_active) VALUES ("'.$nom.'", 0)';
    }else{
        $sql='INSERT INTO categories (cat_nom) VALUES ("'.$nom.'")';
    }
    $sql ='INSERT INTO categories(cat_nom) VALUES("'.$nom.'")';
    //3 Execution de la requete
    mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    //On recupere le dernier id inséré dans la table à la requete, une ligne au dessus
    $id = mysqli_insert_id($connexion);
    //4 Traitement du fichier joint
    //Vérifie s'il y a eu un fichier d'uploader
    if(isset($_FILES['photo']['tmp_name'])){
      //On récupère l'extension
      $ext = pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION);
      //On déplace le fichier
      $nom = 'cat_img_'.$id.'.'.$ext;
      move_uploaded_file($_FILES['photo']['tmp_name'], '../../images/photoCat/'.$nom);
      //5 Mise à jour du nom de l'image dans la BDD pour l'utilisateur que l'on vient de créer
      $sql ='UPDATE categories SET cat_img="'.$nom.'" WHERE cat_id='.$id;
      mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    }
    //X Redirection
    $_SESSION['msg_error'] ="Catégorie ajouté!";
    header('Location:'.$_SERVER['HTTP_REFERER']);

  }

?>
