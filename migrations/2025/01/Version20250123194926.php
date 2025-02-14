<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250123194926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Unify db lengths';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                CHANGE image_type image_type VARCHAR(255) NOT NULL,
                CHANGE size size VARCHAR(255) NOT NULL,
                CHANGE number number VARCHAR(255) NOT NULL
        sql);
    }
}
