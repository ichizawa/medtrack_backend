<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateRecordsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('records');
        $table->addColumn('user_id', 'integer')
            ->addColumn('document_type', 'string')
            ->addColumn('note', 'string')
            ->addColumn('entry_date', 'date')
            ->addColumn('exp_date', 'date')
            ->addColumn('file_name', 'string')
            ->addColumn('status', 'integer')
            ->addColumn('deleted_at', 'timestamp', ['null' => true])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
