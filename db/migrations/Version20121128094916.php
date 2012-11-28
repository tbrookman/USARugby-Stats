<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Add division_id to competition pairs.
 */
class Version20121128094916 extends AbstractMigration
{
    /**
     * {@inheritDoc}
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE ct_pairs ADD division_id INT(6) NULL;');

    }

    /**
     * {@inheritDoc}
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE ct_pairs DROP division_id;');
    }
}
