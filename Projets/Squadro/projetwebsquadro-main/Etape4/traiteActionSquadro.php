<?php

session_start();

use Squadro\Classe\ActionSquadro;
use Squadro\Classe\PieceSquadro;
use Squadro\Classe\PlateauSquadro;
use Squadro\ClassUI\PieceSquadroUI;
use Squadro\ClassUI\SquadroUIGenerator;
use Squadro\Etape4\PartieSquadro;
use Squadro\Etape4\PDOSquadro;

require_once "../ClassUI/SquadroUIGenerator.php";
require_once "PDOSquadro.php";

$SquadroUIGen = new SquadroUIGenerator(new PieceSquadroUI(), "traiteActionSquadro.php", "traiteActionSquadro.php", "traiteActionSquadro.php", "traiteActionSquadro.php", 'bd');
PDOSquadro::initPDOEnv();

if ($_SESSION['etat'] == 'choixPiece') {
    $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
    if(isset($_POST['etat'])) {
        if ($_POST['etat'] == 'returnHome') $_SESSION['etat'] = retournerHome();
    } else {
        if ($partie->joueurActif == PartieSquadro::PLAYER_ONE) {
            $_SESSION['joueurActif'] = 'joueurBlanc';
        } else {
            $_SESSION['joueurActif'] = 'joueurNoir';
        }
        if ($_SESSION['joueurActif'] == 'joueurNoir') {
            $_SESSION['etat'] = choisirPiece($_POST['piece_noire']);
        } else {
            $_SESSION['etat'] = choisirPiece($_POST['piece_blanche']);
        }
    }
    header("Location: index.php");
} elseif ($_SESSION['etat'] == 'confirmationPiece') {
    if ($_POST['confirmation'] == 'confirmer') {
        $_SESSION['etat'] = confirmerChoix();
    } else {
        $_SESSION['etat'] = annulerChoix();
    }
    header("Location: index.php");
} elseif ($_SESSION['etat'] == 'erreur') {
    $_SESSION['etat'] = rejouer();
    header("Location: index.php");
}
elseif ($_SESSION['etat'] == 'consultePartieVictoire') {
    $_SESSION['etat'] = retournerHome();
    header("Location: index.php");
} elseif ($_SESSION['etat'] == 'home'){
    $_SESSION['partieID'] = $_POST['partieId'];
    if (isset($_POST['sinscrire'])){
        $_SESSION['fait'] = 'fait';
        addPlayer();
    }
    $_SESSION['etat'] = conditions();
    header('Location: index.php');
} elseif ($_SESSION['etat'] == 'consultePartieEnCours'){
    if ($_POST['etat'] == 'returnHome') $_SESSION['etat'] = retournerHome();
    if ($_POST['etat'] == 'condition') $_SESSION['etat'] = conditions();
    header("Location: index.php");
}

/**
 * Confirme le choix d'une pièce et effectue un déplacement.
 * Vérifie si la partie est terminée après le déplacement.
 *
 * @return string "consultePartieVictoire" si un joueur gagne, "choixPiece" sinon, ou "erreur" en cas d'exception.
 */
function confirmerChoix(): string
{
    global $SquadroUIGen;
    $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
    if ($partie->getJoueurActif() == PartieSquadro::PLAYER_ONE){
        $joueurActif = "Joueur Blanc";
    } else {
        $joueurActif = "Joueur Noir";
    }
    try {
        $SquadroUIGen->actionSquadro->jouePiece($_SESSION['x'], $_SESSION['y']);
        if ($joueurActif == "Joueur Blanc") {
            $fin = $SquadroUIGen->actionSquadro->remporteVictoire(PieceSquadro::BLANC);
        } else {
            $fin = $SquadroUIGen->actionSquadro->remporteVictoire(PieceSquadro::NOIR);
        }
        $partie->plateau = $SquadroUIGen->actionSquadro->plateau;
        PDOSquadro::savePartieSquadro('waitingForPlayer', $partie->toJson(), $partie->getPartieID());
        if ($fin) {
            PDOSquadro::savePartieSquadro('finished', $partie->toJson(), $partie->getPartieID());
            return 'consultePartieVictoire';
        } else {
            $partie->joueurActif = ($partie->joueurActif + 1) % 2;
            PDOSquadro::savePartieSquadro('waitingForPlayer', $partie->toJson(), $partie->getPartieID());
        }
    } catch (Exception) {
        return 'erreur';
    }
    return 'consultePartieEnCours';
}

/**
 * Annule le choix de la pièce en supprimant les coordonnées stockées en session.
 *
 * @return string Retourne "choixPiece" pour signaler le retour à l'état de choix.
 */
function annulerChoix(): string
{
    unset($_SESSION['x']);
    unset($_SESSION['y']);
    return 'choixPiece';
}

/**
 * Réinitialise la partie en créant un nouveau plateau et une nouvelle instance d'ActionSquadro.
 *
 * @return string Retourne "choixPiece" pour recommencer une partie.
 */
function retournerHome(): string
{
    //unset($_SESSION['partieID']);
    unset($_SESSION['x']);
    unset($_SESSION['y']);

    return 'home';
}

/**
 * Sélectionne une pièce à jouer si elle est jouable.
 *
 * @param string $pieceChoisie Les coordonnées de la pièce sous forme de chaîne (ex: "0,2").
 *
 * @return string Retourne "confirmationPiece" si la pièce est jouable, sinon "erreur".
 */
function choisirPiece(string $pieceChoisie): string
{
    global $SquadroUIGen;
    $jouable = false;
    $x = "";
    $y = "";
    if ($pieceChoisie != "") {
        $tabCoord = str_split($pieceChoisie);
        $x = (int)$tabCoord[0];
        $y = (int)$tabCoord[2];
        $jouable = $SquadroUIGen->actionSquadro->estJouablePiece($x, $y);
    }
    if (!$jouable || (session_status() != PHP_SESSION_ACTIVE)) {
        return 'erreur';
    } else {
        $_SESSION['x'] = $x;
        $_SESSION['y'] = $y;
    }

    return 'confirmationPiece';
}

function conditions() : string{
    $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
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

function addPlayer() : void {
    $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
    PDOSquadro::addPlayerToPartieSquadro($_SESSION['player'], $partie->toJson(),$_SESSION['partieID']);
}


