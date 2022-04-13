<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411130305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ludi ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ludi ADD CONSTRAINT FK_37714A4367B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_37714A4367B3B43D ON ludi (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ludi DROP FOREIGN KEY FK_37714A4367B3B43D');
        $this->addSql('DROP INDEX IDX_37714A4367B3B43D ON ludi');
        $this->addSql('ALTER TABLE ludi DROP users_id');
    }
}
