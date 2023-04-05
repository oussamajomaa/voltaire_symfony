<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405044135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cl');
        $this->addSql('ALTER TABLE author ADD status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE copyst ADD status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE editor ADD status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE translator ADD status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP reset_token');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cl (book_id INT NOT NULL, description VARCHAR(250) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE author DROP status');
        $this->addSql('ALTER TABLE copyst DROP status');
        $this->addSql('ALTER TABLE editor DROP status');
        $this->addSql('ALTER TABLE user ADD reset_token VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE translator DROP status');
    }
}
