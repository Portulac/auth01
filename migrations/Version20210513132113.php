<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210513132113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE respond ADD user_id INT NOT NULL, ADD question_id INT NOT NULL');
        $this->addSql('ALTER TABLE respond ADD CONSTRAINT FK_99C5D563A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE respond ADD CONSTRAINT FK_99C5D5631E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_99C5D563A76ED395 ON respond (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_99C5D5631E27F6BF ON respond (question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE respond DROP FOREIGN KEY FK_99C5D563A76ED395');
        $this->addSql('ALTER TABLE respond DROP FOREIGN KEY FK_99C5D5631E27F6BF');
        $this->addSql('DROP INDEX IDX_99C5D563A76ED395 ON respond');
        $this->addSql('DROP INDEX UNIQ_99C5D5631E27F6BF ON respond');
        $this->addSql('ALTER TABLE respond DROP user_id, DROP question_id');
    }
}
