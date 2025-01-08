<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250108214114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Name field for items';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                ADD name VARCHAR(255) NOT NULL
        sql);
        $this->addSql(<<<sql
            CREATE INDEX ix_item_name ON item (name)
        sql);
        $this->addSql(<<<sql
            CREATE INDEX ix_item_size ON item (size)
        sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item
                DROP name
        sql);
        $this->addSql(<<<sql
            DROP INDEX ix_item_name ON item
        sql);
        $this->addSql(<<<sql
            DROP INDEX ix_item_size ON item
        sql);
    }
}
