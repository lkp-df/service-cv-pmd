<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405085109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model_cv ADD createur_id INT NOT NULL');
        $this->addSql('ALTER TABLE model_cv ADD CONSTRAINT FK_70232E2573A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_70232E2573A201E5 ON model_cv (createur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model_cv DROP FOREIGN KEY FK_70232E2573A201E5');
        $this->addSql('DROP INDEX IDX_70232E2573A201E5 ON model_cv');
        $this->addSql('ALTER TABLE model_cv DROP createur_id');
    }
}
