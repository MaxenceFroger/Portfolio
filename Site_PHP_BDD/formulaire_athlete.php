<?php
  function formulaireAddAthlete() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Ajouter Athlete</legend>
      <label> <b>Nom</b> <input type='text' name='nom' size='12' required/> </label>
      </br>
      <label> <b>Age</b> <input type='text' name='age' size='12' required/> </label>
      </br>
      <label> <b>Sexe</b> <input type='text' name='sexe' size='12' required/> </label>
      </br>
      <input type='submit' name='add_athlete' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireDeleteAthlete() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Supprimer Athlete</legend>
      <label> <b>ID</b> <input type='text' name='id' size='12' required/> </label>
      </br>
      <input type='submit' name='delete_athlete' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireModifierAthlete($array) {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Modifier Athlete</legend>
      <input type='hidden' name='id' size='12'  value='" . $array['athlete_id'] . "'/>
      ID : " . $array['athlete_id'] . "
      </br>
      <label> <b>Nom</b> <input type='text' name='nom' size='12' value='" . $array['athlete_nom'] . "' required/> </label>
      </br>
      <label> <b>Age</b> <input type='text' name='age' size='12' value='" . $array['athlete_age'] . "' required/> </label>
      </br>
      <label> <b>Sexe</b> <input type='text' name='sexe' size='12' value='" . $array['athlete_sexe'] . "' required/> </label>
      </br>
      <input type='submit' name='modify_athlete' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }
?>
