<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516133053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asks (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, formation_libelle_id INT NOT NULL, formation_session_id INT DEFAULT NULL, goal VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number INT NOT NULL, address VARCHAR(255) DEFAULT NULL, postal_code INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, department VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, activity_category VARCHAR(255) DEFAULT NULL, handicap VARCHAR(255) DEFAULT NULL, prerequisites VARCHAR(255) DEFAULT NULL, knows_us LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', company_name VARCHAR(255) DEFAULT NULL, siren_or_rm VARCHAR(255) DEFAULT NULL, siret VARCHAR(255) DEFAULT NULL, id_pole_emploi VARCHAR(255) DEFAULT NULL, INDEX IDX_BB6C0B996BF700BD (status_id), INDEX IDX_BB6C0B99DD75E2B4 (formation_libelle_id), INDEX IDX_BB6C0B9999973FE6 (formation_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE asks_stagiaires (asks_id INT NOT NULL, stagiaires_id INT NOT NULL, INDEX IDX_42A5D1D93373B24C (asks_id), INDEX IDX_42A5D1D9887A63F9 (stagiaires_id), PRIMARY KEY(asks_id, stagiaires_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departments (id INT AUTO_INCREMENT NOT NULL, region_code VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_libelles (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, agrement TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, duration VARCHAR(255) NOT NULL, cost INT NOT NULL, route VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_sessions (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, registered INT DEFAULT NULL, capacity INT NOT NULL, INDEX IDX_5DF2CAE25200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaires (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number INT DEFAULT NULL, current_job VARCHAR(255) DEFAULT NULL, handicap TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, status_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asks ADD CONSTRAINT FK_BB6C0B996BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE asks ADD CONSTRAINT FK_BB6C0B99DD75E2B4 FOREIGN KEY (formation_libelle_id) REFERENCES formation_libelles (id)');
        $this->addSql('ALTER TABLE asks ADD CONSTRAINT FK_BB6C0B9999973FE6 FOREIGN KEY (formation_session_id) REFERENCES formation_sessions (id)');
        $this->addSql('ALTER TABLE asks_stagiaires ADD CONSTRAINT FK_42A5D1D93373B24C FOREIGN KEY (asks_id) REFERENCES asks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE asks_stagiaires ADD CONSTRAINT FK_42A5D1D9887A63F9 FOREIGN KEY (stagiaires_id) REFERENCES stagiaires (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_sessions ADD CONSTRAINT FK_5DF2CAE25200282E FOREIGN KEY (formation_id) REFERENCES formation_libelles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asks_stagiaires DROP FOREIGN KEY FK_42A5D1D93373B24C');
        $this->addSql('ALTER TABLE asks DROP FOREIGN KEY FK_BB6C0B99DD75E2B4');
        $this->addSql('ALTER TABLE formation_sessions DROP FOREIGN KEY FK_5DF2CAE25200282E');
        $this->addSql('ALTER TABLE asks DROP FOREIGN KEY FK_BB6C0B9999973FE6');
        $this->addSql('ALTER TABLE asks_stagiaires DROP FOREIGN KEY FK_42A5D1D9887A63F9');
        $this->addSql('ALTER TABLE asks DROP FOREIGN KEY FK_BB6C0B996BF700BD');
        $this->addSql('DROP TABLE asks');
        $this->addSql('DROP TABLE asks_stagiaires');
        $this->addSql('DROP TABLE departments');
        $this->addSql('DROP TABLE formation_libelles');
        $this->addSql('DROP TABLE formation_sessions');
        $this->addSql('DROP TABLE stagiaires');
        $this->addSql('DROP TABLE status');
    }
}
