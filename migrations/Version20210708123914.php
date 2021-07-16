<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708123914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_check (id INT AUTO_INCREMENT NOT NULL, checkboxitem_id INT NOT NULL, site_id INT NOT NULL, is_done TINYINT(1) NOT NULL, INDEX IDX_DE4C574BA28FE696 (checkboxitem_id), INDEX IDX_DE4C574BF6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_check ADD CONSTRAINT FK_DE4C574BA28FE696 FOREIGN KEY (checkboxitem_id) REFERENCES checkbox_item (id)');
        $this->addSql('ALTER TABLE user_check ADD CONSTRAINT FK_DE4C574BF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_check');
    }
}
