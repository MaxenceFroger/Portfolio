<?php

session_start();

use Squadro\Classe\ActionSquadro;
use Squadro\Classe\PieceSquadro;
use Squadro\Classe\PlateauSquadro;
use Squadro\ClassUI\PieceSquadroUI;
use Squadro\ClassUI\SquadroUIGenerator;

require_once "../ClassUI/SquadroUIGenerator.php";

$SquadroUIGen = new SquadroUIGenerator(new PieceSquadroUI(), "traiteActionSquadro.php", "traiteActionSquadro.php", "traiteActionSquadro.php", "traiteActionSquadro.php");


if ($_SESSION['etat'] == 'choixPiece') {
    $joueurActif = $_SESSION['joueurActif'];
    if ($joueurActif == 'Joueur Noir'){
        $_SESSION['etat'] = choisirPiece($_POST['piece_noire']);
    } else {
        $_SESSION['etat'] = choisirPiece($_POST['piece_blanche']);
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
elseif ($_SESSION['etat'] == 'victoire') {
    $_SESSION['etat'] = rejouer();
    header("Location: index.php");
}

/**
 * Confirme le choix d'une pièce et effectue un déplacement.
 * Vérifie si la partie est terminée après le déplacement.
 *
 * @return string "victoire" si un joueur gagne, "choixPiece" sinon, ou "erreur" en cas d'exception.
 */
function confirmerChoix(): string
{
    global $SquadroUIGen;
    $joueurActif = $_SESSION['joueurActif'];
    try {
        $SquadroUIGen->actionSquadro->jouePiece($_SESSION['x'], $_SESSION['y']);
        $fin = false;
        if ($joueurActif == "Joueur Blanc") {
            $fin = $SquadroUIGen->actionSquadro->remporteVictoire(PieceSquadro::BLANC);
        } else if ($joueurActif == "Joueur Noir") {
            $fin = $SquadroUIGen->actionSquadro->remporteVictoire(PieceSquadro::NOIR);
        }
        $_SESSION["plateau"] = $SquadroUIGen->actionSquadro->plateau->toJson();
        if ($fin) {
            return 'victoire';
        } else {
            $_SESSION['joueurActif'] = ($joueurActif === "Joueur Blanc") ? "Joueur Noir" : "Joueur Blanc";
        }
    } catch (Exception) {
        return 'erreur';
    }
    return 'choixPiece';
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
function rejouer(): string
{
    global $SquadroUIGen;
    if ($SquadroUIGen->actionSquadro->remporteVictoire(PieceSquadro::BLANC) || $SquadroUIGen->actionSquadro->remporteVictoire(PieceSquadro::NOIR) || session_status() != PHP_SESSION_ACTIVE) {
        $SquadroUIGen->actionSquadro = new ActionSquadro(new PlateauSquadro());
        $_SESSION["plateau"] = $SquadroUIGen->actionSquadro->plateau->toJson();
        unset($_SESSION['x']);
        unset($_SESSION['y']);
    }
    return 'choixPiece';
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


