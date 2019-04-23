<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190422135930 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dei_contact (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, department VARCHAR(255) DEFAULT NULL, office_phone VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, primary_address_street VARCHAR(255) DEFAULT NULL, primary_address_city VARCHAR(255) DEFAULT NULL, primary_address_state VARCHAR(255) DEFAULT NULL, primary_address_postal_code VARCHAR(255) DEFAULT NULL, primary_address_country VARCHAR(255) DEFAULT NULL, alternate_address_street VARCHAR(255) DEFAULT NULL, alternate_address_city VARCHAR(255) DEFAULT NULL, alternate_address_state VARCHAR(255) DEFAULT NULL, alternate_address_postal_code VARCHAR(255) DEFAULT NULL, alternate_address_country VARCHAR(255) DEFAULT NULL, email_address VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, reports_to VARCHAR(255) DEFAULT NULL, lead_source VARCHAR(255) DEFAULT NULL, campaign VARCHAR(255) DEFAULT NULL, assigned_to VARCHAR(255) DEFAULT NULL, date_created VARCHAR(255) DEFAULT NULL, date_modified VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE dei_contact');
    }
}
