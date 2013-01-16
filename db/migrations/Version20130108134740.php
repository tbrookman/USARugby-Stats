<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Adding show/hide status to team entries.
 */
class Version20130108134740 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE teams ADD status VARCHAR(10) NOT NULL');

    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE teams DROP status;');

    }
}
