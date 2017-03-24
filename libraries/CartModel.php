<?php
namespace App\Lib;


class CartModel extends Model
{

    public function addToCart($user_id, $item_id, $item_quantity)
    {
        $user_id = (int)$user_id;
        $item_id = (int)$item_id;
        $item_quantity = (int)$item_quantity;

        //check if it's already there
        if (!$this->presentInCart($user_id, $item_id)) {
            $insert_statement = $this->db->prepare("insert into cart (`user_id`, `item_id`, `quantity`) values (:user_id, :item_id, :quantity)");
            $insert_result = $insert_statement->execute(['user_id' => $user_id, 'item_id' => $item_id, 'quantity' => $item_quantity]);
            return $insert_result ? [true, ""] : [false, ""];
        } else {
            return [false, "This item is already in the cart"];
        }
    }

    public function remvoveFromCart($user_id, $item_id)
    {
        $user_id = (int)$user_id;
        $item_id = (int)$item_id;

        if ($this->presentInCart($user_id, $item_id)) {
            $delete_statement = $this->db->prepare("delete from cart where user_id = :user_id and item_id = :item_id");
            $delete_result = $delete_statement->execute(['user_id' => $user_id, 'item_id' => $item_id]);
            return $delete_result ? [true, ''] : [false, ''];
        } else {
            return [false, 'This item is not in the cart'];
        }
    }

    public function modifyCart($user_id, $item_id, $item_quantity)
    {
        $user_id = (int)$user_id;
        $item_id = (int)$item_id;
        $item_quantity = (int)$item_quantity;

        if ($this->presentInCart($user_id, $item_id)) {
            $update_statement = $this->db->prepare("update cart set quantity = :quantity where user_id = :user_id and item_id = :item_id");
            $update_result = $update_statement->execute(['quantity' => $item_quantity, 'user_id' => $user_id, 'item_id' => $item_id]);
            return $update_result ? [true, ""] : [false, ""];
        } else {
            return [false, "This item is not in the cart"];
        }
    }

    public function getItems($user_id, $items, $offset = null)
    {
        $user_id = (int)$user_id;
        $items = (int)$items;

        $offset_statement = "";
        if (!empty($offset)) {
            $offset_statement = " and created_at < :offset ";
        }
        $statement = $this->db->prepare("select item_id, quantity, created_at from cart where user_id = :user_id  " . $offset_statement . " order by created_at desc limit :items");
        $statement->bindValue(':items', $items, \PDO::PARAM_INT);
        $statement->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        if (!empty($offset)) {
            $statement->bindValue(':offset', $offset);
        }
        $result = $statement->execute();

        $items = [];
        while ($row = $statement->fetch()) {
            $item_id = $row['item_id'];
            $item = new ItemModel($this->db);
            $item->init($item_id);
            $items[] = ['item' => $item->getDetails(), 'quantity' => $row['quantity'], 'added_at' => $row['created_at']];
        }

        return $items;
    }

    private function presentInCart($user_id, $item_id)
    {
        $user_id = (int)$user_id;
        $item_id = (int)$item_id;

        $statement = $this->db->prepare("select count(*) from cart where user_id = :user_id and item_id = :item_id");
        $result = $statement->execute(['user_id' => $user_id, 'item_id' => $item_id]);
        $exists = $result ? $statement->fetchColumn() : 0;

        return $exists;
    }
}
