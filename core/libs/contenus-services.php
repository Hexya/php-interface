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
    case 'add-contenus':
    addCont();
    break;
    case 'delete-contenus':
    deleteCont();
    break;
    case 'modify-contenus':
    modifyCont();
    break;
    default:
    //Aucune valeur de la variable action identifiés
    //on renvoir a la home page du site
    header('Location:../../index.php');
  }
  //METHODES DU SERVICE
  function modifyCont() {
    //1 Connexion
    require('connexion.php');
    //2 requete
    //Specialchars protection injection
    $titre = mb_convert_case(htmlspecialchars(addslashes($_POST['titre'])),MB_CASE_TITLE, 'utf-8');// Recup le name de l'input firstMaj
    $ss_titre = mb_convert_case(htmlspecialchars(addslashes($_POST['ss_titre'])),MB_CASE_TITLE, 'utf-8'); // like getElementById
    $txt_court = htmlspecialchars(addslashes($_POST['txt_court'])); // like getElementById
    $txt_long = htmlspecialchars(addslashes($_POST['txt_long'])); // like getElementById
    $sql = 'UPDATE contenus SET cont_titre="'.$titre.'", cont_ss_titre="'.$ss_titre.'", cont_txt_court="'.$txt_court.'",
    cont_txt_long="'.$txt_long.'" WHERE cont_id='.$_POST['id'];
    //3 Execution requete
    mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
    //4 Gestion password
    //5 Gestion avatar
      //Supression de l'ancien si existant
    if(!empty($_FILES['img1']['tmp_name'])){
      if(file_exists('../../images/imgCont/cont_img1_'.$_POST['id'].'.jpg')) {
        unlink('../../images/imgCont/cont_img1_'.$_POST['id'].'.jpg');
      }
      if(file_exists('../../images/imgCont/cont_img1_'.$_POST['id'].'.jpeg')) {
        unlink('../../images/imgCont/cont_img1_'.$_POST['id'].'.jpeg');
      }
      if(file_exists('../../images/imgCont/cont_img1_'.$_POST['id'].'.png')) {
        unlink('../../images/imgCont/cont_img1_'.$_POST['id'].'.png');
      }
      //Remplacement
      //On récupère l'extension
      $ext = pathinfo($_FILES['img1']['name'],PATHINFO_EXTENSION);
      //On déplace le fichier
      $nom = 'usr_img1_'.$_POST['id'].'.'.$ext;
      move_uploaded_file($_FILES['img1']['tmp_name'], '../../images/imgCont/'.$nom);
      //5 Mise à jour du nom de l'image dans la BDD pour l'utilisateur que l'on vient de créer
      $sql ='UPDATE contenus SET cont_img1="'.$nom.'" WHERE cont_id='.$_POST['id'];
      mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    }
    if(!empty($_FILES['img2']['tmp_name'])){
      if(file_exists('../../images/imgCont/cont_img2_'.$_POST['id'].'.jpg')) {
        unlink('../../images/imgCont/cont_img2_'.$_POST['id'].'.jpg');
      }
      if(file_exists('../../images/imgCont/cont_img2_'.$_POST['id'].'.jpeg')) {
        unlink('../../images/imgCont/cont_img2_'.$_POST['id'].'.jpeg');
      }
      if(file_exists('../../images/imgCont/cont_img2_'.$_POST['id'].'.png')) {
        unlink('../../images/imgCont/cont_img2_'.$_POST['id'].'.png');
      }
      //Remplacement
      //On récupère l'extension
      $ext = pathinfo($_FILES['img2']['name'],PATHINFO_EXTENSION);
      //On déplace le fichier
      $nom = 'usr_img2_'.$_POST['id'].'.'.$ext;
      move_uploaded_file($_FILES['img2']['tmp_name'], '../../images/imgCont/'.$nom);
      //5 Mise à jour du nom de l'image dans la BDD pour l'utilisateur que l'on vient de créer
      $sql ='UPDATE contenus SET cont_img2="'.$nom.'" WHERE cont_id='.$_POST['id'];
      mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    }
    $_SESSION['msg_error'] = "Contenus modifié";
    header('Location:'.$_SERVER['HTTP_REFERER']);
  }

  function deleteCont() {
    //1 Connexion
    require("connexion.php");
    //2 Requete
    $sql = 'DELETE FROM contenus WHERE cont_id='.$_GET['id'];
    //3 Execution
    mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
    //3bis Supression avatar si up
    if(file_exists('../../images/imgCont/cont_img1_'.$_GET['id'].'.jpg')) {
      unlink('../../images/imgCont/cont_img1_'.$_GET['id'].'.jpg');
    }
    if(file_exists('../../images/imgCont/cont_img1_'.$_GET['id'].'.jpeg')) {
      unlink('../../images/imgCont/cont_img1_'.$_GET['id'].'.jpeg');
    }
    if(file_exists('../../images/imgCont/cont_img1_'.$_GET['id'].'.png')) {
      unlink('../../images/imgCont/cont_img1_'.$_GET['id'].'.png');
    }
    if(file_exists('../../images/imgCont/cont_img2_'.$_GET['id'].'.jpg')) {
      unlink('../../images/imgCont/cont_img2_'.$_GET['id'].'.jpg');
    }
    if(file_exists('../../images/imgCont/cont_img2_'.$_GET['id'].'.jpeg')) {
      unlink('../../images/imgCont/cont_img2_'.$_GET['id'].'.jpeg');
    }
    if(file_exists('../../images/imgCont/cont_img2_'.$_GET['id'].'.png')) {
      unlink('../../images/imgCont/cont_img2_'.$_GET['id'].'.png');
    }
    //4 Message
    $_SESSION['msg_error'] = "Contenus bien suprimé.";
    header('Location:'.$_SERVER['HTTP_REFERER']);
  }


  function addCont(){
    //1 connexion
    require("connexion.php");
    //2 requete
    //Specialchars protection injection
    $titre = mb_convert_case(htmlspecialchars(addslashes($_POST['titre'])),MB_CASE_TITLE, 'utf-8');// Recup le name de l'input firstMaj
    $ss_titre = mb_convert_case(htmlspecialchars(addslashes($_POST['ss_titre'])),MB_CASE_TITLE, 'utf-8'); // like getElementById
    $txt_court = htmlspecialchars(addslashes($_POST['txt_court'])); // like getElementById
    $txt_long = htmlspecialchars(addslashes($_POST['txt_long'])); // like getElementById
    if(empty($_POST['active'])){
      $active=0;
    }else {
      $active=1;
    }
    $sql ='INSERT INTO contenus(cont_titre,cont_ss_titre,cont_txt_court,cont_txt_long,cont_active,cont_categorie)
    VALUES("'.$titre.'","'.$ss_titre.'","'.$txt_court.'","'.$txt_long.'","'.$active.'","'.$_POST['categorie'].'")';
    //3 Execution de la requete
    $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    //On recupere le dernier id inséré dans la table à la requete, une ligne au dessus
    $id = mysqli_insert_id($connexion);
    //IMAGE TRAITER EN JS
    require('../utils/images-manager.php');
    if(!empty($_FILES['img1']['tmp_name'])){
      $imgName = createPictureFromPict($_FILES['img1'],$id,200,200,'content');
      $sql = 'UPDATE contenus SET cont_img1="'.$imgName.'" WHERE cont_id='.$id;
      mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    }
    if(!empty($_FILES['img2']['tmp_name'])){
      $imgName = createPictureFromPict($_FILES['img2'],$id,700,700,'content2');
      $sql = 'UPDATE contenus SET cont_img2="'.$imgName.'" WHERE cont_id='.$id;
      mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    }
    //4 Traitement du fichier joint
    //Vérifie s'il y a eu un fichier d'uploader
    // if(isset($_FILES['img1']['tmp_name'])){
    //   //On récupère l'extension
    //   $ext = pathinfo($_FILES['img1']['name'],PATHINFO_EXTENSION);
    //   //On déplace le fichier
    //   $nom = 'cont_img1_'.$id.'.'.$ext;
    //   move_uploaded_file($_FILES['img1']['tmp_name'], '../../images/imgCont/'.$nom);
    //   //5 Mise à jour du nom de l'image dans la BDD pour l'utilisateur que l'on vient de créer
    //   $sql ='UPDATE contenus SET cont_img1="'.$nom.'" WHERE cont_id='.$id;
    //   mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    // }
    // if(isset($_FILES['img2']['tmp_name'])){
    //   //On récupère l'extension
    //   $ext = pathinfo($_FILES['img2']['name'],PATHINFO_EXTENSION);
    //   //On déplace le fichier
    //   $nom = 'cont_img2_'.$id.'.'.$ext;
    //   move_uploaded_file($_FILES['img2']['tmp_name'], '../../images/imgCont/'.$nom);
    //   //5 Mise à jour du nom de l'image dans la BDD pour l'utilisateur que l'on vient de créer
    //   $sql ='UPDATE contenus SET cont_img2="'.$nom.'" WHERE cont_id='.$id;
    //   mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    // }
    //X Redirection
    $_SESSION['msg_error'] ="Contenus ajouté!";
    header('Location:'.$_SERVER['HTTP_REFERER']);

  }
?>
