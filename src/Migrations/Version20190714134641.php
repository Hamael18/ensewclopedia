<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190714134641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE version ADD fabric_id INT DEFAULT NULL, ADD style_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C3AB43EC50 FOREIGN KEY (fabric_id) REFERENCES fabric (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C3BACD6074 FOREIGN KEY (style_id) REFERENCES style (id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C3AB43EC50 ON version (fabric_id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C3BACD6074 ON version (style_id)');
        $this->addSql('ALTER TABLE version RENAME INDEX idx_bf1cd3c343775d8c TO IDX_BF1CD3C36B1F41C4');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C3AB43EC50');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C3BACD6074');
        $this->addSql('DROP INDEX IDX_BF1CD3C3AB43EC50 ON version');
        $this->addSql('DROP INDEX IDX_BF1CD3C3BACD6074 ON version');
        $this->addSql('ALTER TABLE version DROP fabric_id, DROP style_id');
        $this->addSql('ALTER TABLE version RENAME INDEX idx_bf1cd3c36b1f41c4 TO IDX_BF1CD3C343775D8C');
    }
}
