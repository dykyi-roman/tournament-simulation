<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20220316104031 extends AbstractMigration
{
    final const TABLE = 'tournament';

    public function getDescription(): string
    {
        return sprintf('Create table "%s"', self::TABLE);
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE);
        $table->addColumn('id', 'integer', array('autoincrement' => true));

        $table->addColumn('name', Types::STRING);
        $table->addColumn('teams_count', Types::SMALLINT);
        $table->addColumn('games_count', Types::SMALLINT);
        $table->addColumn('created_at', Types::DATETIME_MUTABLE);

        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['name'], 'UIX_NAME');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE);
    }
}
