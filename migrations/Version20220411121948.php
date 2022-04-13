<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411121948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE glad (id INT AUTO_INCREMENT NOT NULL, ludi_id INT DEFAULT NULL, name_glad VARCHAR(255) NOT NULL, address DOUBLE PRECISION NOT NULL, strength DOUBLE PRECISION NOT NULL, balance DOUBLE PRECISION NOT NULL, speed DOUBLE PRECISION NOT NULL, strat DOUBLE PRECISION NOT NULL, INDEX IDX_F041DD45390910BB (ludi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ludi (id INT AUTO_INCREMENT NOT NULL, name_ludi VARCHAR(255) NOT NULL, course_de_char TINYINT(1) NOT NULL, lutte TINYINT(1) NOT NULL, athletisme TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, ludi_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, coins INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649390910BB (ludi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE glad ADD CONSTRAINT FK_F041DD45390910BB FOREIGN KEY (ludi_id) REFERENCES ludi (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649390910BB FOREIGN KEY (ludi_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE glad DROP FOREIGN KEY FK_F041DD45390910BB');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649390910BB');
        $this->addSql('DROP TABLE glad');
        $this->addSql('DROP TABLE ludi');
        $this->addSql('DROP TABLE user');
    }
}
