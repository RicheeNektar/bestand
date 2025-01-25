<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250123210628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Move size to its own table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS size');

        $this->addSql(<<<sql
            CREATE TABLE size (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE
            )
        sql);

        $this->addSql(<<<sql
            INSERT IGNORE INTO size (name)
            SELECT item.size
            FROM item
        sql);

        $this->addSql(<<<sql
            ALTER TABLE item
                ADD COLUMN size_id INT UNSIGNED NOT NULL
        sql);

        $this->addSql(<<<sql
            UPDATE item i
            SET i.size_id = (
                SELECT s.id
                FROM size s
                WHERE s.name = i.size
            )
            WHERE i.size_id = 0
        sql);

        $this->addSql('ALTER TABLE item DROP COLUMN size');

        $this->addSql(<<<sql
            ALTER TABLE item
                ADD CONSTRAINT fk_item_size_id_size_id
                    FOREIGN KEY (size_id)
                        REFERENCES size (id)
        sql);
    }
}
