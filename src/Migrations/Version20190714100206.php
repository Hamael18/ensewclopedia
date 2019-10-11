<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190714100206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE length (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version (id INT AUTO_INCREMENT NOT NULL, pattern_id INT NOT NULL, collar_id INT DEFAULT NULL, length_id INT DEFAULT NULL, handle_id INT DEFAULT NULL, size_min_id INT DEFAULT NULL, size_max_id INT DEFAULT NULL, level_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BF1CD3C3F734A20F (pattern_id), INDEX IDX_BF1CD3C34568D8A0 (collar_id), INDEX IDX_BF1CD3C361ED455A (length_id), INDEX IDX_BF1CD3C39C256C9C (handle_id), INDEX IDX_BF1CD3C343775D8C (size_min_id), INDEX IDX_BF1CD3C32E1D0246 (size_max_id), INDEX IDX_BF1CD3C35FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE size (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C3F734A20F FOREIGN KEY (pattern_id) REFERENCES pattern (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C34568D8A0 FOREIGN KEY (collar_id) REFERENCES collar (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C361ED455A FOREIGN KEY (length_id) REFERENCES length (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C39C256C9C FOREIGN KEY (handle_id) REFERENCES handle (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C343775D8C FOREIGN KEY (size_min_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C32E1D0246 FOREIGN KEY (size_max_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C35FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C361ED455A');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C343775D8C');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C32E1D0246');
        $this->addSql('DROP TABLE length');
        $this->addSql('DROP TABLE version');
        $this->addSql('DROP TABLE size');
    }
}
