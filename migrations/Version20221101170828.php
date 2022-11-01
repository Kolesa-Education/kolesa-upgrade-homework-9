<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221101170828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $adverts = $schema->createTable('adverts');
        $adverts->addColumn('id', Types::BIGINT)->setAutoincrement(true);
        $adverts->addColumn('title', Types::STRING);
        $adverts->addColumn('description', Types::STRING);
        $adverts->addColumn('price', Types::INTEGER);

        $adverts->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('adverts');
    }
}
