<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314150817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE p08_inventaire DROP CONSTRAINT p08_inventaire_figurine_reference_fkey');
        $this->addSql('DROP SEQUENCE ville_vil_num_seq CASCADE');
        $this->addSql('DROP SEQUENCE g10_equipe_equ_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE g10_staff_sta_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE g10_joueur_jou_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE auteur_aut_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE livre_liv_num_seq CASCADE');
        $this->addSql('DROP SEQUENCE inventaire_log_log_id_seq CASCADE');
        $this->addSql('CREATE TABLE p08_figurine_caracteristique (figurine_reference BIGINT NOT NULL, collection_id_id INT NOT NULL, figurine_nom VARCHAR(100) NOT NULL, figurine_personnage VARCHAR(100) NOT NULL, figurine_taille INT NOT NULL, figurine_date_sortie DATE NOT NULL, figurine_popid INT NOT NULL, figurine_chase BOOLEAN NOT NULL, PRIMARY KEY(figurine_reference))');
        $this->addSql('CREATE INDEX IDX_ACC86B8638BC2604 ON p08_figurine_caracteristique (collection_id_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE p08_figurine_caracteristique ADD CONSTRAINT FK_ACC86B8638BC2604 FOREIGN KEY (collection_id_id) REFERENCES p08_collection (collection_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE g10_staff DROP CONSTRAINT g10_staff_equ_id_fkey');
        $this->addSql('ALTER TABLE g10_joueur DROP CONSTRAINT g10_joueur_equ_id_fkey');
        $this->addSql('ALTER TABLE ville DROP CONSTRAINT ville_col_code_fkey');
        $this->addSql('ALTER TABLE visuelauteur DROP CONSTRAINT visuelauteur_aut_id_fkey');
        $this->addSql('ALTER TABLE visuelauteur DROP CONSTRAINT visuelauteur_vis_fichier_fkey');
        $this->addSql('ALTER TABLE p08_figurinecaracteristique DROP CONSTRAINT p08_figurinecaracteristique_collection_id_fkey');
        $this->addSql('ALTER TABLE visuel DROP CONSTRAINT visuel_liv_num_fkey');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE qtelivaut');
        $this->addSql('DROP TABLE g10_staff');
        $this->addSql('DROP TABLE g10_joueur');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE inventaire_log');
        $this->addSql('DROP TABLE visuelauteur');
        $this->addSql('DROP TABLE g10_equipe');
        $this->addSql('DROP TABLE p08_figurinecaracteristique');
        $this->addSql('DROP TABLE collectivite');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE lmsf');
        $this->addSql('DROP TABLE visuel');
        $this->addSql('ALTER TABLE p08_collection DROP CONSTRAINT p08_collection_collection_nom_key;');
        $this->addSql('ALTER TABLE p08_collection ALTER collection_id DROP DEFAULT');
        $this->addSql('ALTER TABLE p08_inventaire ALTER figurine_id DROP DEFAULT');
        $this->addSql('ALTER TABLE p08_inventaire RENAME COLUMN figurine_reference TO figurine_reference_id');
        $this->addSql('ALTER TABLE p08_inventaire ADD CONSTRAINT FK_15CD0623BF63CAE8 FOREIGN KEY (figurine_reference_id) REFERENCES p08_figurine_caracteristique (figurine_reference) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_15CD0623BF63CAE8 ON p08_inventaire (figurine_reference_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE p08_inventaire DROP CONSTRAINT FK_15CD0623BF63CAE8');
        $this->addSql('CREATE SEQUENCE ville_vil_num_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE g10_equipe_equ_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE g10_staff_sta_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE g10_joueur_jou_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE auteur_aut_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE livre_liv_num_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE inventaire_log_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE livre (liv_num SERIAL NOT NULL, liv_nom VARCHAR(50) NOT NULL, liv_date DATE DEFAULT NULL, PRIMARY KEY(liv_num))');
        $this->addSql('CREATE TABLE qtelivaut (aut_id INT DEFAULT NULL, nb_livres INT DEFAULT NULL)');
        $this->addSql('CREATE TABLE g10_staff (sta_id SERIAL NOT NULL, equ_id INT NOT NULL, sta_nom VARCHAR(50) NOT NULL, sta_prenom VARCHAR(50) NOT NULL, sta_genre VARCHAR(50) NOT NULL, sta_role VARCHAR(60) NOT NULL, PRIMARY KEY(sta_id))');
        $this->addSql('CREATE INDEX IDX_469BB0DFE8A8BAB9 ON g10_staff (equ_id)');
        $this->addSql('CREATE TABLE g10_joueur (jou_id SERIAL NOT NULL, equ_id INT NOT NULL, jou_nom VARCHAR(50) NOT NULL, jou_prenom VARCHAR(50) NOT NULL, jou_date_naissance DATE NOT NULL, jou_nationalite VARCHAR(50) NOT NULL, jou_taille INT NOT NULL, jou_poids INT NOT NULL, jou_position VARCHAR(2) DEFAULT NULL, jou_points DOUBLE PRECISION DEFAULT NULL, jou_match_joue INT DEFAULT NULL, PRIMARY KEY(jou_id))');
        $this->addSql('CREATE INDEX IDX_F51861ABE8A8BAB9 ON g10_joueur (equ_id)');
        $this->addSql('CREATE TABLE ville (vil_num SERIAL NOT NULL, col_code VARCHAR(3) NOT NULL, vil_nom VARCHAR(50) NOT NULL, vil_population INT NOT NULL, vil_statut VARCHAR(15) DEFAULT NULL, PRIMARY KEY(vil_num))');
        $this->addSql('CREATE INDEX IDX_43C3D9C3D59C3C82 ON ville (col_code)');
        $this->addSql('CREATE TABLE inventaire_log (log_id SERIAL NOT NULL, log_type CHAR(6) NOT NULL, log_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, figurine_id INT DEFAULT NULL, figurine_reference BIGINT DEFAULT NULL, figurine_prix INT DEFAULT NULL, figurine_est_possedee BOOLEAN DEFAULT NULL, figurine_echangeable BOOLEAN DEFAULT NULL, figurine_date_acquisition DATE DEFAULT NULL, PRIMARY KEY(log_id))');
        $this->addSql('CREATE TABLE visuelauteur (aut_id INT NOT NULL, vis_fichier VARCHAR(50) NOT NULL, PRIMARY KEY(aut_id, vis_fichier))');
        $this->addSql('CREATE INDEX IDX_5CF46A6A3E05390A ON visuelauteur (aut_id)');
        $this->addSql('CREATE INDEX IDX_5CF46A6A13D092FD ON visuelauteur (vis_fichier)');
        $this->addSql('CREATE TABLE g10_equipe (equ_id SERIAL NOT NULL, equ_nom VARCHAR(50) NOT NULL, equ_ville VARCHAR(50) NOT NULL, equ_classement INT NOT NULL, equ_titres_gagnes INT NOT NULL, equ_victoire INT NOT NULL, equ_defaite INT NOT NULL, equ_points DOUBLE PRECISION NOT NULL, PRIMARY KEY(equ_id))');
        $this->addSql('CREATE TABLE p08_figurinecaracteristique (figurine_reference BIGINT NOT NULL, collection_id INT NOT NULL, figurine_nom VARCHAR(100) NOT NULL, figurine_personnage VARCHAR(100) NOT NULL, figurine_taille INT NOT NULL, figurine_date_sortie DATE NOT NULL, figurine_popid INT NOT NULL, figurine_chase BOOLEAN NOT NULL, PRIMARY KEY(figurine_reference))');
        $this->addSql('CREATE INDEX IDX_8D7D5F8B514956FD ON p08_figurinecaracteristique (collection_id)');
        $this->addSql('CREATE TABLE collectivite (col_code VARCHAR(3) NOT NULL, col_nom VARCHAR(50) NOT NULL, col_population INT NOT NULL, col_superficie INT NOT NULL, col_region VARCHAR(30) NOT NULL, PRIMARY KEY(col_code))');
        $this->addSql('CREATE TABLE auteur (aut_id SERIAL NOT NULL, aut_nom VARCHAR(50) NOT NULL, aut_prenom VARCHAR(50) NOT NULL, PRIMARY KEY(aut_id))');
        $this->addSql('CREATE TABLE lmsf (liv_num INT NOT NULL, liv_titre VARCHAR(50) DEFAULT NULL, aut_nom VARCHAR(30) DEFAULT NULL, aut_prenom VARCHAR(30) DEFAULT NULL, aut_nom2 VARCHAR(30) DEFAULT NULL, aut_prenom2 VARCHAR(30) DEFAULT NULL, couv_fichier VARCHAR(30) DEFAULT NULL, couv_icone VARCHAR(30) DEFAULT NULL, couv_url2 VARCHAR(30) DEFAULT NULL, couv_icone2 VARCHAR(30) DEFAULT NULL, PRIMARY KEY(liv_num))');
        $this->addSql('CREATE TABLE visuel (vis_fichier VARCHAR(50) NOT NULL, liv_num INT NOT NULL, PRIMARY KEY(vis_fichier))');
        $this->addSql('CREATE INDEX IDX_8FA54D1B387FDB9A ON visuel (liv_num)');
        $this->addSql('ALTER TABLE g10_staff ADD CONSTRAINT g10_staff_equ_id_fkey FOREIGN KEY (equ_id) REFERENCES g10_equipe (equ_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE g10_joueur ADD CONSTRAINT g10_joueur_equ_id_fkey FOREIGN KEY (equ_id) REFERENCES g10_equipe (equ_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT ville_col_code_fkey FOREIGN KEY (col_code) REFERENCES collectivite (col_code) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visuelauteur ADD CONSTRAINT visuelauteur_aut_id_fkey FOREIGN KEY (aut_id) REFERENCES auteur (aut_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visuelauteur ADD CONSTRAINT visuelauteur_vis_fichier_fkey FOREIGN KEY (vis_fichier) REFERENCES visuel (vis_fichier) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE p08_figurinecaracteristique ADD CONSTRAINT p08_figurinecaracteristique_collection_id_fkey FOREIGN KEY (collection_id) REFERENCES p08_collection (collection_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visuel ADD CONSTRAINT visuel_liv_num_fkey FOREIGN KEY (liv_num) REFERENCES livre (liv_num) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE p08_figurine_caracteristique DROP CONSTRAINT FK_ACC86B8638BC2604');
        $this->addSql('DROP TABLE p08_figurine_caracteristique');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE SEQUENCE p08_collection_collection_id_seq');
        $this->addSql('SELECT setval(\'p08_collection_collection_id_seq\', (SELECT MAX(collection_id) FROM p08_collection))');
        $this->addSql('ALTER TABLE p08_collection ALTER collection_id SET DEFAULT nextval(\'p08_collection_collection_id_seq\')');
        $this->addSql('CREATE UNIQUE INDEX p08_collection_collection_nom_key ON p08_collection (collection_nom)');
        $this->addSql('DROP INDEX IDX_15CD0623BF63CAE8');
        $this->addSql('CREATE SEQUENCE p08_inventaire_figurine_id_seq');
        $this->addSql('SELECT setval(\'p08_inventaire_figurine_id_seq\', (SELECT MAX(figurine_id) FROM p08_inventaire))');
        $this->addSql('ALTER TABLE p08_inventaire ALTER figurine_id SET DEFAULT nextval(\'p08_inventaire_figurine_id_seq\')');
        $this->addSql('ALTER TABLE p08_inventaire RENAME COLUMN figurine_reference_id TO figurine_reference');
        $this->addSql('ALTER TABLE p08_inventaire ADD CONSTRAINT p08_inventaire_figurine_reference_fkey FOREIGN KEY (figurine_reference) REFERENCES p08_figurinecaracteristique (figurine_reference) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
