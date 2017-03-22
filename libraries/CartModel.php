<?php


class CartModel extends Model {

	public function addToCart($user_id, $item_id, $item_quantity) {
    $user_id = (int)$user_id;
    $item_id = (int)$item_id;

    //check if it's already there
		$statement = $this->db->prepare("select count(*) from cart where user_id = :user_id and item_id = :item_id");
		$result = $statement->execute(['user_id' => $user_id, 'item_id' => $item_id]);
		$exists = $result ? $statement->fetchColumn() : 0;

    if(!$exists) {
      $insert_statement = $this->db->prepare("insert into cart (`user_id`, `item_id`, `quantity`) values (:user_id, :item_id, :quantity)");
      $insert_result = $insert_statement->execute(['user_id' => $user_id, 'item_id' => $item_id, 'quantity' => $item_quantity]);
      return $insert_result ? true : false;
    }

    return true;
	}

}
