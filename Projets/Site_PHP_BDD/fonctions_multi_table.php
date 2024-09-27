<?php
  function connexion() {
    include 'connex.php';
    $link = pg_connect("host=$dbHost user=$dbUser password=$dbPassword");
    if ($link) {
    } else {
      print '<p>Erreur lors de la connexion ...</p>';
      exit;
    }
    return $link;
  }

  function testExist($nomTable, $nomId, $id, $link) {
    $query = "SELECT * FROM $nomTable WHERE $nomId = $id";
    $queryArray = pg_query($link, $query);
    if(pg_num_rows($queryArray) != 0) {
      return true;
    }
    else  {
      return false;
    }
  }

  function testExistAssoc($nomTable, $nomId1, $nomId2, $id1, $id2, $link) {
    $query = "SELECT * FROM $nomTable WHERE $nomId1 = $id1 AND $nomId2 = $id2";
    $queryArray = pg_query($link, $query);
    if(pg_num_rows($queryArray) != 0) {
      return true;
    }
    else  {
      return false;
    }
  }

  function testAssocEpreuve($id, $link) {
    $query = "SELECT * FROM g02_participe WHERE epreuve_id = $id";
    $queryArray = pg_query($link, $query);
    if(pg_num_rows($queryArray) != 0) {
      return true;
    }
    else  {
      return false;
    }
  }

  function testAssocPays($id, $link) {
    $query = "SELECT * FROM g02_envoie WHERE pays_id = $id";
    $queryArray = pg_query($link, $query);
    if(pg_num_rows($queryArray) != 0) {
      return true;
    }
    else  {
      return false;
    }
  }


  function testAssocAthlete($id, $link) {
    $query1 = "SELECT * FROM g02_envoie WHERE athlete_id = $id";
    $queryArray1 = pg_query($link, $query1);
    $query2 = "SELECT * FROM g02_participe WHERE athlete_id = $id";
    $queryArray2 = pg_query($link, $query2);
    if(pg_num_rows($queryArray1) != 0 || pg_num_rows($queryArray2) != 0) {
      return true;
    }
    else  {
      return false;
    }
  }
?>
