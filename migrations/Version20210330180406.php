<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330180406 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotions ADD nom_produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE promotions ADD CONSTRAINT FK_EA1B3034E7BFE8C FOREIGN KEY (nom_produit_id) REFERENCES pro (id)');
        $this->addSql('CREATE INDEX IDX_EA1B3034E7BFE8C ON promotions (nom_produit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotions DROP FOREIGN KEY FK_EA1B3034E7BFE8C');
        $this->addSql('DROP INDEX IDX_EA1B3034E7BFE8C ON promotions');
        $this->addSql('ALTER TABLE promotions DROP nom_produit_id');
    }
}
