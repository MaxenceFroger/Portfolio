<?php
  function getPaysById(string $id, $link) {
    if(testExist('g02_pays','pays_id', $id, $link)) {
      $query = "SELECT * FROM g02_pays WHERE pays_id = $id";
      $queryArray = pg_query($link, $query);
      $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
      $array = array("pays_id" => $row[0], "pays_nom" => $row[1]);
    }
    else {
      $array = array("message" => "Identifiant de pays non valide : $id");
    }
    return $array;
  }

  function showPaysById(string $id, $link) {
      $query = "SELECT * FROM g02_pays WHERE pays_id = $id";
      $queryArray = pg_query($link, $query);
      $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
      $array = array("pays_id" => $row[0], "pays_nom" => $row[1]);

      $list = "<h2>Details de " . $array['pays_nom']. "</h2><ul><li><b>pays_id : </b>" . $array['pays_id'] . "</li><li><b>pays_nom : </b>" . $array['pays_nom'] . "</li><li><b>Liste d'athlete : </b><ul>";
      $query = "SELECT * FROM g02_athletes WHERE athlete_id IN (SELECT athlete_id FROM g02_envoie WHERE pays_id = $id)";
      $queryArray = pg_query($link, $query);
      for ($i = 0; $i < pg_num_rows($queryArray); $i++){
        $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
        $list .= "<li>" . $row[1] . "</li>";
      }
      $list .= "</ul></li></ul>";
      echo($list);
  }

  function getAllPays($link) : array {
      $query = "SELECT * FROM g02_pays ORDER BY pays_id";
      $array = array();
      $i=0;
      $queryArray = pg_query($link, $query);
      for ($i = 0; $i < pg_num_rows($queryArray); $i++){
        $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
        $array[$i] = array("pays_id" => $row[0], "pays_nom" => $row[1]);
      }
      return $array;
  }

  function insertPays(array $pays, $link) {
      $query = "INSERT INTO g02_pays (pays_nom) VALUES";
      $query .= "('" . $pays['pays_nom'] . "')";
      $queryArray = pg_query($link, $query);
  }

  function insertPaysWithID(array $pays, $link) : array {
      $query = "INSERT INTO g02_pays (pays_id , pays_nom) VALUES";
      $query .= "('" . $pays['pays_id'] . "','" . $pays['pays_nom'] . "')";
      $query .= " ON CONFLICT (pays_id) DO NOTHING";
      $queryArray = pg_query($link, $query);
      return getPaysById($pays['pays_id'],$link);
  }

  function updatePays(array $pays, $link) {
    if(testExist('g02_pays','pays_id', $pays['pays_id'], $link)) {
      $query = "UPDATE g02_pays SET ";
      $query .= "pays_nom='" . $pays['pays_nom'] . "'";
      $query .= " WHERE pays_id='" . $pays['pays_id'] . "'";
      $queryArray = pg_query($link, $query);
      return getPaysById($pays['pays_id'],$link);
    }
    else {
      echo("Identifiant de pays non valide :" . $pays['pays_id']);
    }
  }

  function deletePays(string $id, $link) {
    if(testExist('g02_pays','pays_id', $id, $link)) {
      $query = "DELETE FROM g02_envoie WHERE pays_id='$id'";
      $queryArray = pg_query($link, $query);
      $query = "DELETE FROM g02_pays WHERE pays_id='$id'";
      $queryArray = pg_query($link, $query);
    }
    else {
      echo("Identifiant de pays non valide : $id");
    }
  }

  function displayPays($link) {
    $table = "<form action='formulaire.php' method='get'><input type='submit' name='go_add' value='Inserer' /></form>";
    $table .= '<table border="1"><tr><th>Id</th><th>Nom</th></tr>';
    $allPays = getAllPays($link);
    foreach($allPays as $pays) {
      $table .= "<tr><td>" . $pays['pays_id'] . "</td><td>" . $pays['pays_nom'] . "</td>";
      $table .= "<td><form action='formulaire.php' method='get'>
        <input type='hidden' name='id' size='12'  value='" . $pays['pays_id'] . "'/>
        <input type='submit' name='go_details' value='détails' />
        </form></td>";
      $table .= "<td><form action='formulaire.php' method='get'>
        <input type='hidden' name='id' size='12'  value='" . $pays['pays_id'] . "'/>
        <input type='submit' name='go_modify' value='modifier' />
        </form></td>";
      $table .= "<td><form action='formulaire.php' method='get'>
            <input type='hidden' name='id' size='12'  value='" . $pays['pays_id'] . "'/>
            <input type='submit' name='go_delete' value='supprimer' />
            </form></td>";
      $table .= "</tr>";
    }
    $table .= '</table>';
    echo $table;
  }

  function displayPay($id, $link) {
    if(testExist('g02_pays','pays_id', $id, $link)) {
      $table = '<table border="1"><tr><th>Id</th><th>Nom</th></tr>';
      $pays = getPaysById($id, $link);
      $table .= "<tr><td>" . $pays['pays_id'] . "</td><td>" . $pays['pays_nom'] . "</td></tr>";
      $table .= '</table>';
      echo $table;
    }
    else {
      echo("Identifiant de pays non valide : $id");
    }
  }
?>
