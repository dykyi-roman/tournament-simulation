<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220316104032 extends AbstractMigration
{
    final const TABLE = 'tournament';

    public function up(Schema $schema): void
    {
        $this->addSql(sprintf('ALTER TABLE %s ADD COLUMN teams JSONB', self::TABLE));
    }

    public function down(Schema $schema): void
    {
        $this->addSql(sprintf('ALTER TABLE %s DROP COLUMN teams', self::TABLE));
    }
}
