<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906143737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actu (id INT AUTO_INCREMENT NOT NULL, chambre_id INT DEFAULT NULL, titre VARCHAR(120) NOT NULL, contenu LONGTEXT NOT NULL, photo VARCHAR(120) DEFAULT NULL, date_actu DATETIME NOT NULL, date_enreg DATETIME NOT NULL, INDEX IDX_837303429B177F54 (chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, email VARCHAR(120) NOT NULL, titre VARCHAR(120) NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_4C62E6386A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actu ADD CONSTRAINT FK_837303429B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6386A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actu DROP FOREIGN KEY FK_837303429B177F54');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6386A99F74A');
        $this->addSql('DROP TABLE actu');
        $this->addSql('DROP TABLE contact');
    }
}
