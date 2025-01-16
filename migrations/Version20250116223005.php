<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116223005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Increate item number length';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                CHANGE number number VARCHAR(256) NOT NULL
        sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                CHANGE number number VARCHAR(32) NOT NULL
        sql);
    }
}
