<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204223412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderdetails DROP FOREIGN KEY FK_489AFCDCFCDAEAAA');
        $this->addSql('DROP INDEX IDX_489AFCDCFCDAEAAA ON orderdetails');
        $this->addSql('ALTER TABLE orderdetails CHANGE order_id order_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orderdetails ADD CONSTRAINT FK_489AFCDCFCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_489AFCDCFCDAEAAA ON orderdetails (order_id_id)');
        $this->addSql('ALTER TABLE product ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderdetails DROP FOREIGN KEY FK_489AFCDCFCDAEAAA');
        $this->addSql('DROP INDEX IDX_489AFCDCFCDAEAAA ON orderdetails');
        $this->addSql('ALTER TABLE orderdetails CHANGE order_id_id order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orderdetails ADD CONSTRAINT FK_489AFCDCFCDAEAAA FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_489AFCDCFCDAEAAA ON orderdetails (order_id)');
        $this->addSql('ALTER TABLE product DROP updated_at');
    }
}
