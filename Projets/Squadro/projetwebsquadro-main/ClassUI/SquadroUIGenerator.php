<?php

namespace Squadro\ClassUI;

use Squadro\Classe\ActionSquadro;
use Squadro\Classe\PieceSquadro;
use Squadro\Classe\PlateauSquadro;
use Squadro\Etape4\PartieSquadro;
use Squadro\Etape4\PDOSquadro;

require_once 'PieceSquadroUI.php';
require_once '../Classe/ActionSquadro.php';
require_once '../Etape4/PartieSquadro.php';

/**
 *
 */
class SquadroUIGenerator
{
    /**
     * Interface utilisateur pour les pièces du jeu.
     *
     * @var PieceSquadroUI
     */
    public PieceSquadroUI $pieceUI;

    /**
     * Page du plateau de jeu.
     *
     * @var string
     */
    public string $pagePlateau;

    /**
     * Page de confirmation.
     *
     * @var string
     */
    public string $pageConfirme;

    /**
     * Page affichant la victoire.
     *
     * @var string
     */
    public string $pageVictoire;

    /**
     * Page affichant la page d'erreur.
     *
     * @var string
     */
    public string $pageErreur;

    /**
     * Actions possibles sur le plateau Squadro.
     *
     * @var ActionSquadro
     */
    public ActionSquadro $actionSquadro;

    private string $mode;

    /**
     * Constructeur de la classe SquadroUIGenerator.
     *
     * @param PieceSquadroUI $p Interface utilisateur des pièces.
     * @param string $pagePlateau Page du plateau.
     * @param string $pageConfirme Page de confirmation.
     * @param string $pageVictoire Page de victoire.
     */
    public function __construct(PieceSquadroUI $p, string $pagePlateau, string $pageConfirme, string $pageVictoire, string $pageErreur, string $mode = 'session')
    {
        $this->pieceUI = $p;
        $this->pagePlateau = $pagePlateau;
        $this->pageConfirme = $pageConfirme;
        $this->pageVictoire = $pageVictoire;
        $this->pageErreur = $pageErreur;
        $this->mode = $mode;
        if($mode == 'session') {
            if (isset($_SESSION['plateau'])) $this->actionSquadro = new ActionSquadro(PlateauSquadro::fromJson($_SESSION["plateau"]));
            else $this->actionSquadro = new ActionSquadro(new PlateauSquadro());
            if (!isset($_SESSION['joueurActif'])) {
                $_SESSION['joueurActif'] = "Joueur Blanc";
            }
        } elseif ($mode == 'bd'){
            if(isset($_SESSION['partieID'])) {
                PDOSquadro::initPDOEnv();
                $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
                $this->actionSquadro = new ActionSquadro($partie->plateau);
            } else $this->actionSquadro = new ActionSquadro(new PlateauSquadro());
        }
    }

    /**
     * Génère la page pour jouer une pièce.
     *
     * @return string HTML de la page.
     */

    public function pageJouerPiece(): string
    {
        $joueurActif = "";
        if ($this->mode == 'session') $joueurActif = "Tour de " . $_SESSION['joueurActif'];
        elseif ($this->mode == 'bd') {
            PDOSquadro::initPDOEnv();
            $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
            if ($partie->getJoueurActif() == 0){
                $joueurActif = "Partie ID : " . $partie->getPartieID() . "<br/> Tour de Joueur Blanc : ". $_SESSION['player'];
            } else {
                $joueurActif = "Partie ID : " . $partie->getPartieID() . "<br/> Tour de Joueur Noir : ". $_SESSION['player'];
            }
        }
        $html = "<html lang=\"fr\">
    <head>
        <link rel='stylesheet' href='../css/style.css'>
        <title>Jouer une Pièce</title>
    </head>
    <body>";

        $html .= "<h1>$joueurActif</h1>";
        $html .= "<form action=$this->pageConfirme method='POST'>
                <p>Sélectionnez une pièce à déplacer :</p>";

        $html .= $this->creePlateau();

        $html .= " </form>";
        if($this->mode == "bd") {
            $html .= "<form action=$this->pagePlateau method='POST'>
                            <button class='interagir' type='submit' name='etat' value='returnHome'>Retour à l'accueil</button>
                        </form>";
        }
        $html .= "</body></html>";
        return $html;
    }

    /**
     * Crée le plateau de jeu.
     *
     * @return string HTML du plateau.
     */

    private function creePlateau(): string
    {
        $joueurActif = "";
        if ($this->mode == 'session') $joueurActif = $_SESSION['joueurActif'];
        elseif ($this->mode == 'bd') {
            PDOSquadro::initPDOEnv();
            $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);

            if ($partie->getJoueurActif() == PartieSquadro::PLAYER_ONE){
                $joueurActif = "Joueur Blanc";
            } else {
                $joueurActif = "Joueur Noir";
            }

            if (count($partie->getJoueurs()) == 1) {
                $joueurActif = "";
            } else if ($partie->getJoueurs()[$partie->getJoueurActif()]->getNomJoueur() != $_SESSION['player']) {
                $joueurActif = "";
            }

            if ($partie->gameStatus == 'finished'){
                $joueurActif = "";
            }



        }
        $html = "<div class='board'>";
        for ($i = 0; $i < 9; $i++) {
            if ($i == 0 || $i == 1 || $i == 7 || $i == 8) {
                $html .= $this->pieceUI->caseRose("");
            } else {
                $html .= $this->pieceUI->caseRose(PlateauSquadro::NOIR_V_RETOUR[$i - 1]);
            }
        }
        for ($row = 0; $row < 7; $row++) {
            if ($row == 0 || $row == 6) $html .= $this->pieceUI->caseRose("");
            else $html .= $this->pieceUI->caseRose(PlateauSquadro::BLANC_V_ALLER[$row]);

            for ($col = 0; $col < 7; $col++) {
                $piece = $this->actionSquadro->plateau->getPiece($row, $col);
                if ($piece->getCouleur() == PieceSquadro::NEUTRE) {
                    $html .= $this->pieceUI->caseNeutre();
                } elseif ($piece->getCouleur() == PieceSquadro::BLANC) {
                    $selectionnee = ($joueurActif === "Joueur Blanc");
                    if($selectionnee) $selectionnee = $this->actionSquadro->estJouablePiece($row, $col);
                    $html .= $this->pieceUI->pieceBlanche($row, $col, $selectionnee);
                } elseif ($piece->getCouleur() == PieceSquadro::NOIR) {
                    $selectionnee = ($joueurActif === "Joueur Noir");
                    if($selectionnee) $selectionnee = $this->actionSquadro->estJouablePiece($row, $col);
                    $html .= $this->pieceUI->pieceNoire($row, $col, $selectionnee);
                } else {
                    $html .= $this->pieceUI->caseVide();
                }
            }
            if ($row == 0 || $row == 6) $html .= $this->pieceUI->caseRose("");
            else $html .= $this->pieceUI->caseRose(PlateauSquadro::BLANC_V_RETOUR[$row]);

        }
        for ($i = 0; $i < 9; $i++) {
            if ($i == 0 || $i == 1 || $i == 7 || $i == 8) {
                $html .= $this->pieceUI->caseRose("");
            } else {
                $html .= $this->pieceUI->caseRose(PlateauSquadro::NOIR_V_ALLER[$i - 1]);
            }
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * Génère une page demandant de confirmer le déplacement de la pièce choisie.
     *
     * @return string HTML de la page de confirmation.
     */

    public function pageConfirmerDeplacement(): string
    {
        $joueurActif = "";
        if ($this->mode == 'session') $joueurActif = $_SESSION['joueurActif'];
        elseif ($this->mode == 'bd') {
            PDOSquadro::initPDOEnv();
            $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
            if ($partie->getJoueurActif() == 0){
                $joueurActif = "Joueur Blanc : " . $_SESSION['player'];
            } else {
                $joueurActif = "Joueur Noir : " . $_SESSION['player'];
            }
        }
        return "<html lang=\"fr\">
                    <head><title>Confirmer le Déplacement</title></head>
                    <link rel='stylesheet' href='../css/etape4.css'>
                    <body>
                        <h1>Confirmez votre déplacement</h1>
                        <h2>$joueurActif</h2>
                        <p>Vous avez choisi la pièce en position ". $_SESSION['x'] . ', '. $_SESSION['y']."</p>
                        <form action=$this->pagePlateau method='POST'>
                            <button type='submit' name='confirmation' value='confirmer'>Confirmer</button>
                            <button type='submit' name='confirmation' value='annuler'>Annuler</button>
                        </form>
                    </body>
                </html>";
    }

    /**
     * Génère une page affichant le plateau final et le message de victoire.
     *
     * @param string $gagnant Joueur ayant remporté la partie.
     *
     * @return string HTML de la page de victoire.
     */

    public function pagePlateauFinal(string $gagnant): string
    {
        $html = "<html lang=\"fr\">
                    <head><title>Victoire !</title><link rel='stylesheet' href='../css/style.css'></head>
                    <body>
                        <h1>Félicitations !</h1>
                        <p>Le joueur $gagnant a remporté la partie.</p>";
        $html .= $this->creePlateau();
        $html .= " <form action=$this->pagePlateau method='POST'>
                            <button class='interagir' type='submit' name='victoire' value='victoire'>Retour à l'accueil</button>
                        </form></body>
                </html>";
        return $html;
    }

    /**
     * Génère une page affichant le plateau en cours et des boutons pour recharger la page ou la quitter
     *
     * @param string $joueur Joueur actuel
     *
     * @return string HTML de la page de en cours.
     */
    public function pagePlateauEnCours(string $joueur): string
    {
        $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
        if($partie->getJoueurs()[0]->getNomJoueur() == $_SESSION['player']) {
            $numeroJoueur = PartieSquadro::PLAYER_ONE;
        } else {
            $numeroJoueur = PartieSquadro::PLAYER_TWO;
        }
        $joueurPasActif = "";
        if ($this->mode == 'session') $joueurPasActif =  $joueur;
        elseif ($this->mode == 'bd') {
            PDOSquadro::initPDOEnv();
            $partie = PDOSquadro::getPartieSquadroById($_SESSION['partieID']);
            if ($partie->getJoueurActif() == 0){
                $joueurPasActif = "Partie ID : " . $partie->getPartieID() . "<br/> Ce n'est pas votre tour ". $joueur;
            } else {
                $joueurPasActif = "Partie ID : " . $partie->getPartieID() . "<br/> Ce n'est pas votre tour ". $joueur;
            }
        }
        $html = "<html lang=\"fr\">
                    <head><title>Partie en cours</title><link rel='stylesheet' href='../css/style.css'></head>
                    <body>
                       <h1>$joueurPasActif</h1>";
        $html .= $this->creePlateau();
        $html .= "<form action=$this->pagePlateau method='POST'>
                            <button class='interagir' type='submit' name='etat' value='returnHome'>Retour à l'accueil</button>
                            <button class='interagir' type='submit' name='etat' value='condition'>Recharger</button>
                            <input type='hidden' name='joueurActuel' value='" . $numeroJoueur ."'>
                        </form> </body>
                </html>";
        return $html;
    }

    /**
     * Génère une page affichant une page d'erreur
     *
     * @return string HTML de la page d'erreur.
     */
    public function pageErreur(): string
    {
        $html = "<html lang=\"fr\">
                    <head><title>Erreur</title><link rel='stylesheet' href='../css/etape4.css'></head>
                    <body>
                        <h1>Erreur</h1>
                        <p>Vous avez provoqué une erreur, veuillez rejouer votre coup</p>
                        <form action=$this->pagePlateau method='POST'>
                            <button class='interagir' type='submit' name='erreur' value='erreur'>Retour au plateau</button>
                        </form>";
        $html .= ' </body>
                </html>';
        return $html;
    }
}
