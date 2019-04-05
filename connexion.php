<?php
try {
      $bdd = new PDO('mysql:host=localhost;dbname=basedd', 'root', '');
      $bdd->setAttribute(PDO::ATTR_ERRMODE /*rapport d'erreues*/, PDO::ERRMODE_EXCEPTION/*emet une exception*/);
}
catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
}


$AfficherFormulaire = TRUE;
/*true tant qu'il y a une erreur ou si c'est notre premier visite sur la page
false lorsque on reussi a se connecter*/
 
if(!empty($_POST['pseudo']) AND !empty($_POST['pass'])) {
      $req = $bdd->prepare('SELECT COUNT(*) FROM users WHERE pass = :pass AND pseudo = :pseudo');
      //éxecuter la requte préparer avec des marqueurs définis
      $req->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
      $req->bindValue(':pass', $_POST['pass'], PDO::PARAM_STR);
      $req->execute();
      $resultat = $req->fetch();
      $req->closeCursor();
      if($resultat[0] == 0) {
            echo 'Identifiant ou Mot-de-pass invalide';
      } else {
           include ("Pagedaccueil.php");
            $AfficherFormulaire = FALSE;
      }
}
 
if($AfficherFormulaire) {
      echo "<div align=\"center\"><b><font size=\"2\">Veuillez saisir votre pseudo et votre mot de passe :</font></b>
                  <form method=\"post\" action=\"index.php\">
                    <b><font size=\"1\">Pseudo<br>
                        <input type=\"text\" name=\"pseudo\">
                        <br>
                        <br>
                        Mot de passe</font></b><br>
                        <input type=\"password\" name=\"MotDePasse\">
                        <br>
                        <br>
                        <input type=\"submit\" name=\"Submit\" value=\"Entrer\">
                  </form>
                  <font face=\"Verdana\" size=\"2\"><a href=\"Inscription.php\">Inscription</a></font>
                  </div>";
}
?>
