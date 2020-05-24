<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331130703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE arrondissement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE banque_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE arrondissement (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE personne (id SERIAL NOT NULL, num_cpte_banque VARCHAR(255) NOT NULL, nom_pe VARCHAR(255) DEFAULT NULL, prenom_pe VARCHAR(255) DEFAULT NULL, adresse_pe VARCHAR(255) DEFAULT NULL, telephone_pe INT DEFAULT NULL, code_postal INT DEFAULT NULL, nom_ville VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, login VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, anniv DATE DEFAULT NULL, tel_banque INT DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE locataire (id INT NOT NULL, banque_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C47CF6EB37E080D9 ON locataire (banque_id)');
        $this->addSql('CREATE TABLE banque (id INT NOT NULL, rue VARCHAR(255) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE proprietaire (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE visite (id SERIAL NOT NULL, client_id INT NOT NULL, appartement_id INT NOT NULL, date_visite DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B09C8CBB19EB6921 ON visite (client_id)');
        $this->addSql('CREATE INDEX IDX_B09C8CBBE1729BBA ON visite (appartement_id)');
        $this->addSql('CREATE TABLE demandes (id SERIAL NOT NULL, client_id INT NOT NULL, type VARCHAR(255) NOT NULL, date_depart DATE NOT NULL, date_arrivee DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BD940CBB19EB6921 ON demandes (client_id)');
        $this->addSql('CREATE TABLE demandes_arrondissement (demandes_id INT NOT NULL, arrondissement_id INT NOT NULL, PRIMARY KEY(demandes_id, arrondissement_id))');
        $this->addSql('CREATE INDEX IDX_AEF6EEA3F49DCC2D ON demandes_arrondissement (demandes_id)');
        $this->addSql('CREATE INDEX IDX_AEF6EEA3407DBC11 ON demandes_arrondissement (arrondissement_id)');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE appartement (id SERIAL NOT NULL, proprietaire_id INT DEFAULT NULL, locataire_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, prix_loc DOUBLE PRECISION NOT NULL, prix_charges DOUBLE PRECISION NOT NULL, rue VARCHAR(255) NOT NULL, arrondissement INT NOT NULL, etage INT NOT NULL, ascenseur BOOLEAN NOT NULL, preavis BOOLEAN NOT NULL, date_libre DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_71A6BD8D76C50E4A ON appartement (proprietaire_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_71A6BD8DD8A38199 ON appartement (locataire_id)');
        $this->addSql('CREATE TABLE appartement_admin (appartement_id INT NOT NULL, admin_id INT NOT NULL, PRIMARY KEY(appartement_id, admin_id))');
        $this->addSql('CREATE INDEX IDX_757C6EF7E1729BBA ON appartement_admin (appartement_id)');
        $this->addSql('CREATE INDEX IDX_757C6EF7642B8210 ON appartement_admin (admin_id)');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE locataire ADD CONSTRAINT FK_C47CF6EB37E080D9 FOREIGN KEY (banque_id) REFERENCES banque (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE locataire ADD CONSTRAINT FK_C47CF6EBBF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE proprietaire ADD CONSTRAINT FK_69E399D6BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBBE1729BBA FOREIGN KEY (appartement_id) REFERENCES appartement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demandes_arrondissement ADD CONSTRAINT FK_AEF6EEA3F49DCC2D FOREIGN KEY (demandes_id) REFERENCES demandes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demandes_arrondissement ADD CONSTRAINT FK_AEF6EEA3407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartement ADD CONSTRAINT FK_71A6BD8D76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartement ADD CONSTRAINT FK_71A6BD8DD8A38199 FOREIGN KEY (locataire_id) REFERENCES locataire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartement_admin ADD CONSTRAINT FK_757C6EF7E1729BBA FOREIGN KEY (appartement_id) REFERENCES appartement (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartement_admin ADD CONSTRAINT FK_757C6EF7642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE demandes_arrondissement DROP CONSTRAINT FK_AEF6EEA3407DBC11');
        $this->addSql('ALTER TABLE locataire DROP CONSTRAINT FK_C47CF6EBBF396750');
        $this->addSql('ALTER TABLE proprietaire DROP CONSTRAINT FK_69E399D6BF396750');
        $this->addSql('ALTER TABLE admin DROP CONSTRAINT FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C7440455BF396750');
        $this->addSql('ALTER TABLE appartement DROP CONSTRAINT FK_71A6BD8DD8A38199');
        $this->addSql('ALTER TABLE locataire DROP CONSTRAINT FK_C47CF6EB37E080D9');
        $this->addSql('ALTER TABLE appartement DROP CONSTRAINT FK_71A6BD8D76C50E4A');
        $this->addSql('ALTER TABLE demandes_arrondissement DROP CONSTRAINT FK_AEF6EEA3F49DCC2D');
        $this->addSql('ALTER TABLE appartement_admin DROP CONSTRAINT FK_757C6EF7642B8210');
        $this->addSql('ALTER TABLE visite DROP CONSTRAINT FK_B09C8CBBE1729BBA');
        $this->addSql('ALTER TABLE appartement_admin DROP CONSTRAINT FK_757C6EF7E1729BBA');
        $this->addSql('ALTER TABLE visite DROP CONSTRAINT FK_B09C8CBB19EB6921');
        $this->addSql('ALTER TABLE demandes DROP CONSTRAINT FK_BD940CBB19EB6921');
        $this->addSql('DROP SEQUENCE arrondissement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE banque_id_seq CASCADE');
        $this->addSql('DROP TABLE arrondissement');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE locataire');
        $this->addSql('DROP TABLE banque');
        $this->addSql('DROP TABLE proprietaire');
        $this->addSql('DROP TABLE visite');
        $this->addSql('DROP TABLE demandes');
        $this->addSql('DROP TABLE demandes_arrondissement');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE appartement');
        $this->addSql('DROP TABLE appartement_admin');
        $this->addSql('DROP TABLE client');
    }
}
