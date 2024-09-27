<?php

 //Athletes
 function getAthleteById(string $id, $link) {
     $query = "SELECT * FROM g02_athletes WHERE athlete_id = $id";
     $queryArray = pg_query($link, $query);
     if(testExist('g02_athletes','athlete_id', $id, $link)) {
       $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
       $array = array("athlete_id" => $row[0], "athlete_nom" => $row[1], "athlete_age" => $row[2], "athlete_sexe" => $row[3]);
     }
     else {
       $array = array("message" => "Identifiant d'athlete non valide : $id");
     }
     return $array;
 }

 function showAthleteById(string $id, $link) {
     $query = "SELECT * FROM g02_athletes WHERE athlete_id = $id";
     $queryArray = pg_query($link, $query);
     $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
     $array = array("athlete_id" => $row[0], "athlete_nom" => $row[1], "athlete_age" => $row[2], "athlete_sexe" => $row[3]);
     $list = "<h2>Details de " . $array['athlete_nom']. "</h2><ul><li><b>athlete_id : </b>" . $array['athlete_id'] . "</li><li><b>athlete_nom : </b>" . $array['athlete_nom'] . "</li><li><b>athlete_age : </b>" . $array['athlete_age'] . "</li><li><b>athlete_sexe : </b>" . $array['athlete_sexe'] . "</li><li><b>Pays réprésentant : </b>";
     $query = "SELECT pays_nom FROM g02_athletes NATURAL JOIN g02_envoie NATURAL JOIN g02_pays WHERE athlete_id = $id";
     $queryArray = pg_query($link, $query);
     $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
     $list .= $row[0] . "</li><li><b>Liste d'epreuve : </b><ul>";
     $query = "SELECT * FROM g02_epreuves NATURAL JOIN g02_participe WHERE athlete_id = $id ORDER BY epreuve_id";
     $queryArray = pg_query($link, $query);
     for ($i = 0; $i < pg_num_rows($queryArray); $i++){
       $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
       $list .= "<li>" . $row[1] . " : " . $row[5] . " | " . $row[6] . " secondes</li>";
     }
     $list .= "</ul></li></ul>";
     echo($list);
 }

 function getAllAthletes($link) : array {
     $query = "SELECT * FROM g02_athletes ORDER BY athlete_id";
     $array = array();
     $queryArray = pg_query($link, $query);
     for ($i = 0; $i < pg_num_rows($queryArray); $i++){
       $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
       $array[$i] = array("athlete_id" => $row[0], "athlete_nom" => $row[1], "athlete_age" => $row[2], "athlete_sexe" => $row[3]);
     }
     return $array;
 }

 function selectAthlete(string $search, $link) {
     $query = "SELECT * FROM g02_athletes WHERE athlete_nom LIKE " . "'%" . $search . "%'" . " ORDER BY athlete_id";
     $queryArray = pg_query($link, $query);
     for ($i = 0; $i < pg_num_rows($queryArray); $i++){
       $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
       $array[$i] = array("athlete_id" => $row[0], "athlete_nom" => $row[1], "athlete_age" => $row[2], "athlete_sexe" => $row[3]);
     }
     displayAthlete($array, $link);
 }

 function insertAthlete(array $athlete, $link) {
     $query = "INSERT INTO g02_athletes (athlete_nom, athlete_age, athlete_sexe) VALUES";
     $query .= "('" . $athlete['athlete_nom'] . "','" . $athlete['athlete_age'] . "','" . $athlete['athlete_sexe'] . "')";
     $queryArray = pg_query($link, $query);
 }

 function insertAthleteWithID(array $athlete, $link) : array {
     $query = "INSERT INTO g02_athletes (athlete_id , athlete_nom, athlete_age, athlete_sexe) VALUES";
     $query .= "('" . $athlete['athlete_id'] . "','" . $athlete['athlete_nom'] . "','" . $athlete['athlete_age'] . "','" . $athlete['athlete_sexe'] . "')";
     $query .= " ON CONFLICT (athlete_id) DO NOTHING";
     $queryArray = pg_query($link, $query);
     return getAthleteById($athlete['athlete_id'],$link);
 }

 function updateAthlete(array $athlete, $link) {
   if(testExist('g02_athletes','athlete_id', $athlete['athlete_id'], $link)) {
     $query = "UPDATE g02_athletes SET ";
     $query .= "athlete_nom='" . $athlete['athlete_nom'] . "',athlete_age='" . $athlete['athlete_age'] . "',athlete_sexe='" . $athlete['athlete_sexe'] . "'";
     $query .= " WHERE athlete_id='" . $athlete['athlete_id'] . "'";
     $queryArray = pg_query($link, $query);
     return getAthleteById($athlete['athlete_id'],$link);
   }
   else {
     echo("Identifiant d'athlete non valide :" . $athlete['athlete_id']);
   }
 }

 function deleteAthlete(string $id, $link) {
   if(testExist('g02_athletes','athlete_id', $id, $link)) {
     $query = "DELETE FROM g02_envoie WHERE athlete_id='$id'";
     $queryArray = pg_query($link, $query);
     $query = "DELETE FROM g02_participe WHERE athlete_id='$id'";
     $queryArray = pg_query($link, $query);
     $query = "DELETE FROM g02_athletes WHERE athlete_id='$id'";
     $queryArray = pg_query($link, $query);
   }
   else {formulaireModifierAthlete($_SESSION['showID']);
     echo("Identifiant d'athlete non valide : $id");
   }
 }

 function displayAthletes($link) {
   $table = "<form action='formulaire.php' method='get'><input type='submit' name='go_add' value='Inserer' /></form>";
   $table .= '<table border="1"><tr><th>Id</th><th>Nom</th><th>Age</th><th>Sexe</th></tr>';
   $athletes = getAllAthletes($link);
   foreach($athletes as $athlete) {
     $table .= "<tr><td>" . $athlete['athlete_id'] . "</td><td>" . $athlete['athlete_nom'] . "</td><td>" . $athlete['athlete_age'] . "</td><td>" . $athlete['athlete_sexe'] . "</td>";
     $table .= "<td><form action='formulaire.php' method='get'>
       <input type='hidden' name='id' size='12'  value='" . $athlete['athlete_id'] . "'/>
       <input type='submit' name='go_details' value='détails' />
       </form></td>";
     $table .= "<td><form action='formulaire.php' method='get'>
       <input type='hidden' name='id' size='12'  value='" . $athlete['athlete_id'] . "'/>
       <input type='submit' name='go_modify' value='modifier' />
       </form></td>";
     $table .= "<td><form action='formulaire.php' method='get'>
         <input type='hidden' name='id' size='12'  value='" . $athlete['athlete_id'] . "'/>
         <input type='submit' name='go_delete' value='supprimer' />
         </form></td>";
     $table .= "</tr>";
   }
   $table .= '</table>';
   echo $table;
 }

 function displayAthleteArray($array, $link) {
   $table = '<table border="1"><tr><th>Id</th><th>Nom</th><th>Age</th><th>Sexe</th></tr>';
   for($i = 0; $i < count($array); $i++) {
     if(testExist('g02_athletes','athlete_id', $array[$i]['athlete_id'], $link)) {
       $table .= "<tr><td>" . $array[$i]['athlete_id'] . "</td><td>" . $array[$i]['athlete_nom'] . "</td><td>" . $array[$i]['athlete_age'] . "</td><td>" . $array[$i]['athlete_sexe'] . "</td></tr>";
     }
   }
   $table .= '</table>';
   echo $table;
 }
?>
