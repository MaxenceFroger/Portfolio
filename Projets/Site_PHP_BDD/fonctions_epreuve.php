<?php

 //Epreuves
 function getEpreuveById(string $id, $link) {
   if(testExist('g02_epreuves','epreuve_id', $id, $link)) {
     $query = "SELECT * FROM g02_epreuves WHERE epreuve_id = $id";
     $queryArray = pg_query($link, $query);
     $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
     $array = array("epreuve_id" => $row[0], "epreuve_nom" => $row[1], "epreuve_date" => $row[2], "epreuve_sexe" => $row[3]);
   }
   else {
     $array = array("message" => "Identifiant d'epreuve non valide : $id");
   }
   return $array;
 }

 function showEpreuveById(string $id, $link) {
     $query = "SELECT * FROM g02_epreuves WHERE epreuve_id = $id";
     $queryArray = pg_query($link, $query);
     $row = pg_fetch_array($queryArray, 0, PGSQL_BOTH);
     $array = array("epreuve_id" => $row[0], "epreuve_nom" => $row[1], "epreuve_date" => $row[2], "epreuve_sexe" => $row[3]);
     $list = "<h2>Details de " . $array['epreuve_nom']. "</h2><ul><li><b>epreuve_id : </b>" . $array['epreuve_id'] . "</li><li><b>epreuve_nom : </b>" . $array['epreuve_nom'] . "</li><li><b>epreuve_date : </b>" . $array['epreuve_date'] . "</li><li><b>epreuve_sexe : </b>" . $array['epreuve_sexe'] . "</li><li><b>Liste d'athlete : </b><ul>";
     $query = "SELECT * FROM g02_athletes NATURAL JOIN g02_participe WHERE epreuve_id = $id ORDER BY classement";
     $queryArray = pg_query($link, $query);
     for ($i = 0; $i < pg_num_rows($queryArray); $i++){
       $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
       $list .= "<li>" . $row[5] . " : " . $row[1] . " | " . $row[6] . " secondes</li>";
     }
     $list .= "</ul></li></ul>";
     echo($list);
 }


 function getAllEpreuves($link) : array {
     $query = "SELECT * FROM g02_epreuves ORDER BY epreuve_id";
     $array = array();
     $i=0;
     $queryArray = pg_query($link, $query);
     for ($i = 0; $i < pg_num_rows($queryArray); $i++){
       $row = pg_fetch_array($queryArray, $i, PGSQL_BOTH);
       $array[$i] = array("epreuve_id" => $row[0], "epreuve_nom" => $row[1], "epreuve_date" => $row[2], "epreuve_sexe" => $row[3]);
     }
     return $array;
 }

 function insertEpreuve(array $epreuve, $link) {
     $query = "INSERT INTO g02_epreuves (epreuve_nom, epreuve_date, epreuve_sexe) VALUES";
     $query .= "('" . $epreuve['epreuve_nom'] . "','" . $epreuve['epreuve_date'] . "','" . $epreuve['epreuve_sexe'] . "')";
     $queryArray = pg_query($link, $query);
 }

 function insertEpreuveWithID(array $epreuve, $link) : array {
     $query = "INSERT INTO g02_epreuves (epreuve_id , epreuve_nom, epreuve_date, epreuve_sexe) VALUES";
     $query .= "('" . $epreuve['epreuve_id'] . "','" . $epreuve['epreuve_nom'] . "','" . $epreuve['epreuve_date'] . "','" . $epreuve['epreuve_sexe'] . "')";
     $query .= " ON CONFLICT (epreuve_id) DO NOTHING";
     $queryArray = pg_query($link, $query);
     return getEpreuveById($epreuve['epreuve_id'],$link);
 }


 function updateEpreuve(array $epreuve, $link) {
     if(testExist('g02_epreuves','epreuve_id', $epreuve['epreuve_id'], $link)) {
       $query = "UPDATE g02_epreuves SET ";
       $query .= "epreuve_nom='" . $epreuve['epreuve_nom'] . "',epreuve_date='" . $epreuve['epreuve_date'] . "',epreuve_sexe='" . $epreuve['epreuve_sexe'] . "'";
       $query .= " WHERE epreuve_id='" . $epreuve['epreuve_id'] . "'";
       $queryArray = pg_query($link, $query);
       return getEpreuveById($epreuve['epreuve_id'],$link);
     }
     else {
       echo("Identifiant d'epreuve non valide :" . $epreuve['epreuve_id']);
     }
 }

 function deleteEpreuve(string $id, $link) {
     if(testExist('g02_epreuves','epreuve_id', $id, $link)) {
       $query = "DELETE FROM g02_participe WHERE epreuve_id='$id'";
       $queryArray = pg_query($link, $query);
       $query = "DELETE FROM g02_epreuves WHERE epreuve_id='$id'";
       $queryArray = pg_query($link, $query);
     }
     else {
       echo("Identifiant d'epreuve non valide : $id");
     }
 }

 function displayEpreuves($link) {
   $table = "<form action='formulaire.php' method='get'><input type='submit' name='go_add' value='Inserer' /></form>";
   $table .= '<table border="1"><tr><th>Id</th><th>Nom</th><th>Date</th><th>Sexe</th></tr>';
   $epreuves = getAllEpreuves($link);
   foreach($epreuves as $epreuve) {
     $table .= "<tr><td>" . $epreuve['epreuve_id'] . "</td><td>" . $epreuve['epreuve_nom'] . "</td><td>" . $epreuve['epreuve_date'] . "</td><td>" . $epreuve['epreuve_sexe'] . "</td>";
     $table .= "<td><form action='formulaire.php' method='get'>
       <input type='hidden' name='id' size='12'  value='" . $epreuve['epreuve_id'] . "'/>
       <input type='submit' name='go_details' value='détails' />
       </form></td>";
     $table .= "<td><form action='formulaire.php' method='get'>
       <input type='hidden' name='id' size='12'  value='" . $epreuve['epreuve_id'] . "'/>
       <input type='submit' name='go_modify' value='modifier' />
       </form></td>";
     $table .= "<td><form action='formulaire.php' method='get'>
           <input type='hidden' name='id' size='12'  value='" . $epreuve['epreuve_id'] . "'/>
           <input type='submit' name='go_delete' value='supprimer' />
           </form></td>";
     $table .= "</tr>";
   }
   $table .= '</table>';
   echo $table;
 }

 function displayEpreuve($id, $link) {
   if(testExist('g02_epreuves','epreuve_id', $id, $link)) {
     $table = '<table border="1"><tr><th>Id</th><th>Nom</th><th>Date</th><th>Sexe</th></tr>';
     $epreuve = getEpreuveById($id, $link);
     $table .= "<tr><td>" . $epreuve['epreuve_id'] . "</td><td>" . $epreuve['epreuve_nom'] . "</td><td>" . $epreuve['epreuve_date'] . "</td><td>" . $epreuve['epreuve_sexe'] . "</td></tr>";
     $table .= '</table>';
     echo $table;
   }
   else {
     echo("Identifiant d'epreuve non valide : $id");
   }
 }
?>
