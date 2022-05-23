<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523164116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_ask (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone INT NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(255) NOT NULL, department VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, water_surface VARCHAR(255) DEFAULT NULL, shape VARCHAR(255) NOT NULL, pool_model VARCHAR(255) NOT NULL, pool_color VARCHAR(255) NOT NULL, beach TINYINT(1) NOT NULL, beach_size INT DEFAULT NULL, beach_color VARCHAR(255) DEFAULT NULL, filtration_type VARCHAR(255) DEFAULT NULL, heat_pump TINYINT(1) NOT NULL, building_starts DATE NOT NULL, budget INT DEFAULT NULL, notes VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_ask');
    }
}
