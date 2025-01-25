<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250123212143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add description';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                ADD description TEXT NOT NULL,
                ADD link TINYTEXT NOT NULL,
                DROP number
        sql);
    }
}
