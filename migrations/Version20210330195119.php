<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330195119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotions CHANGE nom_produit_id nom_produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promotions RENAME INDEX pro_id TO IDX_EA1B3034E7BFE8C');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotions CHANGE nom_produit_id nom_produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE promotions RENAME INDEX idx_ea1b3034e7bfe8c TO pro_id');
    }
}
