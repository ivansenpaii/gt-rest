<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240922120608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('ALTER TABLE document ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN document.id IS NULL');
        $this->addSql('ALTER TABLE document_item ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE document_item ALTER document_id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN document_item.id IS NULL');
        $this->addSql('COMMENT ON COLUMN document_item.document_id IS NULL');
        $this->addSql('ALTER TABLE inventory_error ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE inventory_error ALTER document_item_id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN inventory_error.id IS NULL');
        $this->addSql('COMMENT ON COLUMN inventory_error.document_item_id IS NULL');
        $this->addSql('ALTER TABLE stock_movement ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN stock_movement.id IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE stock_movement ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN stock_movement.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE document_item ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE document_item ALTER document_id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN document_item.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN document_item.document_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE inventory_error ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE inventory_error ALTER document_item_id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN inventory_error.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN inventory_error.document_item_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE document ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN document.id IS \'(DC2Type:uuid)\'');
    }
}
