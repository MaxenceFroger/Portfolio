<?php
  //Participe
  function getParticipeById(string $a_id, string $e_id,  $link) {
    if(testExistAssoc('g02_participe','athlete_id', 'epreuve_id', $a_id, $e_id, $link)) {
      $query = "SELECT * FROM g02_participe WHERE athlete_id = $a_id AND epreuve_id = $e_id";
      $queryArray = pg_query($link, $query);
      $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
      $array = array("athlete_id" => $row[0], "epreuve_id" => $row[1], "classement" => $row[2], "temps" => $row[3]);
    }
    else {
      $array = array("message" => "Identifiant d'athlete ou d'épreuve non valide : $a_id / $e_id");
    }
    return $array;
  }

  function showParticipeById(string $a_id, string $e_id, $link) {
      $query = "SELECT * FROM g02_athletes NATURAL JOIN g02_participe NATURAL JOIN g02_epreuves WHERE athlete_id = $a_id AND epreuve_id = $e_id";
      $queryArray = pg_query($link, $query);
      $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
      $array = array("epreuve_id" => $row[0], "athlete_id" => $row[1], "athlete_nom" => $row[2], "athlete_age" => $row[3], "athlete_sexe" => $row[4], "classement" => $row[5], "temps" => $row[6], "epreuve_nom" => $row[7], "epreuve_date" => $row[8], "epreuve_sexe" => $row[9]);
      $list = "<h2>Details de " . $array['athlete_id'] . "|" . $array['epreuve_id'] . "</h2><ul><li><b>athlete_id : </b>" . $array['athlete_id'] .
      "</li><b>epreuve_id : </b>" . $array['epreuve_id'] .
      "</li><li><b>athlete_nom : </b>" . $array['athlete_nom'] .
      "</li><li><b>athlete_age : </b>" . $array['athlete_age'] .
      "</li><li><b>athlete_sexe : </b>" . $array['athlete_sexe'] .
      "</li><li><b>classement : </b>" . $array['classement'] .
      "</li><li><b>temps : </b>" . $array['temps'] .
      "</li><li><b>epreuve_nom : </b>" . $array['epreuve_nom'] .
      "</li><li><b>epreuve_date : </b>" . $array['epreuve_date'] .
      "</li><li><b>epreuve_sexe : </b>" . $array['epreuve_sexe'] .
      "</li></ul>";
      echo($list);
  }

  function getAllParticipe($link) : array {
      $query = "SELECT * FROM g02_participe ORDER BY athlete_id";
      $array = array();
      $i=0;
      $queryArray = pg_query($link, $query);
      for ($i = 0; $i < pg_num_rows($queryArray); $i++){
        $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
        $array[$i] = array("athlete_id" => $row[0], "epreuve_id" => $row[1], "classement" => $row[2], "temps" => $row[3]);
      }
      return $array;
  }

  function insertParticipe(array $participe, $link) : array {
    if(!testExistAssoc('g02_participe','athlete_id', 'epreuve_id', $participe['athlete_id'], $participe['epreuve_id'], $link)) {
      $query = "INSERT INTO g02_participe (athlete_id , epreuve_id, classement, temps) VALUES";
      $query .= "('" . $participe['athlete_id'] . "','" . $participe['epreuve_id']. "','" . $participe['classement']. "','" . $participe['temps'] . "')";
      $queryArray = pg_query($link, $query);
      return getParticipeById($participe['athlete_id'], $participe['epreuve_id'], $link);
    }
    else {
      echo("Identifiant d'athlete ou d'épreuve non valide : " . $participe['athlete_id'] . "/"  . $participe['epreuve_id']);
      return(array());
    }
  }

  function updateParticipe(array $participe, $link) {
    if(testExistAssoc('g02_participe','athlete_id', 'epreuve_id', $participe['athlete_id'], $participe['epreuve_id'], $link)) {
      $query = "UPDATE g02_participe SET ";
      $query .= "classement='" . $participe['classement'] . "'";
      $query .= ", temps='" . $participe['temps'] . "'";
      $query .= " WHERE athlete_id='" . $participe['athlete_id'] . "'" . "AND epreuve_id='" . $participe['epreuve_id']. "'";
      $queryArray = pg_query($link, $query);
      return getParticipeById($participe['athlete_id'], $participe['epreuve_id'], $link);
    }
    else {
      echo("Identifiant d'athlete ou d'épreuve non valide : $a_id / $e_id");
    }
  }

  function deleteParticipe(string $a_id,string $e_id, $link) {
    if(testExistAssoc('g02_participe','athlete_id', 'epreuve_id', $a_id, $e_id, $link)) {
      $query = "DELETE FROM g02_participe WHERE athlete_id='$a_id' AND epreuve_id='$e_id'";
      $queryArray = pg_query($link, $query);
    }
    else {
      echo("Identifiant d'athlete ou d'épreuve non valide : $a_id / $e_id");
    }
  }

  function displayParticipes($link) {
    $table = "<form action='formulaire.php' method='get'><input type='submit' name='go_add' value='Inserer' /></form>";
    $table .= '<table border="1"><tr><th>Id_Athlete</th><th>Id_Epreuve</th><th>Classement</th><th>Temps</th></tr>';
    $allParticipe = getAllParticipe($link);
    foreach($allParticipe as $participe) {
      $table .= "<tr><td>" . $participe['athlete_id'] . "</td><td>" . $participe['epreuve_id'] . "</td><td>" . $participe['classement'] . "</td><td>" . $participe['temps'] . "</td>";
      $table .= "<td><form action='formulaire.php' method='get'>
        <input type='hidden' name='athlete_id' size='12'  value='" . $participe['athlete_id'] . "'/>
        <input type='hidden' name='epreuve_id' size='12'  value='" . $participe['epreuve_id'] . "'/>
        <input type='submit' name='go_details' value='détails' />
        </form></td>";
      $table .= "<td><form action='formulaire.php' method='get'>
        <input type='hidden' name='athlete_id' size='12'  value='" . $participe['athlete_id'] . "'/>
        <input type='hidden' name='epreuve_id' size='12'  value='" . $participe['epreuve_id'] . "'/>
        <input type='submit' name='go_modify' value='modifier' />
        </form></td>";
      $table .= "<td><form action='formulaire.php' method='get'>
        <input type='hidden' name='athlete_id' size='12'  value='" . $participe['athlete_id'] . "'/>
        <input type='hidden' name='epreuve_id' size='12'  value='" . $participe['epreuve_id'] . "'/>
        <input type='submit' name='go_delete' value='supprimer' />
        </form></td>";
      $table .= "</tr>";
    }
    $table .= '</table>';
    echo $table;
  }

  function displayParticipe($a_id, $e_id, $link) {
    if(testExistAssoc('g02_participe','athlete_id', 'epreuve_id', $a_id, $e_id, $link)) {
      $table = '<table border="1"><tr><th>Id_Athlete</th><th>Id_Epreuve</th><th>Classement</th><th>Temps</th></tr>';
      $participe = getParticipeById($a_id, $e_id, $link);
      $table .= "<tr><td>" . $participe['athlete_id'] . "</td><td>" . $participe['epreuve_id'] . "</td><td>" . $participe['classement'] . "</td><td>" . $participe['temps'] . "</td></tr>";
      $table .= '</table>';
      echo $table;
    }
    else {
      echo("Identifiant d'athlete ou d'épreuve non valide : $a_id / $e_id");
    }
  }
?>
