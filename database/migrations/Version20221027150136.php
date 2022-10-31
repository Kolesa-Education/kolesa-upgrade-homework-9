<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027150136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('categories');

        $table->addColumn('id', 'integer', [
            'autoincrement' => true,
        ]);

        $table->addColumn('title', 'string', [
            'notnull' => true,
        ]);

        $table->addColumn('created_at', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addColumn('updated_at', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addColumn('deleted_at', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->setPrimaryKey(array('id'));

        $schema->getTable('categories')->addIndex(['title']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('categories');
    }
}
