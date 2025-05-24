--Test update_prix
SELECT * FROM p08_inventaire WHERE figurine_id = 1;
CALL P08_update_prix(1, 170);
COMMIT;
SELECT * FROM p08_inventaire WHERE figurine_id = 1;

--Test nom_figurire
SELECT P08_nom_figurire(2) FROM DUAL;
SELECT figurine_nom FROM p08_inventaire NATURAL JOIN p08_figurinecaracteristique WHERE figurine_id = 1;

--Test figurine_dans_collection
SELECT * FROM P08_figurine_dans_collection('Pokémon');
SELECT * FROM P08_figurine_dans_collection('lol');

--Test get_figurines_by_collection
SELECT * FROM P08_get_figurines_by_collection(35);

--Test P08_trigger_log
insert into p08_inventaire(figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES
    (889698411509, 123456789, 1, 0, TO_DATE('2024-12-10', 'YYYY-MM-DD'));
commit;
update p08_inventaire set figurine_prix = 987654321 where FIGURINE_REFERENCE = 889698411509 and FIGURINE_PRIX = 123456789;
commit;
DELETE FROM p08_inventaire where FIGURINE_REFERENCE = 889698411509 and FIGURINE_PRIX = 987654321;
commit;

-- Test P08_trigger_stats
--Avant modification
SELECT * FROM p08_inventaire_stats;

insert into p08_inventaire(figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES
    (889698411509, 123456789, 1, 0, TO_DATE('2024-12-10', 'YYYY-MM-DD'));
commit;
update p08_inventaire set figurine_prix = 987654321 where FIGURINE_REFERENCE = 889698411509 and FIGURINE_PRIX = 123456789;
commit;
DELETE FROM p08_inventaire where FIGURINE_REFERENCE = 889698411509 and FIGURINE_PRIX = 987654321;
commit;
--Après modification
SELECT * FROM p08_inventaire_stats;
