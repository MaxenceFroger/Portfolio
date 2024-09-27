<?php

  include 'fonctions_athlete.php';
  include 'fonctions_epreuve.php';
  include 'fonctions_pays.php';
  include 'fonctions_participe.php';
  include 'fonctions_envoie.php';
  include 'fonctions_multi_table.php';
  include 'fonctions_html.php';
  include 'formulaire_athlete.php';
  include 'formulaire_epreuve.php';
  include 'formulaire_pays.php';
  include 'formulaire_participe.php';
  include 'formulaire_envoie.php';

  function UpdateData($link) {
    if(isset($_GET['add_athlete'])) {
      $array = array("athlete_nom" => $_GET['nom'], "athlete_age" => $_GET['age'], "athlete_sexe" => $_GET['sexe']);
      insertAthlete($array, $link);
    }
    elseif(isset($_GET['delete_athlete'])) {
      deleteAthlete($_GET['id'], $link);
    }
    elseif(isset($_GET['modify_athlete'])) {
      $array = array("athlete_id" => $_GET['id'], "athlete_nom" => $_GET['nom'], "athlete_age" => $_GET['age'], "athlete_sexe" => $_GET['sexe']);
      UpdateAthlete($array, $link);
    }
    elseif(isset($_GET['add_epreuve'])) {
      $array = array("epreuve_nom" => $_GET['nom'], "epreuve_date" => $_GET['date'], "epreuve_sexe" => $_GET['sexe']);
      insertEpreuve($array, $link);
    }
    elseif(isset($_GET['delete_epreuve'])) {
      deleteEpreuve($_GET['id'], $link);
    }
    elseif(isset($_GET['modify_epreuve'])) {
      $array = array("epreuve_id" => $_GET['id'], "epreuve_nom" => $_GET['nom'], "epreuve_date" => $_GET['date'], "epreuve_sexe" => $_GET['sexe']);
      updateEpreuve($array, $link);
    }
    elseif(isset($_GET['add_pays'])) {
      $array = array("pays_nom" => $_GET['nom']);
      insertPays($array, $link);
    }
    elseif(isset($_GET['delete_pays'])) {
      deletePays($_GET['id'], $link);
    }
    elseif(isset($_GET['modify_pays'])) {
      $array = array("pays_id" => $_GET['id'], "pays_nom" => $_GET['nom']);
      updatePays($array, $link);
    }
    elseif(isset($_GET['add_participe'])) {
      $array = array("athlete_id" => $_GET['id_athlete'], "epreuve_id" => $_GET['id_epreuve'],  "classement" => $_GET['classement'], "temps" => $_GET['temps']);
      insertParticipe($array, $link);
    }
    elseif(isset($_GET['delete_participe'])) {
      deleteParticipe($_GET['id_athlete'], $_GET['id_epreuve'], $link);
    }
    elseif(isset($_GET['modify_participe'])) {
      $array = array("athlete_id" => $_GET['id_athlete'], "epreuve_id" => $_GET['id_epreuve'],  "classement" => $_GET['classement'], "temps" => $_GET['temps']);
      updateParticipe($array, $link);
    }
    elseif(isset($_GET['add_envoie'])) {
      $array = array("athlete_id" => $_GET['id_athlete'], "pays_id" => $_GET['id_pays']);
      insertEnvoie($array, $link);
    }
    elseif(isset($_GET['delete_envoie'])) {
      deleteEnvoie($_GET['id_athlete'], $_GET['id_pays'], $link);
    }
  }

  function Move($link) {
    $destination = 'afficheTable.php';
    if(isset($_GET['choose_table'])) {
      $_SESSION['table'] = $_GET['table'];
    }
    if(isset($_GET['go_details'])) {
      if(isset($_GET['id'])) {
        $_SESSION['showID'] = $_GET['id'];
      }
      elseif(isset($_GET['epreuve_id'])){
        $_SESSION['showID'] = array("athlete_id" => $_GET['athlete_id'], "epreuve_id" => $_GET['epreuve_id']);
      }
      else {
        $_SESSION['showID'] = array("athlete_id" => $_GET['athlete_id'], "pays_id" => $_GET['pays_id']);
      }
      $destination = "afficheDetails.php";
    }
    if(isset($_GET['go_modify'])) {
      if(isset($_GET['id'])) {
        $_SESSION['modifyID'] = $_GET['id'];
      }
      elseif(isset($_GET['epreuve_id'])){
        $_SESSION['modifyID'] = array("athlete_id" => $_GET['athlete_id'], "epreuve_id" => $_GET['epreuve_id']);
      }
      else {
        $_SESSION['modifyID'] = array("athlete_id" => $_GET['athlete_id'], "pays_id" => $_GET['pays_id']);
      }
      $destination = "modifier.php";
    }
    if(isset($_GET['go_add'])) {
      $destination = "ajouter.php";
    }
    if(isset($_GET['go_delete'])) {
      switch($_SESSION['table']) {
        case 'athlete':
          deleteAthlete($_GET['id'], $link);
          break;
        case 'epreuve':
          deleteEpreuve($_GET['id'], $link);
          break;
        case 'pays':
          deletePays($_GET['id'], $link);
          break;
        case 'participe':
          deleteParticipe($_GET['athlete_id'],$_GET['epreuve_id'],$link);
          break;
        case 'envoie':
          deleteEnvoie($_GET['athlete_id'],$_GET['pays_id'],$link);
          break;
      }
    }
    return $destination;
  }

  session_start();
  $link = connexion();
  $destination = Move($link);
  UpdateData($link);
  header('Location: ' . $destination);
?>
