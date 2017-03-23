<?php

use Phinx\Seed\AbstractSeed;

class ItemsSeeder extends AbstractSeed
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
                'name' => 'lg tv',
                'description' => '40 inch led tv with full hd resolution',
                'price' => 40000
            ],
            [
                'name' => 'One plus 3t',
                'description' => 'The new flagshipkiller from one plus',
                'price' => 30000
            ]
        ];

        $items = $this->table('items');
        $items->insert($data)
            ->save();
    }
}
