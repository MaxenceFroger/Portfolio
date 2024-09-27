<?php

  function formulaireAddParticipe() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Ajouter Participe</legend>
      <label> <b>ID Athlete</b> <input type='text' name='id_athlete' size='12' required/> </label>
      </br>
      <label> <b>ID Epreuve</b> <input type='text' name='id_epreuve' size='12' required/> </label>
      </br>
      <label> <b>Classement</b> <input type='text' name='classement' size='12' required/> </label>
      </br>
      <label> <b>Temps</b> <input type='text' name='temps' size='12' required/> </label>
      </br>
      <input type='submit' name='add_participe' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireDeleteParticipe() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Supprimer Participe</legend>
      <label> <b>ID Athlete</b> <input type='text' name='id_athlete' size='12' required/> </label>
      </br>
      <label> <b>ID Epreuve</b> <input type='text' name='id_epreuve' size='12' required/> </label>
      </br>
      <input type='submit' name='delete_participe' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireModifierParticipe($array) {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Modifier Participe</legend>
      <input type='hidden' name='id' size='12'  value='" . $array['athlete_id'] . "'/>
      Athlete ID : " . $array['athlete_id'] . "
      </br>
      <input type='hidden' name='id' size='12'  value='" . $array['epreuve_id'] . "'/>
      Epreuve ID : " . $array['epreuve_id'] . "
      </br>
      <label> <b>Temps</b> <input type='text' name='temps' size='12' value='" . $array['temps'] . "' required/> </label>
      </br>
      <label> <b>Classement</b> <input type='text' name='classement' size='12' value='" . $array['classement'] . "' required/> </label>
      </br>
      <input type='submit' name='modify_participe' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }
?>
