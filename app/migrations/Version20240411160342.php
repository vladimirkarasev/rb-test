<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411160342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE tournaments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tournaments (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, slug TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4BCFAC3989D9B62 ON tournaments (slug)');
        $this->addSql('COMMENT ON COLUMN tournaments.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tournaments_team (tournaments_id INT NOT NULL, team_id INT NOT NULL, PRIMARY KEY(tournaments_id, team_id))');
        $this->addSql('CREATE INDEX IDX_28FD8350D92C1B5D ON tournaments_team (tournaments_id)');
        $this->addSql('CREATE INDEX IDX_28FD8350296CD8AE ON tournaments_team (team_id)');
        $this->addSql('ALTER TABLE tournaments_team ADD CONSTRAINT FK_28FD8350D92C1B5D FOREIGN KEY (tournaments_id) REFERENCES tournaments (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tournaments_team ADD CONSTRAINT FK_28FD8350296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tournaments_team DROP CONSTRAINT FK_28FD8350D92C1B5D');
        $this->addSql('DROP SEQUENCE tournaments_id_seq CASCADE');
        $this->addSql('DROP TABLE tournaments');
        $this->addSql('DROP TABLE tournaments_team');
    }
}
