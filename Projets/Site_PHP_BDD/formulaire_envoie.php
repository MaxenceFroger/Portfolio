<?php
  function formulaireAddEnvoie() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Ajouter Envoie</legend>
      <label> <b>ID Athlete</b> <input type='text' name='id_athlete' size='12' required/> </label>
      </br>
      <label> <b>ID Pays</b> <input type='text' name='id_pays' size='12' required/> </label>
      </br>
      <input type='submit' name='add_envoie' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireDeleteEnvoie() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Supprimer Envoie</legend>
      <label> <b>ID Athlete</b> <input type='text' name='id_athlete' size='12' required/> </label>
      </br>
      <label> <b>ID Pays</b> <input type='text' name='id_pays' size='12' required/> </label>
      </br>
      <input type='submit' name='delete_envoie' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }
?>
