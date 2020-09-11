<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190718190934 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C32E1D0246');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C343775D8C');
        $this->addSql('DROP INDEX IDX_BF1CD3C32E1D0246 ON version');
        $this->addSql('DROP INDEX IDX_BF1CD3C36B1F41C4 ON version');
        $this->addSql('ALTER TABLE version DROP size_min_id, DROP size_max_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE version ADD size_min_id INT DEFAULT NULL, ADD size_max_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C32E1D0246 FOREIGN KEY (size_max_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C343775D8C FOREIGN KEY (size_min_id) REFERENCES size (id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C32E1D0246 ON version (size_max_id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C36B1F41C4 ON version (size_min_id)');
    }
}
