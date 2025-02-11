<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211171534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, region VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN country.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN country.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE moment (id SERIAL NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, date_from DATE DEFAULT NULL, date_to DATE DEFAULT NULL, exact_date DATE DEFAULT NULL, region VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_358C88A2A76ED395 ON moment (user_id)');
        $this->addSql('COMMENT ON COLUMN moment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN moment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE moment_country (moment_id INT NOT NULL, country_id INT NOT NULL, PRIMARY KEY(moment_id, country_id))');
        $this->addSql('CREATE INDEX IDX_74198F2AABE99143 ON moment_country (moment_id)');
        $this->addSql('CREATE INDEX IDX_74198F2AF92F3E70 ON moment_country (country_id)');
        $this->addSql('CREATE TABLE submoment (id SERIAL NOT NULL, moment_id INT NOT NULL, country_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_from DATE DEFAULT NULL, date_to DATE DEFAULT NULL, exact_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_53F00087ABE99143 ON submoment (moment_id)');
        $this->addSql('CREATE INDEX IDX_53F00087F92F3E70 ON submoment (country_id)');
        $this->addSql('COMMENT ON COLUMN submoment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN submoment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, birthday DATE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE moment ADD CONSTRAINT FK_358C88A2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE moment_country ADD CONSTRAINT FK_74198F2AABE99143 FOREIGN KEY (moment_id) REFERENCES moment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE moment_country ADD CONSTRAINT FK_74198F2AF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE submoment ADD CONSTRAINT FK_53F00087ABE99143 FOREIGN KEY (moment_id) REFERENCES moment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE submoment ADD CONSTRAINT FK_53F00087F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE moment DROP CONSTRAINT FK_358C88A2A76ED395');
        $this->addSql('ALTER TABLE moment_country DROP CONSTRAINT FK_74198F2AABE99143');
        $this->addSql('ALTER TABLE moment_country DROP CONSTRAINT FK_74198F2AF92F3E70');
        $this->addSql('ALTER TABLE submoment DROP CONSTRAINT FK_53F00087ABE99143');
        $this->addSql('ALTER TABLE submoment DROP CONSTRAINT FK_53F00087F92F3E70');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE moment');
        $this->addSql('DROP TABLE moment_country');
        $this->addSql('DROP TABLE submoment');
        $this->addSql('DROP TABLE "user"');
    }
}
