<?php

  //Envoie
  function getEnvoieById(string $a_id, string $p_id,  $link) {
    if(testExistAssoc('g02_envoie','athlete_id', 'pays_id', $a_id, $p_id, $link)) {
      $query = "SELECT * FROM g02_envoie WHERE athlete_id = $a_id AND pays_id = $p_id";
      $queryArray = pg_query($link, $query);
      $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
      $array = array("athlete_id" => $row[0], "pays_id" => $row[1]);
    }
    else {
      $array = array("message" => "Identifiant d'athlete ou de pays non valide : $a_id / $p_id");
    }
    return $array;
  }

  function showEnvoieById(string $a_id, string $p_id, $link) {
      $query = "SELECT * FROM g02_athletes NATURAL JOIN g02_envoie NATURAL JOIN g02_pays WHERE athlete_id = $a_id AND pays_id = $p_id";
      $queryArray = pg_query($link, $query);
      $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
      $array = array("pays_id" => $row[0], "athlete_id" => $row[1], "athlete_nom" => $row[2], "athlete_age" => $row[3], "athlete_sexe" => $row[4], "pays_nom" => $row[5]);
      $list = "<h2>Details de " . $array['athlete_id'] . "|" . $array['pays_id'] . "</h2><ul><li><b>athlete_id : </b>" . $array['athlete_id'] .
      "</li><b>pays_id : </b>" . $array['pays_id'] .
      "</li><li><b>athlete_nom : </b>" . $array['athlete_nom'] .
      "</li><li><b>athlete_age : </b>" . $array['athlete_age'] .
      "</li><li><b>athlete_sexe : </b>" . $array['athlete_sexe'] .
      "</li><li><b>pays_nom : </b>" . $array['pays_nom'] .
      "</li></ul>";
      echo($list);
  }

  function getAllEnvoie($link) : array {
      $query = "SELECT * FROM g02_envoie ORDER BY athlete_id";
      $array = array();
      $queryArray = pg_query($link, $query);
      for ($i = 0; $i < pg_num_rows($queryArray); $i++){
        $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
        $array[$i] = array("athlete_id" => $row[0], "pays_id" => $row[1]);
      }
      return $array;
  }

  function insertEnvoie(array $envoie, $link) : array {
    if(!testExistAssoc('g02_envoie','athlete_id', 'pays_id', $envoie['athlete_id'], $envoie['pays_id'], $link)) {
      $query = "INSERT INTO g02_envoie (athlete_id, pays_id) VALUES";
      $query .= "('" . $envoie['athlete_id'] . "','" . $envoie['pays_id']. "')";
      $queryArray = pg_query($link, $query);
      $query .= " ON CONFLICT (athlete_id) DO NOTHING";
      return getEnvoieById($envoie['athlete_id'], $envoie['pays_id'], $link);
    }
    else {
      echo("envoie existe deja");
      return(array());
    }
  }

  function deleteEnvoie(string $a_id,string $p_id, $link) {
      if(testExistAssoc('g02_envoie','athlete_id', 'pays_id', $a_id, $p_id, $link)) {
        $query = "DELETE FROM g02_envoie WHERE athlete_id='$a_id' AND pays_id='$p_id'";
        $queryArray = pg_query($link, $query);
      }
      else {
        echo("Identifiant d'athlete ou de pays non valide : $a_id / $p_id");
      }
  }

  function displayEnvoies($link) {
    $table = "<form action='formulaire.php' method='get'><input type='submit' name='go_add' value='Inserer' /></form>";
    $table .= '<table border="1"><tr><th>Id_Athlete</th><th>Id_Pays</th></tr>';
    $allEnvoie = getAllEnvoie($link);
    foreach($allEnvoie as $envoie) {
      $table .= "<tr><td>" . $envoie['athlete_id'] . "</td><td>" . $envoie['pays_id'] . "</td>";
      $table .= "<td><form action='formulaire.php' method='get'>
        <input type='hidden' name='athlete_id' size='12'  value='" . $envoie['athlete_id'] . "'/>
        <input type='hidden' name='pays_id' size='12'  value='" . $envoie['pays_id'] . "'/>
        <input type='submit' name='go_details' value='détails' />
        </form></td>";
      $table .= "<td><form action='formulaire.php' method='get'>
        <input type='hidden' name='athlete_id' size='12'  value='" . $envoie['athlete_id'] . "'/>
        <input type='hidden' name='pays_id' size='12'  value='" . $envoie['pays_id'] . "'/>
        <input type='submit' name='go_delete' value='supprimer' />
        </form></td>";
      $table .= "</tr>";
    }
    $table .= '</table>';
    echo $table;
  }

  function displayEnvoie($a_id, $p_id, $link) {
    if(testExistAssoc('g02_envoie','athlete_id', 'pays_id', $a_id, $p_id, $link)) {
      $table = '<table border="1"><tr><th>Id_Athlete</th><th>Id_Pays</th></tr>';
      $envoie = getEnvoieById($a_id, $p_id, $link);
      $table .= "<tr><td>" . $envoie['athlete_id'] . "</td><td>" . $envoie['pays_id'] . "</td></tr>";
      $table .= '</table>';
      echo $table;
    }
    else {
      echo("Identifiant d'athlete ou de pays non valide : $a_id / $p_id");
    }
  }
?>
