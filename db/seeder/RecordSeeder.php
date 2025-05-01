<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class RecordSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'document_type' => 'Flu Vaccine',
                'note' => 'test note',
                'entry_date' => '2025-04-22',
                'exp_date' => '2025-04-30',
                'file_name' => 'test.pdf',
                'status' => 1
            ],
        ];
    
        $this->table('records')->insert($data)->saveData();
    }
}
