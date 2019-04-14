<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190412050421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, office VARCHAR(255) DEFAULT NULL, primary_address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, lead_source VARCHAR(255) DEFAULT NULL, campaign VARCHAR(255) DEFAULT NULL, reports_to VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, department VARCHAR(255) DEFAULT NULL, intials VARCHAR(255) NOT NULL, assigned_to VARCHAR(255) DEFAULT NULL, alternative_address VARCHAR(255) DEFAULT NULL, alternative_city VARCHAR(255) DEFAULT NULL, alternative_state VARCHAR(255) DEFAULT NULL, alternative_postal_code VARCHAR(255) DEFAULT NULL, alternative_country VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contact');
    }
}
