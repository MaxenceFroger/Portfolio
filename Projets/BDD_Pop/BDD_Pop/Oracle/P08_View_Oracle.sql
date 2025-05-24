-- Vue donnant les figurines de l'inventaire qui sont possédées avec toutes les informations de la table P08_FigurineCaracteristique
CREATE OR REPLACE VIEW P08_InventairePossedeDetaille
            (figurine_id, figurine_reference, figurine_nom, figurine_personnage, collection_nom, collection_categorie,
             collection_licence, figurine_prix, figurine_echangeable, figurine_date_acquisition)
AS
SELECT figurine_id,
       figurine_reference,
       figurine_nom,
       figurine_personnage,
       collection_nom,
       collection_categorie,
       collection_licence,
       figurine_prix,
       figurine_echangeable,
       figurine_date_acquisition
FROM P08_Inventaire
         NATURAL JOIN P08_FigurineCaracteristique
         NATURAL JOIN P08_Collection
WHERE figurine_est_possedee = 1
ORDER BY collection_nom, figurine_nom;

--test
SELECT *
FROM P08_InventairePossedeDetaille;



-- Vue donnant les figurines de l'inventaire qui ne sont pas possédées avec le nom de la figurine et du personnage :
-- sert donc de liste de souhaits
CREATE OR REPLACE VIEW P08_ListeDeSouhaits
            (figurine_id, figurine_reference, figurine_nom, figurine_personnage, figurine_prix, figurine_echangeable,
             figurine_date_ajout)
AS
SELECT figurine_id,
       figurine_reference,
       figurine_nom,
       figurine_personnage,
       figurine_prix,
       figurine_echangeable,
       figurine_date_acquisition
FROM P08_Inventaire
         NATURAL JOIN P08_FigurineCaracteristique
WHERE figurine_est_possedee = 0;

--test
SELECT *
FROM P08_ListeDeSouhaits;



-- Donne une vue qui montre le nombre des figurines possédées, le nombre de modèles possédés, le nombre de modèles existant et
-- le pourcentage de la collection dans l'inventaire
CREATE OR REPLACE VIEW P08_CompletionCollection
            (collection_id, collection_nom, nb_figurines_possedees, nb_modeles_possedes, nb_modeles_existant,
             pourcentage_collection_possede)
AS
SELECT P08_Collection.collection_id,
       P08_Collection.collection_nom,
       COUNT(P08_Inventaire.figurine_id),
       COUNT(DISTINCT P08_FigurineCaracteristique.figurine_reference),
       table_modeles_existant.nb_modeles_existant,
       100 * COUNT(DISTINCT P08_Inventaire.figurine_reference) / table_modeles_existant.nb_modeles_existant
FROM P08_Collection
         INNER JOIN (SELECT collection_id, COUNT(DISTINCT figurine_reference) nb_modeles_existant
                     FROM P08_Collection
                              NATURAL JOIN P08_FigurineCaracteristique
                     GROUP BY collection_id) table_modeles_existant
                    ON table_modeles_existant.collection_id = P08_Collection.collection_id
         INNER JOIN P08_FigurineCaracteristique
                    ON P08_FigurineCaracteristique.collection_id = P08_Collection.collection_id
         INNER JOIN P08_Inventaire
                    ON P08_Inventaire.FIGURINE_REFERENCE = P08_FigurineCaracteristique.FIGURINE_REFERENCE
WHERE P08_Inventaire.figurine_est_possedee = 1
GROUP BY P08_Collection.collection_id, P08_Collection.collection_nom, table_modeles_existant.nb_modeles_existant;


--Test
SELECT *
FROM P08_CompletionCollection;

