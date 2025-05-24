-- 1 Donner une procédure permettant l'édition de données en fonctions de paramètres d'entrée
-- Mets à jour le prix d'une figurine de l'inventaire
CREATE OR REPLACE PROCEDURE P08_update_prix(id_figurine_inventaire INTEGER, new_prix INTEGER) AS
$$
BEGIN
UPDATE p08_inventaire SET figurine_prix = new_prix WHERE figurine_id = id_figurine_inventaire;
END;
$$ LANGUAGE plpgsql;

-- 2 Donner une fonction qui retourne une valeur simple
-- Donne le nom de la figurine quand on donne l'identifiant d'une figurine de l'inventaire
CREATE OR REPLACE FUNCTION P08_nom_figurire(id_figurine_inventaire INTEGER) RETURNS varchar AS
$$
DECLARE
    nom VARCHAR;
BEGIN
    SELECT figurine_nom FROM p08_inventaire NATURAL JOIN p08_figurinecaracteristique WHERE figurine_id = id_figurine_inventaire INTO nom;
    return nom;
END;
$$ LANGUAGE plpgsql;


-- 3 Donner une fonction qui retourne un ensemble de valeurs (fonction table)
-- Renvoie les figurines se trouvant dans une collection qu'on donne en paramètre
CREATE OR REPLACE FUNCTION P08_figurine_dans_collection(nom_collection VARCHAR) RETURNS TABLE( figurine_reference2   BIGINT,
                                                                                           figurine_nom2        VARCHAR(100),
                                                                                           figurine_personnage2  VARCHAR(100),
                                                                                           figurine_taille2      INT,
                                                                                           figurine_date_sortie2 DATE,
                                                                                           figurine_popid2       INT,
                                                                                figurine_chase2     BOOLEAN) AS $$
    BEGIN
        RETURN QUERY SELECT p08_figurinecaracteristique.figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid,figurine_chase
        FROM p08_figurinecaracteristique NATURAL JOIN p08_collection where collection_nom = nom_collection;
    end;
    $$ LANGUAGE plpgsql;



-- 4 Donner une fonction ou une procédure mettant en œuvre un curseur paramétrique
-- Renvoie aussi les figurines se trouvant dans une collection avec l'aide d'un curseur
CREATE OR REPLACE FUNCTION P08_get_figurines_by_collection(coll_id INT) RETURNS TABLE(figurine_ref BIGINT, nomFigurine VARCHAR, nomCollection VARCHAR) AS $$
DECLARE
    c1 CURSOR(coll_id INT) IS SELECT figurine_reference, figurine_nom, collection_nom FROM p08_FigurineCaracteristique
                  NATURAL JOIN p08_Collection WHERE collection_id = coll_id;
BEGIN
    OPEN c1(coll_id);
    LOOP
        FETCH c1 INTO figurine_ref, nomFigurine, nomCollection;
        EXIT WHEN NOT FOUND;
        RETURN NEXT;
    END LOOP;
    CLOSE c1;
END;
$$ LANGUAGE plpgsql;

-- 3 Donner un exemple de trigger déclenché avant ou après une opération d'édition pour chaque
-- ligne éditée. Ce trigger pourra par exemple renseigner une information calculable ou une
-- table regroupant des informations calculables

-- Table qui va servir à montrer l'exécution d'un trigger
CREATE TABLE P08_inventaire_log (
                                log_id SERIAL PRIMARY KEY,
                                log_type CHAR(6) CONSTRAINT constraint_log_type CHECK(
                                    log_type IN('INSERT', 'UPDATE', 'DELETE')
                                    ) NOT NULL,
                                log_time TIMESTAMP NOT NULL,
                                figurine_id INT,
                                figurine_reference BIGINT,
                                figurine_prix INT,
                                figurine_est_possedee BOOLEAN,
                                figurine_echangeable BOOLEAN,
                                figurine_date_acquisition DATE

);

-- Trigger sur l'édition de la table P08_Inventaire qui va remplir la table P08_inventaire_log en enregistrant les figurines éditées

CREATE OR REPLACE FUNCTION P08_trigger_func_log() RETURNS TRIGGER AS $$
BEGIN
    IF (TG_OP = 'DELETE') THEN
        INSERT INTO P08_inventaire_log(log_type, log_time, figurine_id, figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition)
        SELECT
            TG_OP,
            now(),
            OLD.figurine_id,
            OLD.figurine_reference,
            OLD.figurine_prix,
            OLD.figurine_est_possedee,
            OLD.figurine_echangeable,
            OLD.figurine_date_acquisition;
    ELSE
        INSERT INTO P08_inventaire_log (log_type, log_time, figurine_id, figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition)
        SELECT
            TG_OP,
            now(),
            new.figurine_id,
            new.figurine_reference,
            new.figurine_prix,
            new.figurine_est_possedee,
            new.figurine_echangeable,
            new.figurine_date_acquisition;
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER P08_trigger_log
    AFTER INSERT OR DELETE OR UPDATE
    ON P08_inventaire
    FOR EACH ROW
EXECUTE PROCEDURE P08_trigger_func_log();



-- Table qui va servir à montrer l'exécution d'un trigger
CREATE TABLE P08_inventaire_stats (
                                  stats_id SERIAL PRIMARY KEY,
                                  stats_time TIMESTAMP NOT NULL,
                                  nb_figurine INTEGER,
                                  valeur_inventaire INTEGER
);


-- Trigger qui va ajouter dans la table P08_inventaire_stats des statistiques sur l'inventaire du collectionneur a chaque édition de la table P08_inventaire
CREATE OR REPLACE FUNCTION P08_trigger_func_stats() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO P08_inventaire_stats(stats_time, nb_figurine, valeur_inventaire)
    SELECT now(), COUNT(figurine_id), SUM(figurine_prix)
    FROM P08_inventaire
    WHERE figurine_est_possedee;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER P08_trigger_stats
    AFTER INSERT OR DELETE OR UPDATE
    ON P08_inventaire
    FOR EACH STATEMENT
EXECUTE PROCEDURE P08_trigger_func_stats();

