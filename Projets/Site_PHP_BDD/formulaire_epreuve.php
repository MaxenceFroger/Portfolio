<?php
  function formulaireAddEpreuve() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Ajouter Epreuve</legend>
      <label> <b>Nom</b> <input type='text' name='nom' size='12' required/> </label>
      </br>
      <label> <b>Date</b> <input type='text' name='date' size='12' required/> </label>
      </br>
      <label> <b>Sexe</b> <input type='text' name='sexe' size='12' required/> </label>
      </br>
      <input type='submit' name='add_epreuve' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireDeleteEpreuve() {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Supprimer Epreuve</legend>
      <label> <b>ID</b> <input type='text' name='id' size='12' required/> </label>
      </br>
      <input type='submit' name='delete_epreuve' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }

  function formulaireModifierEpreuve($array) {
    $formulaire = "<form action='formulaire.php' method='get'><fieldset>
      <legend>Modifier Epreuve</legend>
      <input type='hidden' name='id' size='12'  value='" . $array['epreuve_id'] . "'/>
      ID : " . $array['epreuve_id'] . "
      </br>
      <label> <b>Nom</b> <input type='text' name='nom' size='12' value='" . $array['epreuve_nom'] . "' required/> </label>
      </br>
      <label> <b>Date</b> <input type='text' name='date' size='12' value='" . $array['epreuve_date'] . "' required/> </label>
      </br>
      <label> <b>Sexe</b> <input type='text' name='sexe' size='12' value='" . $array['epreuve_sexe'] . "' required/> </label>
      </br>
      <input type='submit' name='modify_epreuve' value='Envoyer' />
      <input type='reset' value='Effacer' />
      </fieldset></form>";
    return $formulaire;
  }
?>
