<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Alter top groups functionality to use a lookup/join table.
 */
class Version20121217171527 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE comps DROP top_groups;');
        $this->addSql(<<<EOT
CREATE TABLE comp_top_group (
  id int(11) unsigned NOT NULL,
  team_id int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOT
        );
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE comps ADD top_groups VARCHAR(64) NOT NULL;');
        $this->addSql('DROP TABLE comp_top_group');
    }
}
