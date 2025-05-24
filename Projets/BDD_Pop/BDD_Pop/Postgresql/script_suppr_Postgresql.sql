DROP TRIGGER IF EXISTS P08_trigger_log ON p08_inventaire;
DROP FUNCTION IF EXISTS P08_trigger_func_log;

DROP TRIGGER IF EXISTS p08_trigger_stats ON p08_inventaire;
DROP FUNCTION IF EXISTS p08_trigger_func_stats;

DROP VIEW IF EXISTS P08_InventairePossedeDetaille;
DROP VIEW IF EXISTS P08_ListeDeSouhaits;
DROP VIEW IF EXISTS P08_CompletionCollection;

DROP TABLE IF EXISTS P08_Inventaire;
DROP TABLE IF EXISTS P08_FigurineCaracteristique;
DROP TABLE IF EXISTS p08_collection;

DROP PROCEDURE IF EXISTS P08_update_prix;
DROP FUNCTION IF EXISTS P08_nom_figurire;
DROP FUNCTION IF EXISTS P08_figurine_dans_collection;
DROP FUNCTION IF EXISTS P08_get_figurines_by_collection;

DROP TABLE IF EXISTS P08_inventaire_log;
DROP TABLE IF EXISTS p08_inventaire_stats;