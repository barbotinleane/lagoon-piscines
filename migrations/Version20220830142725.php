<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830142725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_asks ADD is_stagiaire_multiple TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE formation_libelles DROP FOREIGN KEY FK_CE8FA7AD12469DE2');
        $this->addSql('DROP INDEX IDX_CE8FA7AD12469DE2 ON formation_libelles');
        $this->addSql('ALTER TABLE formation_libelles DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_asks DROP is_stagiaire_multiple');
        $this->addSql('ALTER TABLE formation_libelles ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation_libelles ADD CONSTRAINT FK_CE8FA7AD12469DE2 FOREIGN KEY (category_id) REFERENCES formation_categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CE8FA7AD12469DE2 ON formation_libelles (category_id)');
    }
}
