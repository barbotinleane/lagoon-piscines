<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221123150704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_asks ADD date_of_birth VARCHAR(255) NOT NULL, ADD place_of_birth VARCHAR(255) NOT NULL, ADD company_address VARCHAR(255) DEFAULT NULL, ADD company_postal_code INT DEFAULT NULL, ADD company_city VARCHAR(255) DEFAULT NULL, ADD company_country VARCHAR(255) DEFAULT NULL, ADD company_phone INT DEFAULT NULL, ADD company_email VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_asks DROP date_of_birth, DROP place_of_birth, DROP company_address, DROP company_postal_code, DROP company_city, DROP company_country, DROP company_phone, DROP company_email, CHANGE email email VARCHAR(255) NOT NULL, CHANGE phone_number phone_number INT NOT NULL, CHANGE country country VARCHAR(255) NOT NULL');
    }
}
