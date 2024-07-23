<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240921081448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document (id UUID NOT NULL, type VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN document.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE document_item (id UUID NOT NULL, document_id UUID NOT NULL, product_id VARCHAR(255) NOT NULL, quantity INT NOT NULL, unit_price NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B8AFA98DC33F7837 ON document_item (document_id)');
        $this->addSql('COMMENT ON COLUMN document_item.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN document_item.document_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE inventory_error (id UUID NOT NULL, document_item_id UUID NOT NULL, calculated_stock INT NOT NULL, error INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_81411771B600F482 ON inventory_error (document_item_id)');
        $this->addSql('COMMENT ON COLUMN inventory_error.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inventory_error.document_item_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE stock_movement (id UUID NOT NULL, product_id VARCHAR(255) NOT NULL, movement_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, stock INT NOT NULL, average_price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN stock_movement.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE document_item ADD CONSTRAINT FK_B8AFA98DC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inventory_error ADD CONSTRAINT FK_81411771B600F482 FOREIGN KEY (document_item_id) REFERENCES document_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE document_item DROP CONSTRAINT FK_B8AFA98DC33F7837');
        $this->addSql('ALTER TABLE inventory_error DROP CONSTRAINT FK_81411771B600F482');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_item');
        $this->addSql('DROP TABLE inventory_error');
        $this->addSql('DROP TABLE stock_movement');
    }
}
