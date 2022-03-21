<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20220316104033 extends AbstractMigration
{
    final const TABLE = 'match';

    public function getDescription(): string
    {
        return sprintf('Create table "%s"', self::TABLE);
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE);
        $table->addColumn('id', 'integer', array('autoincrement' => true));

        $table->addColumn('team', Types::STRING);
        $table->addColumn('won', Types::SMALLINT);
        $table->addColumn('drawn', Types::SMALLINT);
        $table->addColumn('lost', Types::SMALLINT);
        $table->addColumn('goal_for', Types::SMALLINT);
        $table->addColumn('goal_against', Types::SMALLINT);
        $table->addColumn('created_at', Types::DATETIME_MUTABLE);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE);
    }
}
