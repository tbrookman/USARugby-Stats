<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Resource and picture table and support.
 */
class Version20121030132137 extends AbstractMigration
{
    /**
     * {@inheritDoc}
     */
    public function up(Schema $schema)
    {
        $this->addSql(<<<EOT
CREATE TABLE resources (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  uuid char(36) NOT NULL DEFAULT '',
  title varchar(120) DEFAULT NULL,
  location longblob,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOT
        );
        $this->addSql('ALTER TABLE teams ADD resources LONGBLOB NULL AFTER short;');
        $this->addSql('ALTER TABLE teams ADD logo_url VARCHAR(1024) NULL AFTER resources;');
        $this->addSql('ALTER TABLE players ADD picture_url LONGBLOB NULL AFTER lastname;');
        $this->addSql('ALTER TABLE games CHANGE field_num field_num CHAR(36) NULL DEFAULT \'\';');
    }

    /**
     * {@inheritDoc}
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE resources');
        $this->addSql('ALTER TABLE teams DROP resources;');
        $this->addSql('ALTER TABLE teams DROP logo_url;');
        $this->addSql('ALTER TABLE players DROP picture_url;');
        $this->addSql('ALTER TABLE games CHANGE field_num field_num int(2) NOT NULL;');
    }
}
