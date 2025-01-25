<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250123211751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add retailer';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            CREATE TABLE retailer (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE
            )
        sql);

        $this->addSql(<<<sql
            ALTER TABLE item
                ADD retailer_id INT UNSIGNED DEFAULT NULL
        sql);
        $this->addSql(<<<sql
            ALTER TABLE item
                ADD CONSTRAINT fk_item_retailer_retailer_id
                    FOREIGN KEY (retailer_id)
                        REFERENCES retailer (id)
        sql);
    }
}
