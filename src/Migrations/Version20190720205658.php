<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190720205658 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE version_collar (version_id INT NOT NULL, collar_id INT NOT NULL, INDEX IDX_A67D24994BBC2705 (version_id), INDEX IDX_A67D24994568D8A0 (collar_id), PRIMARY KEY(version_id, collar_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version_length (version_id INT NOT NULL, length_id INT NOT NULL, INDEX IDX_7110B6E94BBC2705 (version_id), INDEX IDX_7110B6E961ED455A (length_id), PRIMARY KEY(version_id, length_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version_handle (version_id INT NOT NULL, handle_id INT NOT NULL, INDEX IDX_E1ED08824BBC2705 (version_id), INDEX IDX_E1ED08829C256C9C (handle_id), PRIMARY KEY(version_id, handle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version_fabric (version_id INT NOT NULL, fabric_id INT NOT NULL, INDEX IDX_1D8E58F84BBC2705 (version_id), INDEX IDX_1D8E58F8AB43EC50 (fabric_id), PRIMARY KEY(version_id, fabric_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version_style (version_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_34616C6F4BBC2705 (version_id), INDEX IDX_34616C6FBACD6074 (style_id), PRIMARY KEY(version_id, style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE version_collar ADD CONSTRAINT FK_A67D24994BBC2705 FOREIGN KEY (version_id) REFERENCES version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_collar ADD CONSTRAINT FK_A67D24994568D8A0 FOREIGN KEY (collar_id) REFERENCES collar (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_length ADD CONSTRAINT FK_7110B6E94BBC2705 FOREIGN KEY (version_id) REFERENCES version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_length ADD CONSTRAINT FK_7110B6E961ED455A FOREIGN KEY (length_id) REFERENCES length (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_handle ADD CONSTRAINT FK_E1ED08824BBC2705 FOREIGN KEY (version_id) REFERENCES version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_handle ADD CONSTRAINT FK_E1ED08829C256C9C FOREIGN KEY (handle_id) REFERENCES handle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_fabric ADD CONSTRAINT FK_1D8E58F84BBC2705 FOREIGN KEY (version_id) REFERENCES version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_fabric ADD CONSTRAINT FK_1D8E58F8AB43EC50 FOREIGN KEY (fabric_id) REFERENCES fabric (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_style ADD CONSTRAINT FK_34616C6F4BBC2705 FOREIGN KEY (version_id) REFERENCES version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version_style ADD CONSTRAINT FK_34616C6FBACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C34568D8A0');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C361ED455A');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C39C256C9C');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C3AB43EC50');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C3BACD6074');
        $this->addSql('DROP INDEX IDX_BF1CD3C34568D8A0 ON version');
        $this->addSql('DROP INDEX IDX_BF1CD3C39C256C9C ON version');
        $this->addSql('DROP INDEX IDX_BF1CD3C3AB43EC50 ON version');
        $this->addSql('DROP INDEX IDX_BF1CD3C3BACD6074 ON version');
        $this->addSql('DROP INDEX IDX_BF1CD3C361ED455A ON version');
        $this->addSql('ALTER TABLE version DROP collar_id, DROP length_id, DROP handle_id, DROP fabric_id, DROP style_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE version_collar');
        $this->addSql('DROP TABLE version_length');
        $this->addSql('DROP TABLE version_handle');
        $this->addSql('DROP TABLE version_fabric');
        $this->addSql('DROP TABLE version_style');
        $this->addSql('ALTER TABLE version ADD collar_id INT DEFAULT NULL, ADD length_id INT DEFAULT NULL, ADD handle_id INT DEFAULT NULL, ADD fabric_id INT DEFAULT NULL, ADD style_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C34568D8A0 FOREIGN KEY (collar_id) REFERENCES collar (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C361ED455A FOREIGN KEY (length_id) REFERENCES length (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C39C256C9C FOREIGN KEY (handle_id) REFERENCES handle (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C3AB43EC50 FOREIGN KEY (fabric_id) REFERENCES fabric (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C3BACD6074 FOREIGN KEY (style_id) REFERENCES style (id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C34568D8A0 ON version (collar_id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C39C256C9C ON version (handle_id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C3AB43EC50 ON version (fabric_id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C3BACD6074 ON version (style_id)');
        $this->addSql('CREATE INDEX IDX_BF1CD3C361ED455A ON version (length_id)');
    }
}
