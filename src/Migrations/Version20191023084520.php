<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191023084520 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE style_type (style_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_E35226D8BACD6074 (style_id), INDEX IDX_E35226D8C54C8C93 (type_id), PRIMARY KEY(style_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collar_type (collar_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_C3BCE2D84568D8A0 (collar_id), INDEX IDX_C3BCE2D8C54C8C93 (type_id), PRIMARY KEY(collar_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fabric_type (fabric_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_F6B419FBAB43EC50 (fabric_id), INDEX IDX_F6B419FBC54C8C93 (type_id), PRIMARY KEY(fabric_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE handle_type (handle_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_7C4335FF9C256C9C (handle_id), INDEX IDX_7C4335FFC54C8C93 (type_id), PRIMARY KEY(handle_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE length_type (length_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_A351209361ED455A (length_id), INDEX IDX_A3512093C54C8C93 (type_id), PRIMARY KEY(length_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE size_type (size_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_E77B918D498DA827 (size_id), INDEX IDX_E77B918DC54C8C93 (type_id), PRIMARY KEY(size_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE style_type ADD CONSTRAINT FK_E35226D8BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_type ADD CONSTRAINT FK_E35226D8C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collar_type ADD CONSTRAINT FK_C3BCE2D84568D8A0 FOREIGN KEY (collar_id) REFERENCES collar (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collar_type ADD CONSTRAINT FK_C3BCE2D8C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fabric_type ADD CONSTRAINT FK_F6B419FBAB43EC50 FOREIGN KEY (fabric_id) REFERENCES fabric (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fabric_type ADD CONSTRAINT FK_F6B419FBC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE handle_type ADD CONSTRAINT FK_7C4335FF9C256C9C FOREIGN KEY (handle_id) REFERENCES handle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE handle_type ADD CONSTRAINT FK_7C4335FFC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE length_type ADD CONSTRAINT FK_A351209361ED455A FOREIGN KEY (length_id) REFERENCES length (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE length_type ADD CONSTRAINT FK_A3512093C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE size_type ADD CONSTRAINT FK_E77B918D498DA827 FOREIGN KEY (size_id) REFERENCES size (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE size_type ADD CONSTRAINT FK_E77B918DC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE style_type');
        $this->addSql('DROP TABLE collar_type');
        $this->addSql('DROP TABLE fabric_type');
        $this->addSql('DROP TABLE handle_type');
        $this->addSql('DROP TABLE length_type');
        $this->addSql('DROP TABLE size_type');
    }
}
