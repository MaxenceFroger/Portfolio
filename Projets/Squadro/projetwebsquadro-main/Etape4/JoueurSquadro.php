<?php

namespace Squadro\Etape4;

/**
 * Classe représentant un joueur dans le jeu Squadro.
 */
class JoueurSquadro
{
    /**
     * Identifiant unique du joueur.
     * @var int
     */
    private int $id;

    /**
     * Nom du joueur.
     * @var string
     */
    private string $nomJoueur;

    /**
     * Constructeur de la classe JoueurSquadro.
     */
    public function __construct()
    {
    }

    /**
     * Obtient l'identifiant du joueur.
     * @return int Identifiant du joueur.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Définit l'identifiant du joueur.
     * @param int $id Identifiant du joueur.
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Obtient le nom du joueur.
     * @return string Nom du joueur.
     */
    public function getNomJoueur(): string {
        return $this->nomJoueur;
    }

    /**
     * Définit le nom du joueur.
     * @param string $nomJoueur Nom du joueur.
     */
    public function setNomJoueur(string $nomJoueur): void {
        $this->nomJoueur = $nomJoueur;
    }

    /**
     * Sérialise l'objet JoueurSquadro en JSON.
     * @return string Représentation JSON de l'objet.
     */
    public function toJson(): string
    {
        $data = [
            'id' => $this->id,
            'nomJoueur' => $this->nomJoueur,
        ];

        return json_encode($data);
    }

    /**
     * Désérialise un JSON pour recréer une instance de JoueurSquadro.
     * @param string $json La chaîne JSON à désérialiser.
     * @return JoueurSquadro Instance recréée de JoueurSquadro.
     */
    public static function fromJson(string $json): JoueurSquadro
    {
        $data = json_decode($json, true);

        $joueur = new JoueurSquadro();
        $joueur->id = $data['id'] ?? 0;
        $joueur->nomJoueur = $data['nomJoueur'] ?? '';

        return $joueur;
    }
}