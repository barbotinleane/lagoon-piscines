<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409114039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE formation_categories');
        $this->addSql('ALTER TABLE formation_libelles ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation_libelles ADD CONSTRAINT FK_CE8FA7AD12469DE2 FOREIGN KEY (category_id) REFERENCES formation_category (id)');
        $this->addSql('CREATE INDEX IDX_CE8FA7AD12469DE2 ON formation_libelles (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_libelles DROP FOREIGN KEY FK_CE8FA7AD12469DE2');
        $this->addSql('CREATE TABLE formation_categories (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE formation_category');
        $this->addSql('DROP INDEX IDX_CE8FA7AD12469DE2 ON formation_libelles');
        $this->addSql('ALTER TABLE formation_libelles DROP category_id');
    }
}
