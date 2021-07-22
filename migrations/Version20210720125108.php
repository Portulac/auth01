<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720125108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `checkbox_item` (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_DB2BC6EAA977936C (tree_root), INDEX IDX_DB2BC6EA727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_694309E4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, facebook_id VARCHAR(255) DEFAULT NULL, facebook_access_token VARCHAR(255) DEFAULT NULL, vkontakte_id VARCHAR(255) DEFAULT NULL, vkontakte_access_token VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user_check` (id INT AUTO_INCREMENT NOT NULL, checkboxitem_id INT NOT NULL, site_id INT NOT NULL, is_done TINYINT(1) NOT NULL, INDEX IDX_DE4C574BA28FE696 (checkboxitem_id), INDEX IDX_DE4C574BF6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `checkbox_item` ADD CONSTRAINT FK_DB2BC6EAA977936C FOREIGN KEY (tree_root) REFERENCES `checkbox_item` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `checkbox_item` ADD CONSTRAINT FK_DB2BC6EA727ACA70 FOREIGN KEY (parent_id) REFERENCES `checkbox_item` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user_check` ADD CONSTRAINT FK_DE4C574BA28FE696 FOREIGN KEY (checkboxitem_id) REFERENCES `checkbox_item` (id)');
        $this->addSql('ALTER TABLE `user_check` ADD CONSTRAINT FK_DE4C574BF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `checkbox_item` DROP FOREIGN KEY FK_DB2BC6EAA977936C');
        $this->addSql('ALTER TABLE `checkbox_item` DROP FOREIGN KEY FK_DB2BC6EA727ACA70');
        $this->addSql('ALTER TABLE `user_check` DROP FOREIGN KEY FK_DE4C574BA28FE696');
        $this->addSql('ALTER TABLE `user_check` DROP FOREIGN KEY FK_DE4C574BF6BD1646');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E4A76ED395');
        $this->addSql('DROP TABLE `checkbox_item`');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE `user_check`');
    }
}
