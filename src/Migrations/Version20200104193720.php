<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104193720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__hands AS SELECT id, hand_round, player_id, card, winnerd_id FROM hands');
        $this->addSql('DROP TABLE hands');
        $this->addSql('CREATE TABLE hands (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hand_round INTEGER NOT NULL, player_id INTEGER NOT NULL, card VARCHAR(2) NOT NULL COLLATE BINARY, winnerd_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO hands (id, hand_round, player_id, card, winnerd_id) SELECT id, hand_round, player_id, card, winnerd_id FROM __temp__hands');
        $this->addSql('DROP TABLE __temp__hands');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__hands AS SELECT id, hand_round, player_id, card, winnerd_id FROM hands');
        $this->addSql('DROP TABLE hands');
        $this->addSql('CREATE TABLE hands (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hand_round INTEGER NOT NULL, player_id INTEGER NOT NULL, card VARCHAR(2) NOT NULL, winnerd_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO hands (id, hand_round, player_id, card, winnerd_id) SELECT id, hand_round, player_id, card, winnerd_id FROM __temp__hands');
        $this->addSql('DROP TABLE __temp__hands');
    }
}
