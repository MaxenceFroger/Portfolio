<?php

use Squadro\Classe\PlateauSquadro;
use Squadro\ClassUI\PieceSquadroUI;
use Squadro\ClassUI\SquadroUIGenerator;
use Squadro\Etape4\PDOSquadro;
use Squadro\Etape4\PartieSquadro;
use Squadro\Etape4\JoueurSquadro;

require_once "PDOSquadro.php";
require_once "../ClassUI/SquadroUIGenerator.php";

session_start();
PDOSquadro::initPDOEnv();

/**
 * Initialisation de l'interface utilisateur pour le jeu Squadro.
 *
 */
$SquadroUIGen = new SquadroUIGenerator(new PieceSquadroUI(), "traiteActionSquadro.php", "traiteActionSquadro.php", "traiteActionSquadro.php", "traiteActionSquadro.php", 'bd');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION["etat"])){
    header('Location: login.php');
}

// Gestion des différentes pages en fonction de l'état de la session
if ($_SESSION["etat"] == "choixPiece") {
    echo $SquadroUIGen->pageJouerPiece();
} elseif ($_SESSION["etat"] == "confirmationPiece") {
    echo $SquadroUIGen->pageConfirmerDeplacement();
} elseif ($_SESSION["etat"] == "erreur") {
    echo $SquadroUIGen->pageErreur();
} elseif ($_SESSION['etat'] == "consultePartieVictoire") {
    PDOSquadro::initPDOEnv();
    $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
    $joueur = $partie->getJoueurs()[$partie->joueurActif]->getNomJoueur();
    echo $SquadroUIGen->pagePlateauFinal($joueur);
} elseif ($_SESSION['etat'] == "home") {
    echo pageHome();
} elseif ($_SESSION['etat'] == "consultePartieEnCours") {
    echo $SquadroUIGen->pagePlateauEnCours($_SESSION['player']);
}

/**
 * Génère la page d'accueil avec les options du jeu.
 * @return string HTML de la page d'accueil.
 */
function pageHome(): string {
    $html = "<html lang=\"fr\"><head><title>Home</title> <link rel='stylesheet' href='../css/etape4.css' /></head><body><h1>Bienvenue " . $_SESSION['player'] . " !</h1>";

    $html .= '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';

    if(isset($_SESSION['partieID'])) {$html .= '<button type="submit" name= "demande" value="reprendre">Reprendre la dernière partie</button>';}
    $html .= '<button type="submit" name= "demande" value="creer">Creer une nouvelle partie</button>'
        . '<button type="submit" name= "demande" value="continuer">Continuer une partie commencée</button>'
        . '<button type="submit" name= "demande" value="lister">Liste des parties en attente de joueurs</button>'
        . '<button type="submit" name= "demande" value="historique">Historique</button>'
        . '<button type="submit" name= "demande" value="quitter">quitter</button>'
        . '</form>';

    if (isset($_POST['demande'])) {
        switch ($_POST['demande']) {
            case "reprendre" :
                $partieid = PDOSquadro::getLastGameIdForPlayer($_SESSION['player']);
                $_SESSION['etat'] = conditionsIndex($partieid);
                header("Location: index.php");
                break;
            case "creer":
                $joueur = PDOSquadro::selectPlayerByName($_SESSION['player']);
                $partie = new PartieSquadro($joueur);
                $partie->plateau = new PlateauSquadro();
                $partie->gameStatus = "waitingForPlayer";
                PDOSquadro::createPartieSquadro($_SESSION['player'], $partie->toJson());
                $_SESSION['partieID'] = PDOSquadro::getLastCreatedGameIdForPlayer($_SESSION['player']);
                $_SESSION['etat'] = 'consultePartieEnCours';
                header("Location: index.php");
                break;
            case "continuer":
                $listePartie = PDOSquadro::getAllOngoingPartieSquadroByPlayerName($_SESSION['player']);
                $html .= genererTableauParties($listePartie);
                break;
            case "quitter":
                //unset($_SESSION['partieID']);
                session_destroy();
                header('Location: login.php');
                break;
            case "lister":
                $listePartie = PDOSquadro::getAllPartieSquadroMissingAPlayer($_SESSION['player']);
                $html .= genererTableauParties($listePartie, 'waitingForPlayer');
                break;
            case "historique":
                $listePartie = PDOSquadro::getAllFinishedPartieSquadroByPlayerName($_SESSION['player']);
                $html .= genererTableauParties($listePartie, 'historique');
                break;
        }
    }

    $html .= "</body></html>";
    return $html;
}

/**
 * Génère un tableau HTML listant les parties disponibles.
 *
 * @param array $listeParties Liste des parties disponibles.
 * @param string $condition Filtre appliqué sur les parties (historique, en attente, etc.).
 * @return string HTML du tableau des parties.
 */
function genererTableauParties(array $listeParties, string $condition = ""): string {
    $html = '<table border="1">';
    $html .= '<tr><th>Partie ID</th><th>Joueur 1</th><th>Joueur 2</th><th>Action</th></tr>';

    foreach ($listeParties as $partie) {
        $nomJoueur1 = PDOSquadro::selectPlayerByiD($partie['playerone'])->getNomJoueur();
        $partieObj = PartieSquadro::fromJson($partie['json']);
        $numeroJoueur = ($partieObj->getJoueurs()[0]->getNomJoueur() == $_SESSION['player']) ? PartieSquadro::PLAYER_ONE : PartieSquadro::PLAYER_TWO;
        $nomJoueur2 = ($partie['playertwo'] === null) ? "En attente" : PDOSquadro::selectPlayerByiD($partie['playertwo'])->getNomJoueur();
        $trouve = ($partie['playertwo'] !== null);

        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($partie['partieid']) . '</td>';
        $html .= '<td>' . htmlspecialchars($nomJoueur1) . '</td>';
        $html .= '<td>' . htmlspecialchars($nomJoueur2) . '</td>';
        $html .= '<td><form method="POST" action="traiteActionSquadro.php">'
            . '<input type="hidden" name="partieId" value="' . $partie['partieid'] . '">'
            . '<input type="hidden" name="joueurActuel" value="' . $numeroJoueur . '">';
        if (!$trouve && $nomJoueur1 != $_SESSION['player']) {
            $html .= '<input type="hidden" name="sinscrire" value="oui">'
                . '<button type="submit">S\'inscrire</button>';
        } else {
            $html .= '<button type="submit">' . (($condition == "historique") ? "Consulter" : "Continuer") . '</button>';
        }
        $html .= '</form></td></tr>';
    }

    $html .= '</table>';
    return $html;
}

function conditionsIndex($partieID) : string{
    $partie = PDOSquadro::getPartieSquadroById($partieID);
    if ($partie->gameStatus == 'waitingForPlayer' AND $partie->joueurActif == $_POST['joueurActuel']) {
        if ($partie->joueurActif == PartieSquadro::PLAYER_ONE) {
            $_SESSION['joueurActif'] = 'joueurBlanc';
        } else {
            $_SESSION['joueurActif'] = 'joueurNoir';
        }
        return 'choixPiece';
    } elseif ($partie->gameStatus == 'finished') {
        return 'consultePartieVictoire';
    } else {
        return 'consultePartieEnCours';
    }
}