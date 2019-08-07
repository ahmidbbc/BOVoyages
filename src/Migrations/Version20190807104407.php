<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190807104407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE travel (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, destination VARCHAR(100) NOT NULL, details LONGTEXT NOT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, max_guests SMALLINT NOT NULL, retail_price DOUBLE PRECISION NOT NULL, discount_rate SMALLINT NOT NULL, status SMALLINT NOT NULL, client_credit_card VARCHAR(16) DEFAULT NULL, INDEX IDX_2D0B6BCE19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(30) NOT NULL, name VARCHAR(100) NOT NULL, role SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE travel ADD CONSTRAINT FK_2D0B6BCE19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE travel DROP FOREIGN KEY FK_2D0B6BCE19EB6921');
        $this->addSql('DROP TABLE travel');
        $this->addSql('DROP TABLE user');
    }
}
