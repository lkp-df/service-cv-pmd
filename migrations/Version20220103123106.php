<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103123106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre_interet (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, INDEX IDX_E1E0E4E04FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT NOT NULL, designation VARCHAR(255) NOT NULL, niveau_pourcent INT DEFAULT NULL, INDEX IDX_94D4687F4FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT NOT NULL, tel VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_4C62E6384FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT NOT NULL, num_cv INT NOT NULL, INDEX IDX_B66FFE924FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience_professionnelle (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT DEFAULT NULL, nom_entreprise VARCHAR(255) NOT NULL, poste_occupe VARCHAR(255) NOT NULL, annee_occupation VARCHAR(255) NOT NULL, INDEX IDX_4FC854EF4FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT NOT NULL, annee VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, ecole_obtention VARCHAR(255) NOT NULL, INDEX IDX_404021BF4FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE langue (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, niveau_pourcent INT DEFAULT NULL, INDEX IDX_9357758E4FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logiciel (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT NOT NULL, designation VARCHAR(255) NOT NULL, niveau_pourcent INT NOT NULL, INDEX IDX_2C50669C4FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, user_for_cv_id INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_E6D6B2974FB246AC (user_for_cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache_effectuer (id INT AUTO_INCREMENT NOT NULL, experience_professionnelle_id INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_C0810C508F978030 (experience_professionnelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_for_cv (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, poste_recherche_occupe VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centre_interet ADD CONSTRAINT FK_E1E0E4E04FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F4FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6384FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE924FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE experience_professionnelle ADD CONSTRAINT FK_4FC854EF4FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF4FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE langue ADD CONSTRAINT FK_9357758E4FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE logiciel ADD CONSTRAINT FK_2C50669C4FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B2974FB246AC FOREIGN KEY (user_for_cv_id) REFERENCES user_for_cv (id)');
        $this->addSql('ALTER TABLE tache_effectuer ADD CONSTRAINT FK_C0810C508F978030 FOREIGN KEY (experience_professionnelle_id) REFERENCES experience_professionnelle (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache_effectuer DROP FOREIGN KEY FK_C0810C508F978030');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A21BD112');
        $this->addSql('ALTER TABLE centre_interet DROP FOREIGN KEY FK_E1E0E4E04FB246AC');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F4FB246AC');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6384FB246AC');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE924FB246AC');
        $this->addSql('ALTER TABLE experience_professionnelle DROP FOREIGN KEY FK_4FC854EF4FB246AC');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF4FB246AC');
        $this->addSql('ALTER TABLE langue DROP FOREIGN KEY FK_9357758E4FB246AC');
        $this->addSql('ALTER TABLE logiciel DROP FOREIGN KEY FK_2C50669C4FB246AC');
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B2974FB246AC');
        $this->addSql('DROP TABLE centre_interet');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE experience_professionnelle');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE langue');
        $this->addSql('DROP TABLE logiciel');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE tache_effectuer');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_for_cv');
    }
}
