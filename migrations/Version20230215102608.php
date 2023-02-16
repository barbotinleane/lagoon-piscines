<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215102608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_asks_stagiaires DROP FOREIGN KEY FK_D17B7A34768CF737');
        $this->addSql('ALTER TABLE formation_asks_stagiaires DROP FOREIGN KEY FK_D17B7A34887A63F9');
        $this->addSql('DROP TABLE formation_asks_stagiaires');
        $this->addSql('DROP TABLE stagiaires');
        $this->addSql('ALTER TABLE formation_asks DROP FOREIGN KEY FK_ECB3EED999973FE6');
        $this->addSql('DROP INDEX IDX_ECB3EED999973FE6 ON formation_asks');
        $this->addSql('ALTER TABLE formation_asks ADD number_of_learners INT DEFAULT NULL, DROP formation_session_id, DROP goal, DROP address, DROP postal_code, DROP city, DROP department, DROP country, DROP activity_category, DROP handicap, DROP prerequisites, DROP siren_or_rm, DROP siret, DROP id_pole_emploi, DROP is_stagiaire_multiple, DROP funding, DROP date_of_birth, DROP place_of_birth, DROP company_address, DROP company_city, DROP company_country, DROP company_phone, DROP company_email, DROP mathematics');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_asks_stagiaires (formation_asks_id INT NOT NULL, stagiaires_id INT NOT NULL, INDEX IDX_D17B7A34768CF737 (formation_asks_id), INDEX IDX_D17B7A34887A63F9 (stagiaires_id), PRIMARY KEY(formation_asks_id, stagiaires_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stagiaires (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, last_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, handicap TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE formation_asks_stagiaires ADD CONSTRAINT FK_D17B7A34768CF737 FOREIGN KEY (formation_asks_id) REFERENCES formation_asks (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_asks_stagiaires ADD CONSTRAINT FK_D17B7A34887A63F9 FOREIGN KEY (stagiaires_id) REFERENCES stagiaires (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_asks ADD goal VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD postal_code INT DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD department VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD activity_category LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD handicap TINYINT(1) DEFAULT NULL, ADD prerequisites VARCHAR(255) DEFAULT NULL, ADD siren_or_rm VARCHAR(255) DEFAULT NULL, ADD siret VARCHAR(255) DEFAULT NULL, ADD id_pole_emploi VARCHAR(255) DEFAULT NULL, ADD is_stagiaire_multiple TINYINT(1) DEFAULT NULL, ADD funding VARCHAR(255) NOT NULL, ADD date_of_birth VARCHAR(255) NOT NULL, ADD place_of_birth VARCHAR(255) NOT NULL, ADD company_address VARCHAR(255) DEFAULT NULL, ADD company_city VARCHAR(255) DEFAULT NULL, ADD company_country VARCHAR(255) DEFAULT NULL, ADD company_phone INT DEFAULT NULL, ADD company_email VARCHAR(255) DEFAULT NULL, ADD mathematics TINYINT(1) DEFAULT NULL, CHANGE number_of_learners formation_session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation_asks ADD CONSTRAINT FK_ECB3EED999973FE6 FOREIGN KEY (formation_session_id) REFERENCES formation_sessions (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_ECB3EED999973FE6 ON formation_asks (formation_session_id)');
    }
}
