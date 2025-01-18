<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250118153416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE countries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE moment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE submoment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE countries (id INT NOT NULL, name VARCHAR(100) NOT NULL, iso VARCHAR(2) NOT NULL, region VARCHAR(50) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN countries.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN countries.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE moment (id INT NOT NULL, user_id_id INT NOT NULL, country_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, date_from DATE DEFAULT NULL, date_to DATE DEFAULT NULL, exact_date DATE DEFAULT NULL, region VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_358C88A29D86650F ON moment (user_id_id)');
        $this->addSql('CREATE INDEX IDX_358C88A2D8A48BBD ON moment (country_id_id)');
        $this->addSql('COMMENT ON COLUMN moment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN moment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE submoment (id INT NOT NULL, moment_id_id INT NOT NULL, country_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, latitute DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, date_from DATE DEFAULT NULL, date_to DATE DEFAULT NULL, exact_date DATE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_53F00087A5111785 ON submoment (moment_id_id)');
        $this->addSql('CREATE INDEX IDX_53F00087D8A48BBD ON submoment (country_id_id)');
        $this->addSql('COMMENT ON COLUMN submoment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN submoment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE moment ADD CONSTRAINT FK_358C88A29D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE moment ADD CONSTRAINT FK_358C88A2D8A48BBD FOREIGN KEY (country_id_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE submoment ADD CONSTRAINT FK_53F00087A5111785 FOREIGN KEY (moment_id_id) REFERENCES moment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE submoment ADD CONSTRAINT FK_53F00087D8A48BBD FOREIGN KEY (country_id_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE countries_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE moment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE submoment_id_seq CASCADE');
        $this->addSql('ALTER TABLE moment DROP CONSTRAINT FK_358C88A29D86650F');
        $this->addSql('ALTER TABLE moment DROP CONSTRAINT FK_358C88A2D8A48BBD');
        $this->addSql('ALTER TABLE submoment DROP CONSTRAINT FK_53F00087A5111785');
        $this->addSql('ALTER TABLE submoment DROP CONSTRAINT FK_53F00087D8A48BBD');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE moment');
        $this->addSql('DROP TABLE submoment');
    }
}
