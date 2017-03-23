<?php

use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // the users table
        if(!$this->hasTable('users')) {
            $users_table = $this->table('users');
            $users_table->addColumn('email', 'string', ['limit' => 255])
                ->addColumn('name', 'string', ['limit' => 255])
                ->addColumn('password', 'string', ['limit' => 255])
                ->addColumn('address', 'string', ['limit' => 255])
                ->addColumn('token', 'string', ['limit' => 255])
                ->save();
        }

        // the items table
        if(!$this->hasTable('items')) {
            $items_table = $this->table('items');
            $items_table->addColumn('name', 'string', ['limit' => 255])
                ->addColumn('description', 'string', ['limit' => 255])
                ->addColumn('price', 'integer')
                ->save();
        }

        // the cart table
        if(!$this->hasTable('cart')) {
            $cart_table = $this->table('cart');
            $cart_table->addColumn('user_id', 'integer')
                ->addColumn('item_id', 'integer')
                ->addColumn('quantity', 'integer')
                ->save();
        }
    }
}
