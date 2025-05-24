<?php

namespace Squadro\ClassUI;

class PieceSquadroUI {


    /**
     * Génère un bouton pour une case vide.
     *
     * @access public
     * @return string Code HTML pour une case vide.
     */
    public function caseVide(): string {
        return '<button class="case-vide" disabled></button>';
    }

    /**
     * Génère un bouton pour une case neutre.
     *
     * @access public
     * @return string Code HTML pour une case neutre.
     */
    public function caseNeutre(): string {
        return '<button class="case-neutre" disabled></button>';
    }

    /**
     * Génère un bouton pour une pièce noire avec des coordonnées.
     *
     * @access public
     * @param int  $x            Coordonnée en ligne.
     * @param int  $y            Coordonnée en colonne.
     * @param bool $selectionnee Indique si la pièce est sélectionnée.
     *
     * @return string Code HTML pour une pièce noire.
     */
    public function pieceNoire(int $x, int $y, bool $selectionnee = false): string {
        $selectedClass = $selectionnee ? ' selected' : '';
        $coords = $selectionnee ? "data-x='$x' data-y='$y'" : '';
        $disabled = $selectionnee ? '' : 'disabled';
        return "<button class='piece-noire$selectedClass' $coords name='piece_noire' value='$x,$y' $disabled></button>";
    }

    /**
     * Génère un bouton pour une pièce blanche avec des coordonnées.
     *
     * @access public
     * @param int  $x            Coordonnée en ligne.
     * @param int  $y            Coordonnée en colonne.
     * @param bool $selectionnee Indique si la pièce est sélectionnée.
     *
     * @return string Code HTML pour une pièce blanche.
     */
    public function pieceBlanche(int $x, int $y, bool $selectionnee = false): string {
        $selectedClass = $selectionnee ? ' selected' : '';
        $coords = $selectionnee ? "data-x='$x' data-y='$y'" : '';
        $disabled = $selectionnee ? '' : 'disabled';
        return "<button class='piece-blanche$selectedClass' $coords name='piece_blanche' value='$x,$y' $disabled></button>";
    }

    public function caseRose(string $valeur): string {
        return "<button class='case-rose' disabled>$valeur</button>";
    }



}
