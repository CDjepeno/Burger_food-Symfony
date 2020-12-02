<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202042022 extends AbstractMigration
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
        $this->addSql('ALTER TABLE orderdetails ADD products_id INT DEFAULT NULL, CHANGE order_id order_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orderdetails ADD CONSTRAINT FK_489AFCDC6C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE orderdetails ADD CONSTRAINT FK_489AFCDCFCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_489AFCDC6C8A81A9 ON orderdetails (products_id)');
        $this->addSql('CREATE INDEX IDX_489AFCDCFCDAEAAA ON orderdetails (order_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderdetails DROP FOREIGN KEY FK_489AFCDC6C8A81A9');
        $this->addSql('ALTER TABLE orderdetails DROP FOREIGN KEY FK_489AFCDCFCDAEAAA');
        $this->addSql('DROP INDEX IDX_489AFCDC6C8A81A9 ON orderdetails');
        $this->addSql('DROP INDEX IDX_489AFCDCFCDAEAAA ON orderdetails');
        $this->addSql('ALTER TABLE orderdetails ADD order_id INT DEFAULT NULL, DROP order_id_id, DROP products_id');
        $this->addSql('ALTER TABLE orderdetails ADD CONSTRAINT FK_489AFCDCFCDAEAAA FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_489AFCDCFCDAEAAA ON orderdetails (order_id)');
    }
}
