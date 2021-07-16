<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708120611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_check');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_check (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, site_id INT NOT NULL, checkboxitem_id INT NOT NULL, to_done TINYINT(1) NOT NULL, INDEX IDX_DE4C574BF6BD1646 (site_id), INDEX IDX_DE4C574BA76ED395 (user_id), INDEX IDX_DE4C574BA28FE696 (checkboxitem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_check ADD CONSTRAINT FK_DE4C574BA28FE696 FOREIGN KEY (checkboxitem_id) REFERENCES checkbox_item (id)');
        $this->addSql('ALTER TABLE user_check ADD CONSTRAINT FK_DE4C574BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_check ADD CONSTRAINT FK_DE4C574BF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
    }
}
