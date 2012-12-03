<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121202153029 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql(<<<EOT
INSERT INTO `game_status` (`status_name`)
VALUES
        ('Not Yet Started'),
        ('Started'),
        ('Finished'),
        ('Home Forfeit'),
        ('Away Forfeit'),
        ('Cancelled');
EOT
        );
    }

    public function down(Schema $schema)
    {
        // Do nothing.
    }
}
