<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190422205253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE opportunities (id INT AUTO_INCREMENT NOT NULL, opportunity_name VARCHAR(255) DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, opportunity_amount VARCHAR(255) DEFAULT NULL, sales_stage VARCHAR(255) DEFAULT NULL, probability VARCHAR(255) DEFAULT NULL, next_step VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, account_name VARCHAR(255) DEFAULT NULL, expected_close_date VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, lead_source VARCHAR(255) DEFAULT NULL, campaign VARCHAR(255) DEFAULT NULL, assigned_to VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE opportunities');
    }
}
