<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Add metadata support to team info.
 */
class Version20121107194458 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE teams ADD description VARCHAR(1024) NULL;');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE teams DROP description;');
    }
}
