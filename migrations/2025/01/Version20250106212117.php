<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250106212117 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            CREATE TABLE category (
                id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                name VARCHAR(255) NOT NULL
            )
        sql);
        $this->addSql(<<<sql
            CREATE TABLE item (
                id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                number VARCHAR(32) NOT NULL,
                image VARCHAR(512) NOT NULL,
                quantity INT NOT NULL,
                category_id INT NOT NULL,
                INDEX ix_item_category_id (category_id)
            )
        sql);
        $this->addSql(<<<sql
            ALTER TABLE item
                ADD CONSTRAINT fk_item_category_id_category_id FOREIGN KEY (category_id) REFERENCES category (id)
        sql);
    }
}
