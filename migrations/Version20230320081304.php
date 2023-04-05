<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320081304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vc');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('ALTER TABLE user ADD reset_token VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vc (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, description VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, classification_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contributor (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(1000) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, last_name VARCHAR(1000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, link_viaf VARCHAR(1000) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, notes TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user DROP reset_token');
    }
}
