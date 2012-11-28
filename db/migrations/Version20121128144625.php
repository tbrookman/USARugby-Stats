<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Add game status table and status column in games.
 */
class Version20121128144625 extends AbstractMigration
{
    /**
     * {@inheritDoc}
     */
    public function up(Schema $schema)
    {
        $this->addSql(<<<EOT
CREATE TABLE game_status (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  status_name char(36) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOT
        );
        $this->addSql('ALTER TABLE games ADD status int(11) DEFAULT NULL;');
    }

    /**
     * {@inheritDoc}
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE game_status');
        $this->addSql('ALTER TABLE games DROP status;');
    }
}
