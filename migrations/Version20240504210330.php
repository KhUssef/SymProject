<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504210330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job_experience (job_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_6FE7511EBE04EA9 (job_id), INDEX IDX_6FE7511E46E90E27 (experience_id), PRIMARY KEY(job_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_experience (user_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_A2F707EFA76ED395 (user_id), INDEX IDX_A2F707EF46E90E27 (experience_id), PRIMARY KEY(user_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_experience ADD CONSTRAINT FK_6FE7511EBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_experience ADD CONSTRAINT FK_6FE7511E46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_experience ADD CONSTRAINT FK_A2F707EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_experience ADD CONSTRAINT FK_A2F707EF46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_experience DROP FOREIGN KEY FK_6FE7511EBE04EA9');
        $this->addSql('ALTER TABLE job_experience DROP FOREIGN KEY FK_6FE7511E46E90E27');
        $this->addSql('ALTER TABLE user_experience DROP FOREIGN KEY FK_A2F707EFA76ED395');
        $this->addSql('ALTER TABLE user_experience DROP FOREIGN KEY FK_A2F707EF46E90E27');
        $this->addSql('DROP TABLE job_experience');
        $this->addSql('DROP TABLE user_experience');
    }
}
