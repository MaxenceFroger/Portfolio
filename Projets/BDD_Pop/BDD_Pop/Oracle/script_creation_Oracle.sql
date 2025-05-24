--Creations des tables
CREATE SEQUENCE P08_seq_collection
    START WITH     1
    INCREMENT BY   1;
CREATE TABLE P08_Collection
(
    collection_id  INTEGER DEFAULT P08_seq_collection.nextval PRIMARY KEY,
    collection_nom VARCHAR(100) NOT NULL,
    collection_licence    VARCHAR(100) NOT NULL,
    collection_categorie  VARCHAR(100) NOT NULL
);

CREATE TABLE P08_FigurineCaracteristique
(
    figurine_reference   NUMBER(19, 0) PRIMARY KEY,
    figurine_nom         VARCHAR(100) NOT NULL,
    figurine_personnage  VARCHAR(100) NOT NULL,
    figurine_taille      INT         NOT NULL,
    figurine_date_sortie DATE        NOT NULL,
    figurine_popid       INT         NOT NULL,
    figurine_chase       NUMBER(1)    NOT NULL,
    collection_id  INT NOT NULL,
    FOREIGN KEY (collection_id) REFERENCES P08_Collection (collection_id)
);

CREATE SEQUENCE P08_seq_inventaire
    START WITH     1
    INCREMENT BY   1;
CREATE TABLE P08_Inventaire
(
    figurine_id               INTEGER DEFAULT P08_seq_inventaire.nextval PRIMARY KEY,
    figurine_reference        NUMBER(19, 0)  NOT NULL,
    FOREIGN KEY (figurine_reference) REFERENCES P08_FigurineCaracteristique (figurine_reference),
    figurine_prix             FLOAT,
    figurine_est_possedee     NUMBER(1)  NOT NULL,
    figurine_echangeable      NUMBER(1)  NOT NULL,

    CHECK ((figurine_est_possedee = 0 AND figurine_echangeable = 0) OR figurine_est_possedee = 1),

    figurine_date_acquisition DATE,
    CHECK ((figurine_est_possedee = 1 AND figurine_date_acquisition is not null) OR figurine_est_possedee = 0)
);
COMMIT;

/*
 Insertion des Collections
 */
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('ZZ Top', 'POP! Rocks', 'Tower Top Tours , INC');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Zorro', 'POP! Television', 'Zorro Productions, Inc');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Zootopie', 'POP! Disney', 'Disney');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Zoolander', 'POP! Movies', 'Paramount Licensing Inc');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Zoo Australien', 'POP! Television', 'Ikon Collectable Pty');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Zack Snyder''s Justice League', 'POP! Heroes', 'Warner Bros. Consumer Products');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Yuri on Ice', 'POP! Animation', 'Ellation Inc');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Yu-Gi-Oh!', 'POP! Animation', '4K Media Inc.');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('X-Files', 'POP! Television', '20th Century Fox');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Witcher', 'POP! Games', 'CD PROJEKT S.A.');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Willow', 'POP! Movies', 'Disney');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('2001 : l''Odyssée de l''espace', 'POP! Movies', 'Funko');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Alita: Battle Angel', 'POP! Movies', '20th Century Fox');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Ben 10', 'POP! Animation', 'Cartoon Network Enterprises');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Carmen Sandiego', 'POP! Television', 'HMH IP Company');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Danny Fantôme', 'POP! Animation', 'Viacom Media Networks');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('EVH', 'POP! Rocks', ' 	EVH Inc.');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Free Guy', 'POP! Movies', 'Disney');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Gigantor', 'POP! Animation', 'Entercolor Technologies Corporation');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Harley Quinn 30 ans', 'POP! Heroes', 'Warner Bros. Consumer Products');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Insidious', 'POP! Movies', 'Funko');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Jungle Cruise', 'POP! Disney', 'Disney');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Korn', 'POP! Rocks', 'Global Merchandising Services Ltd');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('La Stratégie Ender', 'POP! Movies', 'Lions Gate Films');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('M. Peabody et Sherman : Les Voyages dans le temps', 'POP! Animation', 'Bullwinkle Studios');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('New York 1997', 'POP! Movies', 'Universal Studios Licensing');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Ozuna', 'POP! Rocks', 'Univision');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Popeye', 'POP! Animation', 'Funko Legacy');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Q*Bert', 'POP! Games', 'Sony Pictures Consumer Products');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Robocop', 'POP! Movies', 'MGM Consumer Products');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Scream', 'POP! Movies', 'Easter Unlimited');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('The Last Ronin', 'POP! Comics', 'Viacom Media Networks');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Un jour sans fin', 'POP! Movies', 'Funko Legacy');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Venom : Let There Be Carnage', 'POP! Marvel', 'Marvel Characters B.V.');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Genshin Impact', 'POP! Asia', 'Funko Legacy');
INSERT INTO P08_Collection (collection_nom, collection_licence, collection_categorie) VALUES ('Pokémon', 'POP! Games', 'The Pokemon Company');

/*
 Insertions des figurines
 */

INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698411509, 'Billy Gibbons (Flocked)', 'Billy Gibbons', 10, TO_DATE('2020-03-17', 'YYYY-MM-DD'), 164, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'ZZ Top'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698411868, 'Dusty Hill (Flocked)', 'Dusty Hill', 10, TO_DATE('2020-03-17', 'YYYY-MM-DD'), 165, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'ZZ Top'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698411851, 'Frank Beard', 'Frank Beard', 10, TO_DATE('2020-03-17', 'YYYY-MM-DD'), 166, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'ZZ Top'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698593182, 'Zorro', 'Zorro', 10, TO_DATE('2022-05-05', 'YYYY-MM-DD'), 1270, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zorro'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803071493, 'Nick Wilde', 'Nick Wilde', 10, TO_DATE('2015-12-26', 'YYYY-MM-DD'), 186, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zootopie'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803071523, 'Ele-Finnick', 'Ele-Finnick', 10, TO_DATE('2015-12-26', 'YYYY-MM-DD'), 187, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zootopie'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803071530, 'Mr. Big', 'Mr. Big', 10, TO_DATE('2015-12-26', 'YYYY-MM-DD'), 188, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zootopie'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803071554, 'Judy Hopps', 'Judy Hopps', 10, TO_DATE('2015-12-30', 'YYYY-MM-DD'), 189, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zootopie'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803075255, 'Flash', 'Flash', 10, TO_DATE('2015-12-30', 'YYYY-MM-DD'), 190, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zootopie'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698364775, 'Derek Zoolander', 'Derek Zoolander', 10, TO_DATE('2019-02-16', 'YYYY-MM-DD'), 700, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zoolander'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698364300, 'Hansel', 'Hansel', 10, TO_DATE('2019-02-16', 'YYYY-MM-DD'), 701, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zoolander'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698364294, 'Mugatu', 'Mugatu', 10, TO_DATE('2019-02-16', 'YYYY-MM-DD'), 702, 1, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zoolander'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698364249, 'Derek Zoolander', 'Derek Zoolander', 10, TO_DATE('2019-07-17', 'YYYY-MM-DD'), 703, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zoolander'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698439770, 'Steve Irwin avec Crocodile', 'Steve Irwin', 10, TO_DATE('2019-07-24', 'YYYY-MM-DD'), 921, 1, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zoo Australien'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698443357, 'Steve Irwin avec Serpent', 'Steve Irwin', 10, TO_DATE('2020-02-21', 'YYYY-MM-DD'), 950, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zoo Australien'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698546966, 'Steve Irwin avec Sui', 'Steve Irwin', 10, TO_DATE('2021-02-22', 'YYYY-MM-DD'), 1105, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zoo Australien'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698568012, 'Superman', 'Superman (Kal-El / Clark Kent)', 10, TO_DATE('2021-04-02', 'YYYY-MM-DD'), 1123, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zack Snyder''s Justice League'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698568005, 'Diana Prince', 'Wonder Woman (Diana Prince)', 10, TO_DATE('2021-04-02', 'YYYY-MM-DD'), 1124, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zack Snyder''s Justice League'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698567992, 'Desaad', 'Desaad', 10, TO_DATE('2021-04-02', 'YYYY-MM-DD'), 1125, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zack Snyder''s Justice League'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698573597, 'Darkseid', 'Darkseid', 10, TO_DATE('2021-04-02', 'YYYY-MM-DD'), 1126, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zack Snyder''s Justice League'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698581660, 'Darkseid (Noir & Blanc)', 'Darkseid', 10, TO_DATE('2021-04-12', 'YYYY-MM-DD'), 1126, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zack Snyder''s Justice League'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698572781, 'Darkseid (Metallic)', 'Darkseid', 10, TO_DATE('2021-04-12', 'YYYY-MM-DD'), 1126, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zack Snyder''s Justice League'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698568357, 'Superman', 'Superman (Kal-El / Clark Kent)', 10, TO_DATE('2021-04-02', 'YYYY-MM-DD'), 1127, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zack Snyder''s Justice League'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698567985, 'Darkseid on Throne', 'Darkseid', 10, TO_DATE('2021-04-02', 'YYYY-MM-DD'), 1128, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Zack Snyder''s Justice League'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698218795, 'Yuri Katsuki avec Patins', 'Yuri Katsuki', 10, TO_DATE('2017-09-03', 'YYYY-MM-DD'), 288, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yuri on Ice'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698218825, 'Victor Nikiforov avec Patins', 'Victor Nikiforov', 10, TO_DATE('2017-09-03', 'YYYY-MM-DD'), 289, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yuri on Ice'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698218849, 'Yurio Plisetsky avec Patins', 'Yurio Plisetsky', 10, TO_DATE('2017-09-03', 'YYYY-MM-DD'), 290, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yuri on Ice'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698226714, 'Victor Jeune', 'Victor Nikiforov', 10, TO_DATE('2017-09-09', 'YYYY-MM-DD'), 291, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yuri on Ice'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698274487, 'Yami Yugi avec carte', 'Yami Yugi', 10, TO_DATE('2018-06-01', 'YYYY-MM-DD'), 387, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698274500, 'Seto Kaiba', 'Seto Kaiba', 10, TO_DATE('2018-06-01', 'YYYY-MM-DD'), 388, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698274517, 'Dragon Blanc aux Yeux Bleus', 'Dragon Blanc aux Yeux Bleus', 10, TO_DATE('2018-06-26', 'YYYY-MM-DD'), 389, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698411882, 'Dragon Blanc aux Yeux Bleus (Metallic)', 'Dragon Blanc aux Yeux Bleus', 10, TO_DATE('2019-08-10', 'YYYY-MM-DD'), 389, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698274524, 'Magicienne des Ténèbres', 'Magicienne des Ténèbres', 10, TO_DATE('2018-06-26', 'YYYY-MM-DD'), 390, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698403849, 'Magicien des Ténèbres', 'Magicien des Ténèbres', 10, TO_DATE('2019-06-26', 'YYYY-MM-DD'), 595, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698469227, 'Yugi Muto', 'Yugi Muto', 10, TO_DATE('2020-02-21', 'YYYY-MM-DD'), 715, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698469241, 'Maximillion Pegasus', 'Maximillion Pegasus', 10, TO_DATE('2020-02-21', 'YYYY-MM-DD'), 716, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698469234, 'Joey Wheeler', 'Joey Wheeler', 10, TO_DATE('2020-02-21', 'YYYY-MM-DD'), 717, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698469258, 'Dragon Noir aux Yeux Rouges', 'Dragon Noir aux Yeux Rouges', 10, TO_DATE('2020-02-21', 'YYYY-MM-DD'), 718, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698476683, 'Exodia (Supersized)', 'Exodia', 15, TO_DATE('2020-02-21', 'YYYY-MM-DD'), 755, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698475853, 'Slifer (Supersized)', 'Slifer', 15, TO_DATE('2020-02-21', 'YYYY-MM-DD'), 756, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698475693, 'Obélisque (Supersized)', 'Obélisque', 15, TO_DATE('2020-02-21', 'YYYY-MM-DD'), 757, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698520836, 'Yami Marik', 'Yami Marik', 10, TO_DATE('2020-09-25', 'YYYY-MM-DD'), 886, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698576451, 'Pharaoh Atem (Metallic)', 'Yugi Muto', 10, TO_DATE('2021-10-25', 'YYYY-MM-DD'), 1059, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698576468, 'Mai Valentine', 'Mai Valentine', 10, TO_DATE('2021-10-25', 'YYYY-MM-DD'), 1060, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698576475, 'Yami Bakura', 'Yami Bakura', 10, TO_DATE('2021-10-25', 'YYYY-MM-DD'), 1061, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698576482, 'Dragon Toon aux Yeux Bleus (Metallic)', 'Dragon Toon aux Yeux Bleus', 10, TO_DATE('2021-10-25', 'YYYY-MM-DD'), 1062, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698581417, 'Spadassin Silencieux LVO', 'Spadassin Silencieux', 10, TO_DATE('2021-10-25', 'YYYY-MM-DD'), 1063, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698585590, 'Dragon de Poussière d''Etoile (Metallic & Supersized)', 'Dragon de Poussière d''Etoile', 15, TO_DATE('2021-10-25', 'YYYY-MM-DD'), 1064, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698582223, 'Dragon Ultime aux Yeux Bleus (Metallic & Supersized)', 'Dragon Ultime aux Yeux Bleus', 15, TO_DATE('2021-10-25', 'YYYY-MM-DD'), 1078, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698608534, 'Soldat du Lustre Noir', 'Soldat du Lustre Noir', 10, TO_DATE('2022-02-25', 'YYYY-MM-DD'), 1096, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698603379, 'Dragon Ailé de Ra (Metallic & Supersized)', 'Dragon Ailé de Ra', 10, TO_DATE('2021-10-25', 'YYYY-MM-DD'), 1098, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698653763, 'Crâne Invoqué', 'Summoned Skull', 10, TO_DATE('2022-11-22', 'YYYY-MM-DD'), 1175, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698670562, 'Dragon à Cinq Têtes', 'Dragon à Cinq Têtes', 10, TO_DATE('2022-09-06', 'YYYY-MM-DD'), 1230, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698736299, 'Dragon de Harpie (Supersized)', 'Dragon de Harpie', 25, TO_DATE('2024-01-16', 'YYYY-MM-DD'), 1415, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698720663, 'Yami Yugi', 'Yami Yugi', 10, TO_DATE('2023-09-26', 'YYYY-MM-DD'), 1451, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698720625, 'Joey Wheeler', 'Joey Wheeler', 10, TO_DATE('2023-09-26', 'YYYY-MM-DD'), 1452, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698720649, 'Seto Kaiba', 'Seto Kaiba', 10, TO_DATE('2023-09-26', 'YYYY-MM-DD'), 1453, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698720656, 'Time Wizard', 'Time Wizard', 10, TO_DATE('2023-09-26', 'YYYY-MM-DD'), 1454, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698743891, 'Kuriboh (Flocked & Glow in the Dark)', 'Kuriboh', 10, TO_DATE('2023-09-14', 'YYYY-MM-DD'), 1455, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698720632, 'Kuriboh', 'Kuriboh', 10, TO_DATE('2023-09-26', 'YYYY-MM-DD'), 1455, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698720670, 'XYZ-Dragon Cannon (Supersized)', 'XYZ-Dragon Cannon', 15, TO_DATE('2023-09-26', 'YYYY-MM-DD'), 1456, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698746052, 'Cyber end Dragon (Supersized)', 'Cyber end Dragon', 15, TO_DATE('2023-11-10', 'YYYY-MM-DD'), 1457, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698746083, 'Jinzo avec Time Wizard', 'Jinzo', 10, TO_DATE('2023-11-10', 'YYYY-MM-DD'), 1458, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698702720, 'Magicienne des Ténèbres', 'Magicienne des Ténèbres', 10, TO_DATE('2023-10-12', 'YYYY-MM-DD'), 1461, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698747134, 'Dragon Toon aux Yeux Bleus (Glow in the Dark & Supersized)', 'Dragon Toon aux Yeux Bleus', 15, TO_DATE('2023-12-17', 'YYYY-MM-DD'), 1478, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698756037, 'Avian Héros Élémentaire', 'Avian', 10, TO_DATE('2024-05-02', 'YYYY-MM-DD'), 1597, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698756044, 'Burstinatrix Héros Elémentaire', 'Burstinatrix', 10, TO_DATE('2024-05-02', 'YYYY-MM-DD'), 1598, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698756075, 'Dame Harpie', 'Dame Harpie', 10, TO_DATE('2024-05-02', 'YYYY-MM-DD'), 1599, 1, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698765299, 'Ojama Jaune', 'Ojama Jaune', 10, TO_DATE('2024-05-02', 'YYYY-MM-DD'), 1600, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698765305, 'Kuriboh Ailé', 'Kuriboh Ailé', 10, TO_DATE('2024-05-02', 'YYYY-MM-DD'), 1601, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698756020, 'Chad Princeton', 'Chad Princeton', 10, TO_DATE('2024-05-02', 'YYYY-MM-DD'), 1602, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698765282, 'Jaden Yuki', 'Jaden Yuki', 10, TO_DATE('2024-05-02', 'YYYY-MM-DD'), 1603, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Yu-Gi-Oh!'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803042523, 'Fox Mulder', 'Fox Mulder', 10, TO_DATE('2015-03-28', 'YYYY-MM-DD'), 183, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'X-Files'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803042516, 'Dana Scully', 'Dana Scully', 10, TO_DATE('2015-03-28', 'YYYY-MM-DD'), 184, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'X-Files'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803042530, 'L''homme qui fume', 'L''homme qui fume (C.G.B. Spender)', 10, TO_DATE('2015-03-28', 'YYYY-MM-DD'), 185, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'X-Files'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803042547, 'Alien', 'Alien', 10, TO_DATE('2015-03-28', 'YYYY-MM-DD'), 186, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'X-Files'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698121347, 'Geralt', 'Geralt', 10, TO_DATE('2016-11-24', 'YYYY-MM-DD'), 149, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698121330, 'Ciri', 'Ciri', 10, TO_DATE('2016-11-24', 'YYYY-MM-DD'), 150, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698410076, 'Ciri', 'Ciri', 10, TO_DATE('2019-05-02', 'YYYY-MM-DD'), 150, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698121316, 'Eredin', 'Eredin', 10, TO_DATE('2016-11-24', 'YYYY-MM-DD'), 151, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698121323, 'Yennefer', 'Yennefer', 10, TO_DATE('2016-11-24', 'YYYY-MM-DD'), 152, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698121354, 'Triss', 'Triss', 10, TO_DATE('2016-11-24', 'YYYY-MM-DD'), 153, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698450393, 'Geralt (IGNI)', 'Geralt', 10, TO_DATE('2019-12-23', 'YYYY-MM-DD'), 554, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698463737, 'Geralt vs. Leshen', 'Geralt', 10, TO_DATE('2019-11-08', 'YYYY-MM-DD'), 555, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698470957, 'Leshen (Supersized)', 'Leshen', 15, TO_DATE('2020-06-22', 'YYYY-MM-DD'), 561, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Witcher'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698657655, 'Général Kael', 'Général Kael', 10, TO_DATE('2023-02-01', 'YYYY-MM-DD'), 1312, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Willow'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698657662, 'Madmartigan', 'Madmartigan', 10, TO_DATE('2023-02-01', 'YYYY-MM-DD'), 1313, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Willow'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698657679, 'Sorsha', 'Sorsha', 10, TO_DATE('2023-02-01', 'YYYY-MM-DD'), 1314, 1, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Willow'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698657686, 'Willow Ufgood', 'Willow Ufgood', 10, TO_DATE('2023-02-01', 'YYYY-MM-DD'), 1315, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Willow'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698433761, 'Dr. Frank Poole', 'Dr. Frank Poole', 10, TO_DATE('2019-10-03', 'YYYY-MM-DD'), 823, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = '2001 : l''Odyssée de l''espace'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698303217, 'Alita Corps de Poupée', 'Alita', 10, TO_DATE('2018-11-03', 'YYYY-MM-DD'), 562, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Alita: Battle Angel'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698303279, 'Alita Corps Berserker', 'Alita', 10, TO_DATE('2018-11-03', 'YYYY-MM-DD'), 563, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Alita: Battle Angel'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698307482, 'Alita Corps Berserker (Noir & Blanc)', 'Alita', 10, TO_DATE('2018-11-03', 'YYYY-MM-DD'), 563, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Alita: Battle Angel'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698303361, 'Alita Corps Motorball', 'Alita', 10, TO_DATE('2018-11-03', 'YYYY-MM-DD'), 564, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Alita: Battle Angel'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698670432, 'Swampfire', 'Swampfire', 10, TO_DATE('2022-09-06', 'YYYY-MM-DD'), 1202, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Ben 10'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698320399, 'Carmen Sandiego', 'Carmen Sandiego', 10, TO_DATE('2018-06-01', 'YYYY-MM-DD'), 662, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Carmen Sandiego'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698324526, 'Carmen Sandiego (Translucent)', 'Carmen Sandiego', 10, TO_DATE('2018-06-04', 'YYYY-MM-DD'), 662, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Carmen Sandiego'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698371261, 'Carmen Sandiego (Diamond Glitter)', 'Carmen Sandiego', 10, TO_DATE('2019-03-09', 'YYYY-MM-DD'), 662, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Carmen Sandiego'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698485203, 'Danny Fantôme', 'Danny Fantôme', 10, TO_DATE('2020-09-15', 'YYYY-MM-DD'), 854, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Danny Fantôme'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698593885, 'Eddie Van Halen', 'Eddie Van Halen', 10, TO_DATE('2021-12-09', 'YYYY-MM-DD'), 258, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'EVH'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698742924, 'Eddie Van Halen', 'Eddie Van Halen', 10, TO_DATE('2023-08-25', 'YYYY-MM-DD'), 350, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'EVH'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698645355, 'Guy', 'Guy', 10, TO_DATE('2022-09-06', 'YYYY-MM-DD'), 1241, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Free Guy'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803052522, 'Gigantor', 'Gigantor', 10, TO_DATE('2015-07-02', 'YYYY-MM-DD'), 41, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Gigantor'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698663182, 'Harley Quinn avec Cartes', 'Harley Quinn (Harleen Quinzel)', 10, TO_DATE('2022-09-17', 'YYYY-MM-DD'), 454, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Harley Quinn 30 ans'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698742641, 'Key Face', 'Key Face', 10, TO_DATE('2023-10-12', 'YYYY-MM-DD'), 1459, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Insidious'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698504737, 'Frank', 'Frank Wolff', 10, TO_DATE('2021-06-18', 'YYYY-MM-DD'), 971, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Jungle Cruise'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698576123, 'Jonathan Davis', 'Jonathan Davis', 10, TO_DATE('2021-07-01', 'YYYY-MM-DD'), 242, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Korn'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803037079, 'Ender', 'Ender', 10, TO_DATE('2013-08-23', 'YYYY-MM-DD'), 59, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'La Stratégie Ender'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803037086, 'Petra', 'Petra', 10, TO_DATE('2014-06-01', 'YYYY-MM-DD'), 60, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'La Stratégie Ender'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803037833, 'Sherman', 'Sherman', 10, TO_DATE('2014-06-01', 'YYYY-MM-DD'), 7, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'M. Peabody et Sherman : Les Voyages dans le temps'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(849803037826, 'Mr. Peabody', 'Mr. Peabody', 10, TO_DATE('2014-08-25', 'YYYY-MM-DD'), 8, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'M. Peabody et Sherman : Les Voyages dans le temps'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698506687, 'Snake Plissken', 'Snake Plissken', 10, TO_DATE('2020-09-16', 'YYYY-MM-DD'), 1008, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'New York 1997'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698538619, 'Ozuna', 'Ozuna', 10, TO_DATE('2020-12-03', 'YYYY-MM-DD'), 203, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Ozuna'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698301800, 'Popeye', 'Popeye', 10, TO_DATE('2018-05-01', 'YYYY-MM-DD'), 369, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Popeye'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698108515, 'Q*Bert', 'Q*Bert', 10, TO_DATE('2016-10-08', 'YYYY-MM-DD'), 169, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Q*Bert'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(830395030487, 'Robocop', 'Robocop', 10, TO_DATE('2013-08-15', 'YYYY-MM-DD'), 22, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Robocop'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(830395033600, 'Ghostface', 'Ghostface', 10, TO_DATE('2014-01-01', 'YYYY-MM-DD'), 51, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Scream'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698736961, 'Le Dernier Ronin', 'The Last Ronin (Michelangelo)', 10, TO_DATE('2023-09-30', 'YYYY-MM-DD'), 240, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'The Last Ronin'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698472401, 'Phil Connors avec Punxsutawney Phil', 'Phil Connors', 10, TO_DATE('2020-10-27', 'YYYY-MM-DD'), 1045, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Un jour sans fin'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698472395, 'Punxsutawney Phil (Flocked)', 'Punxsutawney Phil', 10, TO_DATE('2021-02-09', 'YYYY-MM-DD'), 1046, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Un jour sans fin'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698585989, 'Carnage', 'Carnage', 10, TO_DATE('2021-10-05', 'YYYY-MM-DD'), 926, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Venom : Let There Be Carnage'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698808972, 'Keqing', 'Keqing', 10, TO_DATE('2023-07-25', 'YYYY-MM-DD'), 182, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Genshin Impact'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698808958, 'Diluc', 'Diluc', 10, TO_DATE('2023-07-25', 'YYYY-MM-DD'), 183, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Genshin Impact'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698808965, 'Hilichurl', 'Hilichurl', 10, TO_DATE('2023-07-25', 'YYYY-MM-DD'), 184, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Genshin Impact'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698683814, 'Lumine', 'Lumine', 10, TO_DATE('2022-03-03', 'YYYY-MM-DD'), 161, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Genshin Impact'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698683821, 'Paimon', 'Paimon', 10, TO_DATE('2022-03-03', 'YYYY-MM-DD'), 162, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Genshin Impact'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698683807, 'Aether', 'Aether', 10, TO_DATE('2022-03-03', 'YYYY-MM-DD'), 160, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Genshin Impact'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698315289, 'Pikachu', 'Pikachu', 10, TO_DATE('2018-05-21', 'YYYY-MM-DD'), 356, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Pokémon'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698376037, 'Salamèche', 'Salamèche', 10, TO_DATE('2019-03-12', 'YYYY-MM-DD'), 455, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Pokémon'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698394420, 'Carapuce', 'Carapuce', 10, TO_DATE('2019-07-15', 'YYYY-MM-DD'), 504, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Pokémon'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698362375, 'Bulbizarre', 'Bulbizarre', 10, TO_DATE('2019-02-01', 'YYYY-MM-DD'), 453, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Pokémon'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698468640, 'Mewtwo', 'Mewtwo', 10, TO_DATE('2020-02-06', 'YYYY-MM-DD'), 581, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Pokémon'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698593427, 'Lucario', 'Lucario', 10, TO_DATE('2022-02-01', 'YYYY-MM-DD'), 856, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Pokémon'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698540438, 'Mew', 'Mew', 10, TO_DATE('2021-02-01', 'YYYY-MM-DD'), 643, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Pokémon'));
INSERT INTO P08_FigurineCaracteristique (figurine_reference, figurine_nom, figurine_personnage, figurine_taille, figurine_date_sortie, figurine_popid, figurine_chase, collection_id)VALUES(889698709774, 'Luxray', 'Luxray', 10, TO_DATE('2024-03-07', 'YYYY-MM-DD'), 956, 0, (SELECT collection_id FROM P08_Collection WHERE collection_nom = 'Pokémon'));


/*
 Insertion de l'inventaire
 */

INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698546966, 170.0, 0, 0, TO_DATE('2021-11-17', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698746052, 127.0, 1, 0, TO_DATE('2024-07-27', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803037833, 167.0, 1, 0, TO_DATE('2023-03-09', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698765299, 169.0, 1, 1, TO_DATE('2024-10-13', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698657686, 139.0, 1, 0, TO_DATE('2023-04-03', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698736961, 88.0, 1, 0, TO_DATE('2024-01-05', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698376037, 109.0, 1, 0, TO_DATE('2019-10-13', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803037079, NULL, 1, 1, TO_DATE('2017-09-19', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698303217, 105.0, 1, 1, TO_DATE('2020-05-06', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698364249, 171.0, 1, 1, TO_DATE('2023-05-30', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698603379, 97.0, 1, 0, TO_DATE('2024-04-28', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698433761, 130.0, 1, 0, TO_DATE('2019-10-28', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698683807, 62.0, 1, 0, TO_DATE('2024-08-06', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803042516, 171.0, 1, 0, TO_DATE('2022-11-04', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698226714, 108.0, 1, 0, TO_DATE('2023-02-01', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698657655, 131.0, 1, 1, TO_DATE('2023-02-17', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698683814, 133.0, 1, 1, TO_DATE('2022-07-17', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803071523, 110.0, 0, 0, TO_DATE('2021-03-30', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698439770, 170.0, 1, 0, TO_DATE('2023-02-22', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698746083, 104.0, 1, 0, TO_DATE('2023-12-01', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698376037, 149.0, 1, 0, TO_DATE('2020-07-27', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698475853, 128.0, 1, 0, TO_DATE('2022-09-21', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698747134, 154.0, 1, 0, TO_DATE('2024-05-29', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698765299, 103.0, 1, 0, TO_DATE('2024-07-26', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698756020, NULL, 1, 0, TO_DATE('2024-09-09', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698720656, 114.0, 1, 0, TO_DATE('2024-05-28', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698364300, 172.0, 1, 0, TO_DATE('2021-08-07', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698702720, 24.0, 0, 0, TO_DATE('2024-01-06', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698218849, 104.0, 1, 0, TO_DATE('2018-11-07', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698506687, 100.0, 1, 1, TO_DATE('2020-10-31', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698742924, 105.0, 1, 1, TO_DATE('2023-10-16', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698443357, 65.0, 1, 0, TO_DATE('2021-12-26', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698411509, 129.0, 1, 0, TO_DATE('2024-08-14', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698538619, 93.0, 1, 0, TO_DATE('2023-03-14', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803071554, 138.0, 1, 0, TO_DATE('2016-07-02', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803071554, 132.0, 1, 0, TO_DATE('2016-02-07', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698756044, 137.0, 1, 0, TO_DATE('2024-08-04', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698765305, 24.0, 1, 1, TO_DATE('2024-05-04', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698765282, 40.0, 1, 1, TO_DATE('2024-07-25', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698470957, 167.0, 1, 1, TO_DATE('2021-11-03', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698576475, 114.0, 1, 0, TO_DATE('2023-01-22', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698362375, 164.0, 1, 0, TO_DATE('2021-06-23', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698593427, 127.0, 1, 0, TO_DATE('2023-08-29', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698572781, 154.0, 0, 0, TO_DATE('2023-11-05', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698765282, 160.0, 1, 1, TO_DATE('2024-06-23', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698567985, 151.0, 1, 1, TO_DATE('2023-04-12', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698742924, 140.0, 1, 0, TO_DATE('2024-05-22', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803042530, 167.0, 1, 0, TO_DATE('2020-01-11', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698702720, 160.0, 1, 0, TO_DATE('2024-02-05', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698540438, 141.0, 0, 0, TO_DATE('2024-01-30', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803075255, 62.0, 0, 0, TO_DATE('2019-09-06', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698274487, 125.0, 0, 0, TO_DATE('2024-06-07', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698394420, 163.0, 1, 0, TO_DATE('2024-03-19', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698540438, 162.0, 1, 1, TO_DATE('2021-08-12', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698469258, 157.0, 1, 0, TO_DATE('2023-04-04', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698108515, 96.0, 1, 0, TO_DATE('2023-04-19', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698653763, 122.0, 1, 0, TO_DATE('2023-07-02', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698720656, 96.0, 1, 0, TO_DATE('2023-10-16', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698720670, 68.0, 1, 0, TO_DATE('2023-10-29', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698746083, 161.0, 1, 0, TO_DATE('2024-06-04', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698720670, 165.0, 1, 0, TO_DATE('2024-04-19', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698410076, NULL, 1, 0, TO_DATE('2021-08-09', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698653763, 122.0, 1, 0, TO_DATE('2024-07-26', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698411868, 157.0, 1, 0, TO_DATE('2023-04-15', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698709774, 99.0, 1, 0, TO_DATE('2024-04-29', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698450393, 133.0, 1, 0, TO_DATE('2024-08-17', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698608534, 159.0, 1, 1, TO_DATE('2022-09-14', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698538619, 167.0, 1, 0, TO_DATE('2022-02-07', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698469241, 144.0, 1, 0, TO_DATE('2022-02-20', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698469258, 12.0, 0, 0, TO_DATE('2023-01-04', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698720670, 15.0, 1, 1, TO_DATE('2024-05-26', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803042516, 158.0, 1, 1, TO_DATE('2022-06-20', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698475853, 75.0, 1, 0, TO_DATE('2022-11-23', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698808972, 161.0, 0, 0, TO_DATE('2023-12-12', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698472395, 108.0, 0, 0, TO_DATE('2022-08-15', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698581660, 116.0, 1, 0, TO_DATE('2024-08-07', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698765305, 141.0, 1, 1, TO_DATE('2024-07-14', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698765299, 152.0, 1, 1, TO_DATE('2024-08-24', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698746052, 101.0, 1, 1, TO_DATE('2024-03-19', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698520836, 83.0, 1, 0, TO_DATE('2021-02-09', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698736961, 18.0, 1, 0, TO_DATE('2023-11-25', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698645355, 66.0, 1, 0, TO_DATE('2024-05-25', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698450393, 150.0, 1, 1, TO_DATE('2022-04-14', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698657679, 170.0, 1, 0, TO_DATE('2023-10-25', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698683814, 156.0, 1, 0, TO_DATE('2024-09-04', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698576482, 92.0, 1, 0, TO_DATE('2022-01-24', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698720625, 135.0, 1, 0, TO_DATE('2024-10-15', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698720663, 109.0, 1, 0, TO_DATE('2024-10-31', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698585590, 94.0, 1, 0, TO_DATE('2023-01-14', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698808958, NULL, 1, 1, TO_DATE('2024-10-14', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698485203, 149.0, 1, 1, TO_DATE('2021-02-10', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803037826, 58.0, 1, 0, TO_DATE('2018-06-07', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698476683, 109.0, 1, 0, TO_DATE('2020-05-01', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698709774, 97.0, 0, 0, TO_DATE('2024-10-04', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698218825, 89.0, 1, 0, TO_DATE('2024-10-13', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803037833, 97.0, 0, 0, TO_DATE('2022-11-24', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698301800, 86.0, 1, 0, TO_DATE('2018-09-10', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (849803042530, 143.0, 1, 0, TO_DATE('2017-10-23', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698303217, 114.0, 1, 0, TO_DATE('2021-04-05', 'YYYY-MM-DD'));
INSERT INTO P08_Inventaire (figurine_reference, figurine_prix, figurine_est_possedee, figurine_echangeable, figurine_date_acquisition) VALUES (889698568005, 171.0, 0, 0, TO_DATE('2021-11-09', 'YYYY-MM-DD'));

COMMIT;

--Créations des Vues

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


CREATE OR REPLACE VIEW P08_CompletionCollection
            (collection_id, collection_nom, nb_figurines_possedes, nb_modeles_possedes, nb_modeles_existant,
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

-- Creation Procedures fonctions et triggers
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
