<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require '../core/Autoloader.php';
    Autoloader::register();
    $h = new Head();
   ?>
</head>
<body>
  <?php
    // Instanciation d'un Manager pour récupérer les données
    $dm=new DataManager();
    $userDatas=$dm->getData('users','usr_id',$_GET['id']);
    $u=new User($userDatas);
    $u->displayInfos("form");
   ?>
</body>
</html>
