<?php

declare(strict_types=1);


use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250123194926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix length inconsistencies';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                CHANGE name name VARCHAR(256) DEFAULT NULL
        sql);
        $this->addSql(<<<sql
            ALTER TABLE category
                CHANGE name name VARCHAR(256) DEFAULT NULL
        sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                CHANGE name name VARCHAR(255) DEFAULT NULL
        sql);
        $this->addSql(<<<sql
            ALTER TABLE category
                CHANGE name name VARCHAR(255) DEFAULT NULL
        sql);
    }
}
