<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514112622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, comment VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_site_stuff (site_id INT NOT NULL, site_stuff_id INT NOT NULL, INDEX IDX_BD12A7FEF6BD1646 (site_id), INDEX IDX_BD12A7FE9947A89A (site_stuff_id), PRIMARY KEY(site_id, site_stuff_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_stuff (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE site_site_stuff ADD CONSTRAINT FK_BD12A7FEF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_site_stuff ADD CONSTRAINT FK_BD12A7FE9947A89A FOREIGN KEY (site_stuff_id) REFERENCES site_stuff (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_site_stuff DROP FOREIGN KEY FK_BD12A7FEF6BD1646');
        $this->addSql('ALTER TABLE site_site_stuff DROP FOREIGN KEY FK_BD12A7FE9947A89A');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE site_site_stuff');
        $this->addSql('DROP TABLE site_stuff');
    }
}
