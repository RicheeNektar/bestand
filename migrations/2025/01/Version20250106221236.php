<?php

declare(strict_types=1);


use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250106221236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'feat: Bauart + Preis';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                ADD size VARCHAR(32) NOT NULL,
                ADD price FLOAT NOT NULL
        sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                DROP size,
                DROP price
        sql);
    }
}
