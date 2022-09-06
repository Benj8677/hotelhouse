<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906165548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, chambre_id INT DEFAULT NULL, service_id INT DEFAULT NULL, titre VARCHAR(120) NOT NULL, contenu VARCHAR(255) NOT NULL, valid TINYINT(1) DEFAULT NULL, date_enreg DATETIME NOT NULL, INDEX IDX_8F91ABF06A99F74A (membre_id), INDEX IDX_8F91ABF09B177F54 (chambre_id), INDEX IDX_8F91ABF0ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF06A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF09B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF06A99F74A');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF09B177F54');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0ED5CA9E6');
        $this->addSql('DROP TABLE avis');
    }
}
