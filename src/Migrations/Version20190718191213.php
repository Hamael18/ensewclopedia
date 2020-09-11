<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190718191213 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE version_size (version_id INT NOT NULL, size_id INT NOT NULL, INDEX IDX_46D0386E4BBC2705 (version_id), INDEX IDX_46D0386E498DA827 (size_id), PRIMARY KEY(version_id, size_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE version_size ADD CONSTRAINT FK_46D0386E4BBC2705 FOREIGN KEY (version_id) REFERENCES version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_size ADD CONSTRAINT FK_46D0386E498DA827 FOREIGN KEY (size_id) REFERENCES size (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE version_size');
    }
}
