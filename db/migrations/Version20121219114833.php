<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Add league type to competition table.
 */
class Version20121219114833 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE comps ADD league_type VARCHAR(20) NOT NULL;');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE comps DROP league_type VARCHAR(20) NOT NULL;');
    }
}
