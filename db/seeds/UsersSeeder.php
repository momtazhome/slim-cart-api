<?php

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'email' => 'user@gmail.com',
                'name' => 'John Jacobs',
                'password' => "*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19",
                'address' => 'C-1/90, Sector 21 Rohini, New Delhi',
                'token' => 'alkj2321l23@123&asd*%s21)='
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)
            ->save();
    }
}
