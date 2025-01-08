<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250108220407 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item DROP image;
        sql);
        $this->addSql(<<<sql
            ALTER TABLE item ADD image MEDIUMTEXT NOT NULL;
        sql);
        $this->addSql(<<<sql
            ALTER TABLE item ADD image_type VARCHAR(32) NOT NULL;
        sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<sql
            ALTER TABLE item DROP image;
        sql);
        $this->addSql(<<<sql
            ALTER TABLE item DROP image_type;
        sql);
        $this->addSql(<<<sql
            ALTER TABLE item ADD image VARCHAR(512);
        sql);
    }
}
