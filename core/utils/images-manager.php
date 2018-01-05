<?php
  function createPictureFromPict($pFile,$pId,$pW,$pH,$pBaseName) {
    //1 Récup de l'extension du fichier
    $ext = pathinfo($pFile['name'],PATHINFO_EXTENSION);
    //2 Création de copie a l'original
    if(strtolower($ext)=="jpg" || ($ext)=="jpeg") {
      $imageCopy = imageCreateFromJpeg($pFile['tmp_name']);
    }
    if(strtolower($ext)=="png"){
      $imageCopy = imageCreateFromPng($pFile['tmp_name']);
    }
    //3 Analyse du ration de reduction/agrandissement a appliquer a l'image
    list($originalWidth,$originalHeight) = getimagesize($pFile['tmp_name']);
    $ratio =$originalWidth/$pW;
    if($originalHeight/$ratio > $pH){
      $ratio = $originalHeight/$pH;
    }

    $newWidth = floor($originalWidth/$ratio);
    $newHeight = floor($originalHeight/$ratio);
    //4 création d'une image "vide" ou on colle l'original redimensioné
    $finalImg = imagecreatetruecolor($pW,$pH);
    $noColor = imagecolorallocate($finalImg, 0, 0, 0);
    //On rempli l'image de transparent
    $transparentBg = imagecolortransparent($finalImg,$noColor);
    imagefill($finalImg,0,0,$transparentBg);
    //on colle l'original resize
    imagecopyresampled($finalImg,$imageCopy,($pW-$newWidth)/2,($pH-$newHeight)/2,0,0,$newWidth,$newHeight,$originalWidth,$originalHeight);
    //sauvegarde en png
    imagepng($finalImg,'../../images/imgCont/'.$pBaseName.'_'.$pId.'.png');
    return $pBaseName.'_'.$pId.'.png';
  }
 ?>
