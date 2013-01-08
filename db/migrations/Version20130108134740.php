<?php

namespace RugbyStatsMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130108134740 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE teams INSERT status VARCHAR(10) NOT NULL');

    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE teams DROP status VARCHAR(10) NOT NULL;');

    }
}
