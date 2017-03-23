<?php

use Phinx\Seed\AbstractSeed;

class CartSeeder extends AbstractSeed
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
                'user_id' => 1,
                'item_id' => 1,
                'quantity' => 2
            ],
            [
                'user_id' => 1,
                'item_id' => 2,
                'quantity' => 5
            ],
        ];

        $cart = $this->table('cart');
        $cart->insert($data)
            ->save();
    }
}
