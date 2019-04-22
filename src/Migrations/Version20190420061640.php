<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190420061640 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dei_contact ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD office_phone VARCHAR(255) DEFAULT NULL, ADD primary_address_street VARCHAR(255) DEFAULT NULL, ADD primary_address_city VARCHAR(255) DEFAULT NULL, ADD primary_address_state VARCHAR(255) DEFAULT NULL, ADD primary_address_postal_code VARCHAR(255) DEFAULT NULL, ADD primary_address_country VARCHAR(255) DEFAULT NULL, ADD alternate_address_street VARCHAR(255) DEFAULT NULL, ADD alternate_address_city VARCHAR(255) DEFAULT NULL, ADD alternate_address_state VARCHAR(255) DEFAULT NULL, ADD alternate_address_postal_code VARCHAR(255) DEFAULT NULL, ADD alternate_address_country VARCHAR(255) DEFAULT NULL, ADD email_address VARCHAR(255) DEFAULT NULL, DROP username, DROP password, DROP firstname, DROP lastname, DROP office, DROP primary_address, DROP city, DROP state, DROP postal_code, DROP country, DROP email, DROP intials, DROP alternative_address, DROP alternative_city, DROP alternative_state, DROP alternative_postal_code, DROP alternative_country, CHANGE title title VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dei_contact ADD password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD firstname VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD lastname VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD office VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD primary_address VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD city VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD state VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD postal_code VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD country VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD intials VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD alternative_address VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD alternative_city VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD alternative_state VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD alternative_postal_code VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD alternative_country VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP first_name, DROP office_phone, DROP primary_address_street, DROP primary_address_city, DROP primary_address_state, DROP primary_address_postal_code, DROP primary_address_country, DROP alternate_address_street, DROP alternate_address_city, DROP alternate_address_state, DROP alternate_address_postal_code, DROP alternate_address_country, DROP email_address, CHANGE title title VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE last_name username VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
