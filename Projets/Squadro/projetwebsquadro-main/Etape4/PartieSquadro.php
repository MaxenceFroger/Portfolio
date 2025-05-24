<?php

namespace Squadro\Etape4;

use Squadro\Classe\ActionSquadro;
use Squadro\Classe\PieceSquadro;
use Squadro\Classe\PlateauSquadro;

require_once 'JoueurSquadro.php';
require_once '../Classe/PlateauSquadro.php';

/**
 * Classe représentant une partie du jeu Squadro.
 */
class PartieSquadro
{
    /**
     * Constante représentant le premier joueur.
     */
    public const PLAYER_ONE = 0;

    /**
     * Constante représentant le deuxième joueur.
     */
    public const PLAYER_TWO = 1;

    /**
     * Identifiant unique de la partie.
     * @var int|null
     */
    private ?int $partieID = 0;

    /**
     * Tableau contenant les joueurs de la partie.
     * @var array
     */
    private array $joueurs;

    /**
     * Index du joueur actif.
     * @var int
     */
    public int $joueurActif;

    /**
     * Statut actuel de la partie.
     * @var string
     */
    public string $gameStatus = "initialized";

    /**
     * Plateau de jeu associé à la partie.
     * @var PlateauSquadro
     */
    public PlateauSquadro $plateau;

    /**
     * Constructeur de la classe PartieSquadro.
     * @param JoueurSquadro $playerOne Premier joueur de la partie.
     */
    public function __construct(JoueurSquadro $playerOne) {
        $this->joueurs = array($playerOne);
        $this->plateau = new PlateauSquadro();
        $this->joueurActif = rand(0,1);
    }

    /**
     * Ajoute un joueur à la partie.
     * @param JoueurSquadro $player Joueur à ajouter.
     */
    public function addJoueur(JoueurSquadro $player) : void{
        if(count($this->joueurs) < 2) {array_push($this->joueurs, $player);}
    }

    /**
     * Obtient l'index du joueur actif.
     * @return int Index du joueur actif.
     */
    public function getJoueurActif() : int {
        return $this->joueurActif;
    }

    /**
     * Obtient le nom du joueur actif.
     * @return string Nom du joueur actif.
     */
    public function getNomJoueurActif() : string{
        return $this->joueurs[$this->getJoueurActif()]->getNomJoueur();
    }

    /**
     * Convertit l'objet en chaîne de caractères.
     * @return string Représentation textuelle de l'objet.
     */
    public function __toString() : string {
        return $this->getNomJoueurActif() . " - ";
    }

    /**
     * Obtient l'identifiant de la partie.
     * @return int|null Identifiant de la partie.
     */
    public function getPartieID(): ?int
    {
        return $this->partieID;
    }

    /**
     * Définit l'identifiant de la partie.
     * @param int $partieID Identifiant de la partie.
     */
    public function setPartieID(int $partieID) : void {
        $this->partieID = $partieID;
    }

    /**
     * Obtient la liste des joueurs de la partie.
     * @return array Liste des joueurs.
     */
    public function getJoueurs() : array {
        return $this->joueurs;
    }

    /**
     * Sérialise l'objet PartieSquadro en JSON.
     * @return string Représentation JSON de l'objet.
     */
    public function toJson(): string
    {
        $data = [
            'joueurs' => array_map(fn($ligne) => json_decode($ligne->toJson(), true), $this->joueurs),
            'gameStatus' => $this->gameStatus,
            'joueurActif' => $this->joueurActif,
            'plateau' => $this->plateau->toJson(),
        ];
        return json_encode($data);
    }

    /**
     * Désérialise un JSON pour recréer une instance de PartieSquadro.
     * @param string $json La chaîne JSON à désérialiser.
     * @return PartieSquadro Instance recréée de PartieSquadro.
     */
    public static function fromJson(string $json): PartieSquadro
    {
        $data = json_decode($json, true);

        $partie = new PartieSquadro(new JoueurSquadro());

        foreach ($data['joueurs'] as $x => $joueur) {
            $partie->joueurs[$x] = JoueurSquadro::fromJson(json_encode($joueur));
        }
        $partie->gameStatus = $data['gameStatus'] ?? "initialized";
        $partie->joueurActif = $data['joueurActif'] ?? [];
        $partie->plateau = PlateauSquadro::fromJson($data['plateau']) ?? [];

        return $partie;
    }
}