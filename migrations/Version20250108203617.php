<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250108203617 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            CREATE INDEX ix_category_name ON category (name)         
        sql);
        $this->addSql(<<<sql
            CREATE INDEX ix_item_number ON item (number)         
        sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<sql
            DROP INDEX ix_item_number ON item;
        sql);
    }
}
