<div class="row" id="bande-log">
  <div class="col-xs12 text-right">
    <?php
   //  $prenom = ucfirst(strtolower($_SESSION['user']['prenom'])); // first letter in maj
   //  $nom = ucfirst(strtolower($_SESSION['user']['nom'])); // no opti nom composé et accents
    $prenom = mb_convert_case($_SESSION['user']['prenom'],MB_CASE_TITLE,'utf-8');
    $nom = mb_convert_case($_SESSION['user']['nom'],MB_CASE_TITLE,'utf-8');
    echo $prenom.' '. $nom; ?>
    <a href="../core/libs/users-services.php?action=unlog-admin"><span class="glyphicon glyphicon-off"></span></a>
  </div>
</div>
