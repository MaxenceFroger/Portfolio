CREATE TABLE IF NOT EXISTS G02_pays (
    pays_id SERIAL PRIMARY KEY, 
    pays_nom VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS G02_athletes (
    athlete_id SERIAL PRIMARY KEY, 
    athlete_nom VARCHAR(50) NOT NULL,
    athlete_age INT NOT NULL,
    athlete_sexe VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS G02_epreuves (
    epreuve_id SERIAL PRIMARY KEY, 
    epreuve_nom VARCHAR(50) NOT NULL,
    epreuve_date DATE,
    epreuve_sexe VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS G02_participe (
    athlete_id INT REFERENCES G02_athletes (athlete_id),
    epreuve_id INT REFERENCES G02_epreuves (epreuve_id),
    classement INT NOT NULL,
    temps INT,
    PRIMARY KEY (athlete_id, epreuve_id)
);

CREATE TABLE IF NOT EXISTS G02_envoie (
    athlete_id INT REFERENCES G02_athletes (athlete_id),
    pays_id INT REFERENCES G02_pays (pays_id),
    PRIMARY KEY (athlete_id, pays_id)
);

INSERT INTO G02_pays VALUES
 (DEFAULT, 'Suisse'),
 (DEFAULT, 'Norvege'),
 (DEFAULT, 'Canada'),
 (DEFAULT, 'France'),
 (DEFAULT, 'Autriche'),
 (DEFAULT, 'Grece'),
 (DEFAULT, 'Italie'),
 (DEFAULT, 'Allemagne'),
 (DEFAULT, 'Etats-Unis');

INSERT INTO G02_athletes VALUES
 (DEFAULT, 'Marco Odermatt', 26, 'Homme'),
 (DEFAULT, 'Alex Aamodt Kilde', 31, 'Homme'),
 (DEFAULT, 'Cameron Alexander', 26, 'Homme'),
 (DEFAULT, 'James Crawford', 26, 'Homme'),
 (DEFAULT, 'Alexis Pinturault', 32, 'Homme'),
 (DEFAULT, 'Loïc Meillard', 27, 'Homme'),
 (DEFAULT, 'Marco Schwarz', 28, 'Homme'),
 (DEFAULT, 'Henrik Kristoffe', 29, 'Homme'),
 (DEFAULT, 'AJ Ginnis', 29, 'Homme'),
 (DEFAULT, 'Alex Vinatzer', 24, 'Homme'),
 (DEFAULT, 'Raphael Haaser', 26, 'Homme'),
 (DEFAULT, 'Alexander Schmid', 29, 'Homme'),
 (DEFAULT, 'Dominik Raschner', 29, 'Homme'),
 (DEFAULT, 'Timon Haugan', 26, 'Homme'),
 (DEFAULT, 'Jasmine Flury', 30, 'Femme'),
 (DEFAULT, 'Nina Ortlieb', 27, 'Femme'),
 (DEFAULT, 'Corinne Suter', 29, 'Femme'),
 (DEFAULT, 'Marta Bassino', 27, 'Femme'),
 (DEFAULT, 'Mikaela Shiffrin', 28, 'Femme'),
 (DEFAULT, 'Cornelia Hütter', 31, 'Femme'),
 (DEFAULT, 'Kajsa Vickhoff Lie', 25, 'Femme'),
 (DEFAULT, 'Frederica Brignone', 33, 'Femme'),
 (DEFAULT, 'Ragnhild Mowinckel', 31, 'Femme'),
 (DEFAULT, 'Laurence St-Germain', 29, 'Femme'), 
 (DEFAULT, 'Lena Dürr', 32, 'Femme'),
 (DEFAULT, 'Wendy Holdener', 30, 'Femme'),
 (DEFAULT, 'Ricarda Haaser', 30, 'Femme'),
 (DEFAULT, 'Maria Therese Tviberg', 29, 'Femme'),
 (DEFAULT, 'Thea Louise Stjernesund', 29, 'Femme'),
 (DEFAULT, 'Tony Ford', 34, 'Homme'),
 (DEFAULT, 'Katie Heinsen', 32, 'Femme'),
 (DEFAULT, 'Paula Moltzan', 29, 'Femme'),
 (DEFAULT, 'River Radamus', 25, 'Homme'),
 (DEFAULT, 'Luke Winters', 26, 'Homme'),
 (DEFAULT, 'Kristin Lysdahl', 27, 'Femme'),
 (DEFAULT, 'Leif Kristian Nestvold-Haugen', 36, 'Homme'),
 (DEFAULT, 'Alexander Steen Olsen', 22, 'Homme'),
 (DEFAULT, 'Valerie Grenier', 27, 'Femme'),
 (DEFAULT, 'Erik Read', 32, 'Homme'),
 (DEFAULT, 'Jeffrey Read', 26, 'Homme'),
 (DEFAULT, 'Brit Richardson', 20, 'Femme'),
 (DEFAULT, 'Nina OBrien', 26, 'Femme');
 
INSERT INTO G02_epreuves VALUES
 (DEFAULT, 'Descente', '2023-02-12', 'Homme'),
 (DEFAULT, 'Super-G', '2023-02-09', 'Homme'),
 (DEFAULT, 'Combine', '2023-02-07', 'Homme'),
 (DEFAULT, 'Slalom geant', '2023-02-17', 'Homme'),
 (DEFAULT, 'Slalom', '2023-02-19', 'Homme'),
 (DEFAULT, 'Parallele', '2023-02-15', 'Homme'),
 (DEFAULT, 'Descente', '2023-02-11', 'Femme'),
 (DEFAULT, 'Super-G', '2023-02-08', 'Femme'),
 (DEFAULT, 'Combine', '2023-02-06', 'Femme'),
 (DEFAULT, 'Slalom geant', '2023-02-16', 'Femme'),
 (DEFAULT, 'Slalom', '2023-02-18', 'Femme'),
 (DEFAULT, 'Parallele', '2023-02-15', 'Femme'),
 (DEFAULT, 'Par equipe', '2023-02-14', 'Mixte');
 
INSERT INTO G02_envoie VALUES
 (1,1),
 (2,2),
 (3,3),
 (4,3),
 (5,4),
 (6,1),
 (7,5),
 (8,2),
 (9,6),
 (10,7),
 (11,5),
 (12,8),
 (13,5),
 (14,2),
 (15,1),
 (16,5),
 (17,1),
 (18,7),
 (19,9),
 (20,5),
 (21,2),
 (22,7),
 (23,2),
 (24,3),
 (25,8),
 (26,1),
 (27,5),
 (28,2),
 (29,2),
 (30,9),
 (31,9),
 (32,9),
 (33,9),
 (34,9),
 (35,2),
 (36,2),
 (37,2),
 (38,3),
 (39,3),
 (40,3),
 (41,3),
 (42,9);

INSERT INTO G02_participe VALUES
 (1,1,1,107),
 (2,1,2,107),
 (3,1,3,107),
 (4,2,1,67),
 (2,2,2,67),
 (5,2,3,67),
 (1,3,1,154),
 (6,3,2,154),
 (7,3,3,154),
 (8,4,1,99),
 (9,4,2,99),
 (10,4,3,99),
 (5,5,1,93),
 (7,5,2,93),
 (11,5,3,93),
 (12,6,1,NULL),
 (13,6,2,NULL),
 (14,6,3,NULL),
 (15,7,1,88),
 (16,7,2,88),
 (17,7,3,88),
 (18,8,1,88),
 (19,8,2,88),
 (20,8,3,88),
 (21,8,3,88),
 (19,9,1,62),
 (22,9,2,62),
 (23,9,3,63),
 (24,10,1,103),
 (19,10,2,103),
 (25,10,3,103),
 (22,11,1,117),
 (26,11,2,119),
 (27,11,3,119),
 (28,12,1,NULL),
 (26,12,2,NULL),
 (29,12,3,NULL),
 (30,13,1,NULL),
 (31,13,1,NULL),
 (32,13,1,NULL),
 (42,13,1,NULL),
 (33,13,1,NULL),
 (34,13,1,NULL),
 (14,13,2,NULL),
 (35,13,2,NULL),
 (36,13,2,NULL),
 (37,13,2,NULL),
 (29,13,2,NULL),
 (28,13,2,NULL),
 (38,13,3,NULL),
 (39,13,3,NULL),
 (40,13,3,NULL),
 (41,13,3,NULL);