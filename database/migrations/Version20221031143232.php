<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221031143232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('adverts');
        $table->dropColumn('deleted_at');
        $table->addColumn('deleted_at', 'datetime', [
            'notnull' => false,
        ]);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('adverts');
        $table->dropColumn('deleted_at');
        $table->addColumn('deleted_at', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);
    }
}
