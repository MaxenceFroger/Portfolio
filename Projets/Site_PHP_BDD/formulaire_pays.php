<?php
  function formulaireAddPays() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Ajouter Pays</legend>
      <label> <b>Nom</b> <input type='text' name='nom' size='12' required/> </label>
      </br>
      <input type='submit' name='add_pays' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireDeletePays() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Supprimer Pays</legend>
      <label> <b>ID</b> <input type='text' name='id' size='12' required/> </label>
      </br>
      <input type='submit' name='delete_pays' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireModifierPays($array) {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Modifier Pays</legend>
      <input type='hidden' name='id' size='12'  value='" . $array['pays_id'] . "'/>
      ID : " . $array['pays_id'] . "
      </br>
      <label> <b>Nom</b> <input type='text' name='nom' size='12' value='" . $array['pays_nom'] . "' required/> </label>
      </br>
      <input type='submit' name='modify_pays' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }
?>
