<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504132106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, req1_id INT NOT NULL, req2_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_FBD8E0F8AB87CA0C (req1_id), INDEX IDX_FBD8E0F8B93265E2 (req2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8AB87CA0C FOREIGN KEY (req1_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8B93265E2 FOREIGN KEY (req2_id) REFERENCES experience (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8AB87CA0C');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8B93265E2');
        $this->addSql('DROP TABLE job');
    }
}
