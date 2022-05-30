<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530131425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_ask CHANGE beach beach VARCHAR(255) NOT NULL, CHANGE beach_size beach_size VARCHAR(255) DEFAULT NULL, CHANGE heat_pump heat_pump VARCHAR(255) NOT NULL, CHANGE budget budget VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_ask CHANGE beach beach TINYINT(1) NOT NULL, CHANGE beach_size beach_size INT DEFAULT NULL, CHANGE heat_pump heat_pump TINYINT(1) NOT NULL, CHANGE budget budget INT DEFAULT NULL');
    }
}
