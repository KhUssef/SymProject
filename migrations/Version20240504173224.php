<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504173224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, exp1_id INT DEFAULT NULL, exp2_id INT DEFAULT NULL, exp3_id INT DEFAULT NULL, exp4_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, INDEX IDX_8D93D6498BD650B9 (exp1_id), INDEX IDX_8D93D6499963FF57 (exp2_id), INDEX IDX_8D93D64921DF9832 (exp3_id), INDEX IDX_8D93D649BC08A08B (exp4_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498BD650B9 FOREIGN KEY (exp1_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499963FF57 FOREIGN KEY (exp2_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64921DF9832 FOREIGN KEY (exp3_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BC08A08B FOREIGN KEY (exp4_id) REFERENCES experience (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498BD650B9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499963FF57');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64921DF9832');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BC08A08B');
        $this->addSql('DROP TABLE user');
    }
}
