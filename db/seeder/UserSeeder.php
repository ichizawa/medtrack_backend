<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'username' => 'admin',
                'student_id' => '123456789',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'john@example.com',
                'is_admin' => 1
            ],
        ];
    
        $this->table('users')->insert($data)->saveData();
    }
}
