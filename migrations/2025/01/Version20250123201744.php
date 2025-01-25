<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250123201744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Move image to own table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS image');

        $this->addSql(<<<sql
            CREATE TABLE image (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
                hash CHAR(32) NOT NULL UNIQUE,
                type TINYTEXT NOT NULL,
                data MEDIUMTEXT NOT NULL
            )
        sql);

        $this->addSql(<<<sql
            INSERT IGNORE INTO image (data, type, hash)
            SELECT image, image_type, MD5(CONCAT(image_type, image))
            FROM item
        sql);

        $this->addSql(<<<sql
            ALTER TABLE item
                ADD COLUMN image_id INT UNSIGNED NOT NULL
        sql);

        $this->addSql(<<<sql
            UPDATE item it
            SET it.image_id = (
                SELECT im.id
                FROM image im
                WHERE im.hash = MD5(CONCAT(it.image_type, it.image))
            )
            WHERE it.image_id = 0
        sql);

        $this->addSql(<<<sql
            ALTER TABLE item
                DROP COLUMN image,
                DROP COLUMN image_type
        sql);

        $this->addSql(<<<sql
            ALTER TABLE item
                ADD CONSTRAINT fk_item_image_id_image_id
                    FOREIGN KEY (image_id)
                        REFERENCES image (id)
        sql);
    }
}
