<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121120163517 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql(<<<EOT
CREATE TABLE queue (
  id SERIAL,
  eta integer NOT NULL,
  item text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOT
        );
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE queue');
    }
}
