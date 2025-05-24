<?php

namespace Squadro\Classe;

use ArrayAccess;
use Countable;

require_once 'PieceSquadro.php';

class ArrayPieceSquadro implements ArrayAccess, Countable
{
    /**
     * Tableau des pièces
     * @access private
     * @var array<int, PieceSquadro>
     */
    private array $pieces = [];

    /**
     * Ajoute une pièce au tableau
     * @access public
     * @param PieceSquadro $piece La pièce à ajouter
     * @return void
     */
    public function add(PieceSquadro $piece): void
    {
        $this->pieces[] = $piece;
    }

    /**
     * Supprime une pièce par son index
     * @access public
     * @param int $index L'index de la pièce à supprimer
     * @return void
     */
    public function remove(int $index): void
    {
        if (isset($this->pieces[$index])) {
            unset($this->pieces[$index]);
            $this->pieces = array_values($this->pieces); // Réindexation
        }
    }

    /**
     * Retourne une représentation en chaîne de caractères de l'objet
     * Utilise la méthode __toString de PieceSquadro
     * @access public
     * @return string
     */
    public function __toString(): string
    {
        return implode(", ", array_map(fn($piece) => (string)$piece, $this->pieces));
    }

    /**
     * Sérialise l'objet en JSON
     * Utilise la méthode toJson de PieceSquadro
     * @access public
     * @return string
     */
    public function toJson(): string
    {
        return json_encode(array_map(fn($piece) => json_decode($piece->toJson(), true), $this->pieces));
    }

    /**
     * Désérialise un JSON pour recréer une instance de ArrayPieceSquadro
     * Utilise la méthode fromJson de PieceSquadro
     * @access public
     * @param string $json La chaîne JSON à désérialiser
     * @return ArrayPieceSquadro
     */
    public static function fromJson(string $json): ArrayPieceSquadro
    {
        $data = json_decode($json, true);
        $arrayPiece = new self();
        foreach ($data as $pieceData) {
            $arrayPiece->add(PieceSquadro::fromJson(json_encode($pieceData)));
        }
        return $arrayPiece;
    }

    /**
     * Vérifie si une pièce existe à un index donné
     * Implémentation de ArrayAccess::offsetExists
     * @access public
     * @param int $offset L'index à vérifier
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->pieces[$offset]);
    }

    /**
     * Retourne une pièce à un index donné
     * Implémentation de ArrayAccess::offsetGet
     * @access public
     * @param int $offset L'index à récupérer
     * @return PieceSquadro|null
     */
    public function offsetGet($offset): ?PieceSquadro
    {
        return $this->pieces[$offset] ?? null;
    }

    /**
     * Ajoute ou remplace une pièce à un index donné
     * Implémentation de ArrayAccess::offsetSet
     * @access public
     * @param int|null $offset L'index où insérer ou remplacer la valeur
     * @param PieceSquadro $value La pièce à insérer
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if ($value instanceof PieceSquadro) {
            if (!$this->offsetExists($offset)) {
                $this->add($value);
            } else {
                $this->pieces[$offset] = $value;
            }
        }
    }

    /**
     * Supprime une pièce à un index donné
     * Implémentation de ArrayAccess::offsetUnset
     * @access public
     * @param int $offset L'index à supprimer
     * @return void
     */
    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }

    /**
     * Retourne le nombre de pièces
     * Implémentation de Countable::count
     * @access public
     * @return int
     */
    public function count(): int
    {
        return count($this->pieces);
    }
}
