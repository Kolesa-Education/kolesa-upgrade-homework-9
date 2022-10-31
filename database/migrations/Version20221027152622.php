<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027152622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('adverts');

        $table->addColumn('id', 'integer', [
            'autoincrement' => true,
        ]);

        $table->addColumn('title', 'string');

        $table->addColumn('description', 'text', [
            'notnull' => false,
        ]);

        $table->addColumn('price', 'float');

        $table->addColumn('created_at', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addColumn('updated_at', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addColumn('deleted_at', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addColumn('category_id', 'integer');

        $table->addForeignKeyConstraint('categories', ['category_id'], ['id']);

        $table->setPrimaryKey(array('id'));

        $schema->getTable('adverts')->addIndex(['title']);
        $schema->getTable('adverts')->addIndex(['category_id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('adverts');
    }
}
