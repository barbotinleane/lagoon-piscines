<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531094841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_asks (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, formation_libelle_id INT NOT NULL, formation_session_id INT DEFAULT NULL, goal VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number INT NOT NULL, address VARCHAR(255) DEFAULT NULL, postal_code INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, department VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, activity_category VARCHAR(255) DEFAULT NULL, handicap VARCHAR(255) DEFAULT NULL, prerequisites VARCHAR(255) DEFAULT NULL, knows_us LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', company_name VARCHAR(255) DEFAULT NULL, siren_or_rm VARCHAR(255) DEFAULT NULL, siret VARCHAR(255) DEFAULT NULL, id_pole_emploi VARCHAR(255) DEFAULT NULL, INDEX IDX_ECB3EED96BF700BD (status_id), INDEX IDX_ECB3EED9DD75E2B4 (formation_libelle_id), INDEX IDX_ECB3EED999973FE6 (formation_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_asks_stagiaires (formation_asks_id INT NOT NULL, stagiaires_id INT NOT NULL, INDEX IDX_D17B7A34768CF737 (formation_asks_id), INDEX IDX_D17B7A34887A63F9 (stagiaires_id), PRIMARY KEY(formation_asks_id, stagiaires_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_asks ADD CONSTRAINT FK_ECB3EED96BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE formation_asks ADD CONSTRAINT FK_ECB3EED9DD75E2B4 FOREIGN KEY (formation_libelle_id) REFERENCES formation_libelles (id)');
        $this->addSql('ALTER TABLE formation_asks ADD CONSTRAINT FK_ECB3EED999973FE6 FOREIGN KEY (formation_session_id) REFERENCES formation_sessions (id)');
        $this->addSql('ALTER TABLE formation_asks_stagiaires ADD CONSTRAINT FK_D17B7A34768CF737 FOREIGN KEY (formation_asks_id) REFERENCES formation_asks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_asks_stagiaires ADD CONSTRAINT FK_D17B7A34887A63F9 FOREIGN KEY (stagiaires_id) REFERENCES stagiaires (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE asks_stagiaires');
        $this->addSql('ALTER TABLE asks DROP FOREIGN KEY FK_BB6C0B996BF700BD');
        $this->addSql('ALTER TABLE asks DROP FOREIGN KEY FK_BB6C0B99DD75E2B4');
        $this->addSql('ALTER TABLE asks DROP FOREIGN KEY FK_BB6C0B9999973FE6');
        $this->addSql('DROP INDEX IDX_BB6C0B9999973FE6 ON asks');
        $this->addSql('DROP INDEX IDX_BB6C0B996BF700BD ON asks');
        $this->addSql('DROP INDEX IDX_BB6C0B99DD75E2B4 ON asks');
        $this->addSql('ALTER TABLE asks DROP status_id, DROP formation_libelle_id, DROP formation_session_id, DROP goal, DROP first_name, DROP last_name, DROP email, DROP phone_number, DROP address, DROP postal_code, DROP city, DROP department, DROP country, DROP activity_category, DROP handicap, DROP prerequisites, DROP knows_us, DROP company_name, DROP siren_or_rm, DROP siret, DROP id_pole_emploi');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_asks_stagiaires DROP FOREIGN KEY FK_D17B7A34768CF737');
        $this->addSql('CREATE TABLE asks_stagiaires (asks_id INT NOT NULL, stagiaires_id INT NOT NULL, INDEX IDX_42A5D1D9887A63F9 (stagiaires_id), INDEX IDX_42A5D1D93373B24C (asks_id), PRIMARY KEY(asks_id, stagiaires_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE asks_stagiaires ADD CONSTRAINT FK_42A5D1D93373B24C FOREIGN KEY (asks_id) REFERENCES asks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE asks_stagiaires ADD CONSTRAINT FK_42A5D1D9887A63F9 FOREIGN KEY (stagiaires_id) REFERENCES stagiaires (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE formation_asks');
        $this->addSql('DROP TABLE formation_asks_stagiaires');
        $this->addSql('ALTER TABLE asks ADD status_id INT DEFAULT NULL, ADD formation_libelle_id INT NOT NULL, ADD formation_session_id INT DEFAULT NULL, ADD goal VARCHAR(255) DEFAULT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD phone_number INT NOT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD postal_code INT DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD department VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) NOT NULL, ADD activity_category VARCHAR(255) DEFAULT NULL, ADD handicap VARCHAR(255) DEFAULT NULL, ADD prerequisites VARCHAR(255) DEFAULT NULL, ADD knows_us LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD company_name VARCHAR(255) DEFAULT NULL, ADD siren_or_rm VARCHAR(255) DEFAULT NULL, ADD siret VARCHAR(255) DEFAULT NULL, ADD id_pole_emploi VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE asks ADD CONSTRAINT FK_BB6C0B996BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE asks ADD CONSTRAINT FK_BB6C0B99DD75E2B4 FOREIGN KEY (formation_libelle_id) REFERENCES formation_libelles (id)');
        $this->addSql('ALTER TABLE asks ADD CONSTRAINT FK_BB6C0B9999973FE6 FOREIGN KEY (formation_session_id) REFERENCES formation_sessions (id)');
        $this->addSql('CREATE INDEX IDX_BB6C0B9999973FE6 ON asks (formation_session_id)');
        $this->addSql('CREATE INDEX IDX_BB6C0B996BF700BD ON asks (status_id)');
        $this->addSql('CREATE INDEX IDX_BB6C0B99DD75E2B4 ON asks (formation_libelle_id)');
    }
}
