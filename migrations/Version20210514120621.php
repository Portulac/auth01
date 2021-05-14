<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514120621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checkitem (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, stuff_id INT NOT NULL, INDEX IDX_7BAB029F6BD1646 (site_id), INDEX IDX_7BAB029950A1740 (stuff_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE respond (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, checkitem_id INT NOT NULL, answer TINYINT(1) NOT NULL, INDEX IDX_99C5D563A76ED395 (user_id), INDEX IDX_99C5D5639EAC4C72 (checkitem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stuff (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE checkitem ADD CONSTRAINT FK_7BAB029F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE checkitem ADD CONSTRAINT FK_7BAB029950A1740 FOREIGN KEY (stuff_id) REFERENCES stuff (id)');
        $this->addSql('ALTER TABLE respond ADD CONSTRAINT FK_99C5D563A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE respond ADD CONSTRAINT FK_99C5D5639EAC4C72 FOREIGN KEY (checkitem_id) REFERENCES checkitem (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE respond DROP FOREIGN KEY FK_99C5D5639EAC4C72');
        $this->addSql('ALTER TABLE checkitem DROP FOREIGN KEY FK_7BAB029F6BD1646');
        $this->addSql('ALTER TABLE checkitem DROP FOREIGN KEY FK_7BAB029950A1740');
        $this->addSql('DROP TABLE checkitem');
        $this->addSql('DROP TABLE respond');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE stuff');
    }
}
