<?php
namespace Squadro\Etape4;

use PDO;
use PDOException;
use PDOStatement;
use Squadro\Classe\PlateauSquadro;
use Squadro\Etape4\PartieSquadro;
require_once 'env/db.php';
require_once 'PartieSquadro.php';


class PDOSquadro
{
    private static PDO $pdo;

    public static function initPDO(string $sgbd, string $host, string $db, string $user, string $password, string $port = '5532'): void
    {

        switch ($sgbd) {
           case 'mysql':
                break;
            case 'pgsql':
                self::$pdo = new PDO('pgsql:host=' . $host . ' dbname=' . $db . ' user=' . $user . ' password=' . $password . ' port=' . $port);
                break;
            default:
                exit ("Type de sgbd non correct : $sgbd fourni, 'pgsql' attendu");
        }
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function initPDOEnv(): void {
        self::initPDO($_ENV['sgbd'],$_ENV['host'],$_ENV['database'],$_ENV['user'],$_ENV['password'], $_ENV['port']);
    }

    /* requêtes Préparées pour l'entitePlayerSquadro */
    private static PDOStatement $createPlayerSquadro;
    private static PDOStatement $selectPlayerByName;
    private static PDOStatement $selectPlayerById;

    /******** Gestion des requêtes relatives à JoueurSquadro *************/
    public static function createPlayer(string $name): JoueurSquadro
    {
        try {
            self::$createPlayerSquadro = self::$pdo->prepare("INSERT INTO JoueurSquadro (joueurNom) VALUES (?)");
            // Exécution avec un paramètre sécurisé
            self::$createPlayerSquadro->execute(array($name));

        } catch (PDOException $e) {
            print $e->getMessage();
        }
        return self::selectPlayerByName($name);
    }

    public static function selectPlayerByName(string $name): ?JoueurSquadro
    {
        try {
            self::$selectPlayerByName = self::$pdo->prepare("SELECT * FROM JoueurSquadro WHERE joueurNom =  ?");
            self::$selectPlayerByName->execute(array($name));
            $joueurbd = self::$selectPlayerByName->fetch(PDO::FETCH_ASSOC);
            if ($joueurbd['joueurnom'] == null) {
                return null;
            }
            $joueurSquadro = new JoueurSquadro();
            $joueurSquadro->setId($joueurbd['id']);
            $joueurSquadro->setNomJoueur($joueurbd['joueurnom']);
            return $joueurSquadro;
        } catch (PDOException $e) {
            echo $e->getMessage()."\n";
            return null;
        }

    }

    public static function selectPlayerByiD(int $id): ?JoueurSquadro
    {
        try {
            self::$selectPlayerById = self::$pdo->prepare("SELECT * FROM JoueurSquadro WHERE id =  ?");
            self::$selectPlayerById->execute(array($id));
            $joueurbd = self::$selectPlayerById->fetch(PDO::FETCH_ASSOC);
            $joueurSquadro = new JoueurSquadro();
            if ($joueurbd == null) {
                return null;
            }
            $joueurSquadro->setId($joueurbd['id']);
            $joueurSquadro->setNomJoueur($joueurbd['joueurnom']);
            return $joueurSquadro;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return null;
    }

    /* requêtes préparées pour l'entite PartieSquadro */
    private static PDOStatement $createPartieSquadro;
    private static PDOStatement $savePartieSquadro;
    private static PDOStatement $addPlayerToPartieSquadro;
    private static PDOStatement $selectPartieSquadroById;
    private static PDOStatement $selectAllPartieSquadro;
    private static PDOStatement $selectAllPartieSquadroByPlayerName;
    private static PDOStatement $selectLastAccessedPartieSquadro;
    private static  PDOStatement $selectLastCreatedPartieSquadroByPlayerName;
    private static PDOStatement $selectAllFinishedPartieSquadroByPlayerName;
    private static PDOStatement $selectAllPartieSquadroMissingAPlayer;
    private static PDOStatement $selectAllOngoingPartieSquadroByPlayerName;

    /******** Gestion des requêtes relatives à PartieSquadro *************/

    /**
     * initialisation et execution de $createPartieSquadro la requête préparée pour enregistrer une nouvelle partie
     */
    public static function createPartieSquadro(string $playerName, string $json): void
    {
        $idJoueur = self::selectPlayerByName($playerName)->getId();
        self::$createPartieSquadro = self::$pdo->prepare("INSERT INTO PartieSquadro (playerOne, playerTwo, json) VALUES (? , NULL, ?)");

        self::$createPartieSquadro->execute(array($idJoueur, $json));

    }

    /**
     * initialisation et execution de $savePartieSquadro la requête préparée pour changer
     * l'état de la partie et sa représentation json
     */
    public static function savePartieSquadro(string $gameStatus, string $json, int $partieId): void
    {
        self::$savePartieSquadro = self::$pdo->prepare("UPDATE PartieSquadro SET gameStatus =   ?, json  = ?  WHERE partieId =  ?");
        self::$savePartieSquadro->execute(array($gameStatus, $json, $partieId));
    }

    /**
     * initialisation et execution de $addPlayerToPartieSquadro la requête préparée pour intégrer le second joueur
     */
    public static function addPlayerToPartieSquadro(string $playerName, string $json, int $gameId): void
    {
        $partie = PartieSquadro::fromJson($json);
        $joueurs2 = self::selectPlayerByName($playerName);
        $partie->addJoueur($joueurs2);
        $jsonModifie = $partie->toJson();
	    self::$addPlayerToPartieSquadro = self::$pdo->prepare("UPDATE PartieSquadro SET playerTwo  =  ? , json  = ?, gameStatus = 'waitingForPlayer' WHERE partieId =  ?");
        self::$addPlayerToPartieSquadro->execute(array($joueurs2->getId(), $jsonModifie, $gameId));

    }

    /**
     * initialisation et execution de $selectPartieSquadroById la requête préparée pour récupérer
     * une instance de PartieSquadro en fonction de son identifiant
     */
    public static function getPartieSquadroById(int $gameId): ?PartieSquadro
    {
        self::$selectPartieSquadroById = self::$pdo->prepare("SELECT * FROM PartieSquadro WHERE partieId = ?");
        self::$selectPartieSquadroById->execute(array($gameId));
        $partieBd = self::$selectPartieSquadroById->fetch(PDO::FETCH_ASSOC);
        $partieSquadro = new PartieSquadro(self::selectPlayerByiD($partieBd['playerone']));
        $partieSquadro->setPartieID($partieBd['partieid']);
        if ($partieBd['playertwo'] != null) {
            $partieSquadro->addJoueur(self::selectPlayerByiD($partieBd['playertwo']));
        }
        $partieJson = PartieSquadro::fromJson($partieBd['json']);
        $partieSquadro->joueurActif = $partieJson->getJoueurActif();
        $partieSquadro->gameStatus = $partieBd['gamestatus'];
        $partieSquadro->plateau = $partieJson->plateau;

        return $partieSquadro;
    }
    /**
     * initialisation et execution de $selectAllPartieSquadro la requête préparée pour récupérer toutes
     * les instances de PartieSquadro
     */
    public static function getAllPartieSquadro(): array
    {
	    self::$selectAllPartieSquadro = self::$pdo->prepare("SELECT * FROM PartieSquadro");
        self::$selectAllPartieSquadro->execute();
        return self::$selectAllPartieSquadro->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * initialisation et execution de $selectAllPartieSquadroByPlayerName la requête préparée pour récupérer les instances
     * de PartieSquadro accessibles au joueur $playerName
     * ne pas oublier les parties "à un seul joueur"
     */
    public static function getAllPartieSquadroByPlayerName(string $playerName): array
    {
	    $playerBD = self::selectPlayerByName($playerName);
        $id = $playerBD->getId();
        self::$selectAllPartieSquadroByPlayerName = self::$pdo->prepare("SELECT * FROM PartieSquadro WHERE playerOne =  ? OR playerTwo =   ?");
        self::$selectAllPartieSquadroByPlayerName->execute(array($id, $id));
        return self::$selectAllPartieSquadroByPlayerName->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * initialisation et execution de la requête préparée pour récupérer
     * l'identifiant de la dernière partie ouverte par $playername
     */
    public static function getLastGameIdForPlayer(string $playerName): int
    {
        self::$selectLastAccessedPartieSquadro= self::$pdo->prepare("SELECT * FROM PartieSquadro WHERE partieid = ?");
        self::$selectLastAccessedPartieSquadro->execute(array($_SESSION['partieID']));
        $partieBd = self::$selectLastAccessedPartieSquadro->fetch(PDO::FETCH_ASSOC);
        return $partieBd['partieid'];
    }

    /**
     * initialisation et execution de la requête préparée pour
     * avoir de la dernière partie créée par $playername
     *
     * @param string $playerName nom du joueur actuel
     * @return int id de la partie
     */
    public static function getLastCreatedGameIdForPlayer(string $playerName): int {
        self::$selectLastCreatedPartieSquadroByPlayerName= self::$pdo->prepare("SELECT * FROM PartieSquadro WHERE playerone = ? ORDER BY partieid DESC LIMIT 1");
        self::$selectLastCreatedPartieSquadroByPlayerName->execute(array(self::selectPlayerByName($playerName)->getId()));
        $partieBd = self::$selectLastCreatedPartieSquadroByPlayerName->fetch(PDO::FETCH_ASSOC);
        return $partieBd['partieid'];
    }
    /**
     * initialisation et execution de la requête préparée pour
     * avoir toutes les parties terminées par un joueur donné en paramètre
     *
     * @param string $playerName nom du joueur actuel
     * @return array le tableau obtenu
     */
    public static function getAllFinishedPartieSquadroByPlayerName(string $playerName): array
    {
        $playerBD = self::selectPlayerByName($playerName);
        $id = $playerBD->getId();
        self::$selectAllFinishedPartieSquadroByPlayerName = self::$pdo->prepare("SELECT * FROM PartieSquadro WHERE (playerOne =  ? OR playerTwo =   ?) AND gameStatus = 'finished' ORDER BY partieid");
        self::$selectAllFinishedPartieSquadroByPlayerName->execute(array($id, $id));
        return self::$selectAllFinishedPartieSquadroByPlayerName->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * initialisation et execution de la requête préparée pour
     * avoir toutes les parties où il manque un joueur mais différent du joueur actuel
     *
     * @param string $playerName nom du joueur actuel
     * @return array le tableau obtenu
     */
    public static function getAllPartieSquadroMissingAPlayer(string $playername): array
    {
        self::$selectAllPartieSquadroMissingAPlayer = self::$pdo->prepare("SELECT * FROM PartieSquadro WHERE playerTwo IS NULL AND playerone != ? ORDER BY partieid");
        self::$selectAllPartieSquadroMissingAPlayer->execute(array(self::selectPlayerByName($playername)->getId()));
        return self::$selectAllPartieSquadroMissingAPlayer->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * initialisation et execution de la requête préparée pour
     * avoir toutes les parties en cours du joueur actuel
     *
     * @param string $playerName nom du joueur actuel
     * @return array le tableau obtenu
     */
    public static function getAllOngoingPartieSquadroByPlayerName(string $playerName): array
    {
        $playerBD = self::selectPlayerByName($playerName);
        $id = $playerBD->getId();
        self::$selectAllOngoingPartieSquadroByPlayerName = self::$pdo->prepare("SELECT * FROM PartieSquadro WHERE (playerOne =  ? OR playerTwo =   ?) AND gamestatus != 'finished' ORDER BY partieid");
        self::$selectAllOngoingPartieSquadroByPlayerName->execute(array($id, $id));
        return self::$selectAllOngoingPartieSquadroByPlayerName->fetchAll(PDO::FETCH_ASSOC);
    }

}
