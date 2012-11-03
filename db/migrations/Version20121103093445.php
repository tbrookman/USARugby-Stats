<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Add top_groups option to competitions.
 */
class Version20121103093445 extends AbstractMigration
{
    /**
     * {@inheritDoc}
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE comps ADD top_groups VARCHAR(64) NOT NULL;');
    }

    public function down(Schema $schema)
    /**
     * {@inheritDoc}
     */
    {
        $this->addSql('ALTER TABLE comps DROP top_groups;');
    }
}
