<?php
  session_start();
  include 'fonctions_html.php';

  function formulaireAccueil() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Choisir une table</legend>
      <div>
      <p>Tables :</p>
      <label> <b>Athletes</b> <input type='radio' name='table' value='athlete' size='12' required/> </label>
      </br>
      <label> <b>Epreuves</b> <input type='radio' name='table' value='epreuve' size='12' required/> </label>
      </br>
      <label> <b>Pays</b> <input type='radio' name='table' value='pays' size='12' required/> </label>
      <p>Tables Associative:</p>
      <label> <b>Participe</b> <input type='radio' name='table' value='participe' size='12' required/> </label>
      </br>
      <label> <b>Envoie</b> <input type='radio' name='table' value='envoie' size='12' required/> </label>
      </div>
      </br>
      <input type='submit' name='choose_table' value='Afficher' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }
  $html = getDebutHTML("Accueil");
  $html .= formulaireAccueil();
  $html .= getFinHTML();
  echo($html);
?>
