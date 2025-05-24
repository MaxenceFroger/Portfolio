-- 1 Donner une procédure permettant l'édition de données en fonctions de paramètres d'entrée
-- Mets à jour le prix d'une figurine de l'inventaire
CREATE OR REPLACE PROCEDURE P08_update_prix(id_figurine_inventaire INTEGER, new_prix INTEGER) IS
BEGIN
    UPDATE p08_inventaire SET figurine_prix = new_prix WHERE figurine_id = id_figurine_inventaire;
END;

-- 2 Donner une fonction qui retourne une valeur simple
-- Donne le nom de la figurine quand on donne l'identifiant d'une figurine de l'inventaire
CREATE OR REPLACE FUNCTION P08_nom_figurire(id_figurine_inventaire INTEGER) RETURN varchar IS
    nom VARCHAR(255);
BEGIN
    SELECT figurine_nom
    INTO nom
    FROM p08_inventaire
             NATURAL JOIN p08_figurinecaracteristique
    WHERE figurine_id = id_figurine_inventaire;
    return nom;
END;
commit;


-- 3 Donner une fonction qui retourne un ensemble de valeurs (fonction table)
-- Renvoie les figurines se trouvant dans une collection qu'on donne en paramètre
CREATE OR REPLACE TYPE P08_fig AS object
(
    figurine_reference2   NUMBER,
    figurine_nom2         VARCHAR(100),
    figurine_personnage2  VARCHAR(100),
    figurine_taille2      INT,
    figurine_date_sortie2 DATE,
    figurine_popid2       INT,
    figurine_chase2       NUMBER(1)
);
CREATE OR REPLACE TYPE P08_tab_fig AS TABLE OF P08_fig;
CREATE OR REPLACE FUNCTION P08_figurine_dans_collection(nom_collection VARCHAR) RETURN P08_tab_fig PIPELINED IS
    figurine P08_fig ;
BEGIN
    for ligne in ( SELECT p08_figurinecaracteristique.figurine_reference,
                          figurine_nom,
                          figurine_personnage,
                          figurine_taille,
                          figurine_date_sortie,
                          figurine_popid,
                          figurine_chase
                   FROM p08_figurinecaracteristique
                            NATURAL JOIN p08_collection
                   where collection_nom = nom_collection
        )
        LOOP
            figurine := P08_fig(
                    ligne.FIGURINE_REFERENCE,
                    ligne.FIGURINE_NOM,
                    ligne.FIGURINE_PERSONNAGE,
                    ligne.FIGURINE_TAILLE,
                    ligne.FIGURINE_DATE_SORTIE,
                    ligne.FIGURINE_POPID,
                    ligne.FIGURINE_CHASE);
            PIPE ROW ( figurine );
        end loop;
    return;
end;
commit;



-- 4 Donner une fonction ou une procédure mettant en œuvre un curseur paramétrique
-- Renvoie aussi les figurines se trouvant dans une collection avec l'aide d'un curseur

CREATE OR REPLACE TYPE P08_fig_cursor AS object
(
    figurine_ref  NUMBER,
    nomFigurine   VARCHAR(255),
    nomCollection VARCHAR(255)
);
CREATE OR REPLACE TYPE P08_tab_fig_cursor AS TABLE OF P08_fig_cursor;

CREATE OR REPLACE FUNCTION P08_get_figurines_by_collection(coll_id INT) RETURN P08_tab_fig_cursor PIPELINED IS
    figur P08_fig_cursor := P08_fig_cursor(NULL, NULL, NULL);
    CURSOR c1(coll_id INT) IS SELECT figurine_reference, figurine_nom, collection_nom
                              FROM p08_FigurineCaracteristique
                                       NATURAL JOIN p08_Collection
                              WHERE collection_id = coll_id;
BEGIN
    OPEN c1(coll_id);
    LOOP
        FETCH c1 INTO figur.figurine_ref, figur.nomFigurine, figur.nomCollection;
        EXIT WHEN c1%NOTFOUND;
        PIPE ROW ( figur );
    END LOOP;
    CLOSE c1;
    return;
END;
COMMIT;

-- 3 Donner un exemple de trigger déclenché avant ou après une opération d'édition pour chaque
-- ligne éditée. Ce trigger pourra par exemple renseigner une information calculable ou une
-- table regroupant des informations calculables

-- Table et séquence qui vont servir à montrer l'exécution d'un trigger

CREATE SEQUENCE P08_seq_log
    START WITH 1
    INCREMENT BY 1;
COMMIT;

CREATE TABLE P08_inventaire_log
(
    log_id                    INTEGER DEFAULT P08_seq_log.nextval PRIMARY KEY,
    log_type                  VARCHAR(6)
        CONSTRAINT constraint_log_type CHECK (
            log_type IN ('INSERT', 'UPDATE', 'DELETE')
            )                           NOT NULL,
    log_time                  TIMESTAMP NOT NULL,
    figurine_id               INTEGER,
    figurine_reference        NUMBER(19, 0),
    figurine_prix             INT,
    figurine_est_possedee     NUMBER(1),
    figurine_echangeable      NUMBER(1),
    figurine_date_acquisition DATE
);
COMMIT;


-- Trigger sur l'édition de la table P08_Inventaire qui va remplir la table P08_inventaire_log en enregistrant les figurines éditées
CREATE OR REPLACE TRIGGER P08_trigger_log
    AFTER INSERT OR DELETE OR UPDATE
    ON P08_INVENTAIRE
    FOR EACH ROW
BEGIN
    CASE
        WHEN INSERTING
            THEN INSERT INTO P08_inventaire_log(log_type, log_time, figurine_id, figurine_reference, figurine_prix,
                                                figurine_est_possedee, figurine_echangeable, figurine_date_acquisition)
                 VALUES ('INSERT',
                         CURRENT_TIMESTAMP,
                         :NEW.figurine_id,
                         :NEW.figurine_reference,
                         :NEW.figurine_prix,
                         :NEW.figurine_est_possedee,
                         :NEW.figurine_echangeable,
                         :NEW.figurine_date_acquisition);
        WHEN UPDATING
            THEN INSERT INTO P08_inventaire_log(log_type, log_time, figurine_id, figurine_reference, figurine_prix,
                                            figurine_est_possedee, figurine_echangeable, figurine_date_acquisition)
                 VALUES ('UPDATE',
                         CURRENT_TIMESTAMP,
                         :NEW.figurine_id,
                         :NEW.figurine_reference,
                         :NEW.figurine_prix,
                         :NEW.figurine_est_possedee,
                         :NEW.figurine_echangeable,
                         :NEW.figurine_date_acquisition);
        WHEN DELETING
            THEN INSERT INTO P08_inventaire_log(log_type, log_time, figurine_id, figurine_reference, figurine_prix,
                                            figurine_est_possedee, figurine_echangeable, figurine_date_acquisition)
                 VALUES ('DELETE',
                         CURRENT_TIMESTAMP,
                         :OLD.figurine_id,
                         :OLD.figurine_reference,
                         :OLD.figurine_prix,
                         :OLD.figurine_est_possedee,
                         :OLD.figurine_echangeable,
                         :OLD.figurine_date_acquisition);
        END CASE;
END;
COMMIT;


-- Table et séquence qui vont servir à montrer l'exécution d'un trigger
CREATE SEQUENCE P08_seq_stat
    START WITH 1
    INCREMENT BY 1;
COMMIT;

CREATE TABLE P08_inventaire_stats (
                                      stats_id  INTEGER DEFAULT P08_seq_stat.nextval PRIMARY KEY,
                                      stats_time TIMESTAMP NOT NULL,
                                      nb_figurine INTEGER,
                                      valeur_inventaire INTEGER
);
COMMIT;

-- Trigger qui va ajouter dans la table P08_inventaire_stats des statistiques sur l'inventaire du collectionneur a chaque édition de la table P08_inventaire
CREATE OR REPLACE TRIGGER P08_trigger_stats
    AFTER INSERT OR DELETE OR UPDATE
    ON P08_inventaire
    BEGIN
        INSERT INTO P08_inventaire_stats(stats_time, nb_figurine, valeur_inventaire)
        SELECT CURRENT_TIMESTAMP, COUNT(figurine_id), SUM(figurine_prix)
        FROM P08_inventaire
        WHERE figurine_est_possedee = 1;
END;
COMMIT;