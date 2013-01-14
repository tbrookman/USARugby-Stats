<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Add Division {name, comp_id} table
 */
class Version20130114135037 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql(<<<EOT
CREATE TABLE `divisions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comp_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
EOT
        );
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE divisions');
    }
}
