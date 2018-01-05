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
    case 'log-admin':
    logAdmin();
    break;
    case 'unlog-admin':
    unlogAdmin();
    break;
    case 'add-user':
    addUser();
    break;
    case 'delete-user':
    deleteUser();
    break;
    case 'modify-user':
    modifyUser();
    break;
    default:
    //Aucune valeur de la variable action identifiés
    //on renvoir a la home page du site
    header('Location:../../index.php');
  }
  //METHODES DU SERVICE
  function modifyUser() {
    //1 Connexion
    require('connexion.php');
    //2 requete
    //Specialchars protection injection
    $nom = mb_convert_case(htmlspecialchars(addslashes($_POST['nom'])),MB_CASE_TITLE, 'utf-8');// Recup le name de l'input firstMaj
    $prenom = mb_convert_case(htmlspecialchars(addslashes($_POST['prenom'])),MB_CASE_TITLE, 'utf-8'); // like getElementById
    $login = htmlspecialchars(addslashes($_POST['login']));// like getElementById
    $email = htmlspecialchars($_POST['email']);// like getElementById
    $role = $_POST['role'];// like getElementById
    $sql = 'UPDATE users SET usr_nom="'.$nom.'", usr_prenom="'.$prenom.'", usr_log="'.$login.'",
    usr_mail="'.$email.'", usr_role="'.$role.'" WHERE usr_id='.$_POST['id'];
    //3 Execution requete
    mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
    //4 Gestion password
    if(isset($_POST['password'])) {
      $password = md5($_POST['password']);// like getElementById
      $sql = 'UPDATE users SET usr_pass="'.$password.'"WHERE usr_id='.$_POST['id'];
      mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
    }
    //5 Gestion avatar
      //Supression de l'ancien si existant
    if(!empty($_FILES['avatar']['tmp_name'])){
      if(file_exists('../../images/avatars/usr_avatar_'.$_POST['id'].'.jpg')) {
        unlink('../../images/avatars/usr_avatar_'.$_POST['id'].'.jpg');
      }
      if(file_exists('../../images/avatars/usr_avatar_'.$_POST['id'].'.jpeg')) {
        unlink('../../images/avatars/usr_avatar_'.$_POST['id'].'.jpeg');
      }
      if(file_exists('../../images/avatars/usr_avatar_'.$_POST['id'].'.png')) {
        unlink('../../images/avatars/usr_avatar_'.$_POST['id'].'.png');
      }
      //Remplacement
      //On récupère l'extension
      $ext = pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);
      //On déplace le fichier
      $nom = 'usr_avatar_'.$_POST['id'].'.'.$ext;
      move_uploaded_file($_FILES['avatar']['tmp_name'], '../../images/avatars/'.$nom);
      //5 Mise à jour du nom de l'image dans la BDD pour l'utilisateur que l'on vient de créer
      $sql ='UPDATE users SET usr_avatar="'.$nom.'" WHERE usr_id='.$_POST['id'];
      mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    }
    $_SESSION['msg_error'] = "Utilisateur modifié";
    header('Location:'.$_SERVER['HTTP_REFERER']);
  }

  function deleteUser() {
    //1 Connexion
    require("connexion.php");
    //2 Requete
    $sql = 'DELETE FROM users WHERE usr_id='.$_GET['id'];
    //3 Execution
    mysqli_query($connexion,$sql) or die(mysqli_error($connexion));
    //3bis Supression avatar si up
    if(file_exists('../../images/avatars/usr_avatar_'.$_GET['id'].'.jpg')) {
      unlink('../../images/avatars/usr_avatar_'.$_GET['id'].'.jpg');
    }
    if(file_exists('../../images/avatars/usr_avatar_'.$_GET['id'].'.jpeg')) {
      unlink('../../images/avatars/usr_avatar_'.$_GET['id'].'.jpeg');
    }
    if(file_exists('../../images/avatars/usr_avatar_'.$_GET['id'].'.png')) {
      unlink('../../images/avatars/usr_avatar_'.$_GET['id'].'.png');
    }
    //4 Message
    $_SESSION['msg_error'] = "Utilisateur bien suprimé.";
    header('Location:'.$_SERVER['HTTP_REFERER']);
  }


  function addUser(){
    //1 connexion
    require("connexion.php");
    //2 requete
    //Specialchars protection injection
    $nom = mb_convert_case(htmlspecialchars(addslashes($_POST['nom'])),MB_CASE_TITLE, 'utf-8');// Recup le name de l'input firstMaj
    $prenom = mb_convert_case(htmlspecialchars(addslashes($_POST['prenom'])),MB_CASE_TITLE, 'utf-8'); // like getElementById
    $login = htmlspecialchars(addslashes($_POST['login']));// like getElementById
    $email = htmlspecialchars($_POST['email']);// like getElementById
    $password = md5($_POST['password']);// like getElementById
    $role = $_POST['role'];// like getElementById
    $sql ='INSERT INTO users(usr_nom,usr_prenom,usr_log,usr_pass,usr_mail,usr_role)
    VALUES("'.$nom.'","'.$prenom.'","'.$login.'","'.$password.'","'.$email.'",'.$role.')';
    //3 Execution de la requete
    mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    //On recupere le dernier id inséré dans la table à la requete, une ligne au dessus
    $id = mysqli_insert_id($connexion);
    //4 Traitement du fichier joint
    //Vérifie s'il y a eu un fichier d'uploader
    if(isset($_FILES['avatar']['tmp_name'])){
      //On récupère l'extension
      $ext = pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);
      //On déplace le fichier
      $nom = 'usr_avatar_'.$id.'.'.$ext;
      move_uploaded_file($_FILES['avatar']['tmp_name'], '../../images/avatars/'.$nom);
      //5 Mise à jour du nom de l'image dans la BDD pour l'utilisateur que l'on vient de créer
      $sql ='UPDATE users SET usr_avatar="'.$nom.'" WHERE usr_id='.$id;
      mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    }
    //X Redirection
    $_SESSION['msg_error'] ="Utilisateur ajouté!";
    header('Location:'.$_SERVER['HTTP_REFERER']);

  }
  function unlogAdmin(){
    //On détruit la session
    session_destroy();
    //Redemarer la session
    session_start();
    //On créer un message
    $_SESSION['msg_error'] = "Vous avez été déconnecté.";
    //Redirection
    header('Location:'.$_SERVER['HTTP_REFERER']);
  }
  function logAdmin(){
    //1 Connexion
    require('connexion.php');
    //2 Selectionner les utilisateurs ayant le log le md5 du password
    //et un role a 1 dans la bdd
    $sql = 'SELECT * FROM users WHERE usr_log="'.$_POST['identifiant'].'" AND usr_pass="'.md5($_POST['password']).'" AND usr_role = 1';
    //3 Execution de la requete
    $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    //4 Traitement des données recus de la base
    //On analyse le nombre de ligne de données renvoyées par la base
      if (mysqli_num_rows($req)==0) {
        //Si 0 on est pas connecté
        //Création d'un message d'Erreur
        $_SESSION['msg_error'] = "Erreur d'identification et/ou de mot de passe.";
        //Redirection vers la page de login
        header('Location:'.$_SERVER['HTTP_REFERER']);
      } else {
          //Sinon on est connecté et on mémorise les données dans une variable de session
          //On agence les données remontées de la base
          $user = mysqli_fetch_array($req);
          //On mémorise le nom et le prénom dans la session dans une entrée nomée 'user'
          //on crée un sous tableau
          $_SESSION['user']['prenom'] = $user['usr_prenom'];
          $_SESSION['user']['nom'] = $user['usr_nom'];
          $_SESSION['user']['log'] = $user['usr_log'];
          $_SESSION['user']['islog'] = true;
          //Redirection vers la page du menu.php du BO
          header('Location:../../admin/menu.php');
      }
  }
?>
