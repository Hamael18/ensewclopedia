<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190712090820 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pattern_language (pattern_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_8415A899F734A20F (pattern_id), INDEX IDX_8415A89982F1BAF4 (language_id), PRIMARY KEY(pattern_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pattern_language ADD CONSTRAINT FK_8415A899F734A20F FOREIGN KEY (pattern_id) REFERENCES pattern (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pattern_language ADD CONSTRAINT FK_8415A89982F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pattern_language');
    }
}
