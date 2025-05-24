-- Vue donnant les figurines de l'inventaire qui sont possédées avec toutes les informations de la table P08_FigurineCaracteristique
CREATE OR REPLACE VIEW P08_InventairePossedeDetaille(figurine_id, figurine_reference, figurine_nom, figurine_personnage, collection_nom, collection_categorie, collection_licence, figurine_prix, figurine_echangeable, figurine_date_acquisition)
AS SELECT figurine_id, figurine_reference, figurine_nom, figurine_personnage, collection_nom, collection_categorie, collection_licence, figurine_prix, figurine_echangeable, figurine_date_acquisition
   FROM P08_Inventaire NATURAL JOIN P08_FigurineCaracteristique NATURAL JOIN P08_Collection
   WHERE figurine_est_possedee = true ORDER BY collection_nom, figurine_nom;

-- test
SELECT * FROM P08_InventairePossedeDetaille;



-- Vue donnant les figurines de l'inventaire qui ne sont pas possédées avec le nom de la figurine et du personnage :
-- sert donc de liste de souhaits
CREATE OR REPLACE VIEW P08_ListeDeSouhaits(figurine_id, figurine_reference, figurine_nom, figurine_personnage,  figurine_prix, figurine_echangeable, figurine_date_ajout)
AS SELECT figurine_id, figurine_reference, figurine_nom, figurine_personnage,  figurine_prix, figurine_echangeable, figurine_date_acquisition
   FROM P08_Inventaire NATURAL JOIN P08_FigurineCaracteristique WHERE figurine_est_possedee = false;

-- test
SELECT * FROM P08_ListeDeSouhaits;



-- Donne une vue qui montre le nombre des figurines possédées, le nombre de modèles possédés, le nombre de modèles existant et
-- le pourcentage de la collection dans l'inventaire
CREATE OR REPLACE VIEW P08_CompletionCollection(collection_id, collection_nom, nb_figurines_possedees, nb_modeles_possedes, nb_modeles_existant, pourcentage_collection_possede)
AS SELECT P08_Collection.collection_id,
          P08_Collection.collection_nom,
          COUNT(P08_Inventaire.figurine_id),
          COUNT(DISTINCT P08_Inventaire.figurine_reference),
          table_modeles_existant.nb_modeles_existant,
          100*COUNT(DISTINCT P08_Inventaire.figurine_reference)/table_modeles_existant.nb_modeles_existant
   FROM P08_Collection
       NATURAL JOIN P08_FigurineCaracteristique
       NATURAL JOIN P08_Inventaire
       JOIN ( SELECT collection_id, COUNT(figurine_reference) nb_modeles_existant
              FROM P08_Collection
                  NATURAL JOIN P08_FigurineCaracteristique
              GROUP BY P08_Collection.collection_id
            ) as table_modeles_existant ON table_modeles_existant.collection_id = P08_Collection.collection_id
   WHERE P08_Inventaire.figurine_est_possedee = true
   GROUP BY P08_Collection.collection_id;

-- test
SELECT * FROM P08_CompletionCollection;