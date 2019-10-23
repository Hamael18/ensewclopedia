<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021180151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, bool_length TINYINT(1) NOT NULL, bool_level TINYINT(1) NOT NULL, bool_handle TINYINT(1) NOT NULL, bool_size TINYINT(1) NOT NULL, bool_collar TINYINT(1) NOT NULL, bool_fabric TINYINT(1) NOT NULL, bool_style TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE version ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C3C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C3C54C8C93 ON version (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C3C54C8C93');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_BF1CD3C3C54C8C93 ON version');
        $this->addSql('ALTER TABLE version DROP type_id');
    }
}
