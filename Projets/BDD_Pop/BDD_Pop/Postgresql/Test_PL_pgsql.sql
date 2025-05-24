--Test update_prix
SELECT * FROM p08_inventaire WHERE figurine_id = 1;
CALL P08_update_prix(1, 170);
SELECT * FROM p08_inventaire WHERE figurine_id = 1;

--Test nom_figurire
SELECT P08_nom_figurire(1);
SELECT figurine_nom FROM p08_inventaire NATURAL JOIN p08_figurinecaracteristique WHERE figurine_id = 1;

--Test figurine_dans_collection
SELECT * FROM P08_figurine_dans_collection('Pokémon');
SELECT * FROM P08_figurine_dans_collection('lol');

--Test get_figurines_by_collection
SELECT * FROM P08_get_figurines_by_collection(35);

--Test P08_trigger_log
insert into p08_inventaire(figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES
    (889698411509, 333, true, false, '2024-12-10');

update p08_inventaire set figurine_prix = 222 where figurine_id = (SELECT p08_inventaire_figurine_id_seq.last_value FROM p08_inventaire_figurine_id_seq);

DELETE FROM p08_inventaire where figurine_id = (SELECT p08_inventaire_figurine_id_seq.last_value FROM p08_inventaire_figurine_id_seq);

SELECT * FROM p08_inventaire_log;


-- Test P08_trigger_stats
--Avant modification
SELECT * FROM p08_inventaire_stats;

insert into p08_inventaire(figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES
    (889698411509, 333, true, false, '2024-12-10');

update p08_inventaire set figurine_prix = 222 where figurine_id = (SELECT p08_inventaire_figurine_id_seq.last_value FROM p08_inventaire_figurine_id_seq);

DELETE FROM p08_inventaire where figurine_id = (SELECT p08_inventaire_figurine_id_seq.last_value FROM p08_inventaire_figurine_id_seq);

--Après modification
SELECT * FROM p08_inventaire_stats;