<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601102338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC12469DE2');
        $this->addSql('DROP INDEX IDX_E8FF75CC12469DE2 ON faq');
        $this->addSql('ALTER TABLE faq DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faq ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC12469DE2 FOREIGN KEY (category_id) REFERENCES faq_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E8FF75CC12469DE2 ON faq (category_id)');
    }
}
