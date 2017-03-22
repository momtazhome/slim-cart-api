<?php


class CartModel extends Model {

	public function addToCart($user_id, $item_id, $item_quantity) {
    $user_id = (int)$user_id;
    $item_id = (int)$item_id;
    $item_quantity = (int)$item_quantity;

    //check if it's already there
    if(!$this->presentInCart($user_id, $item_id)) {
      $insert_statement = $this->db->prepare("insert into cart (`user_id`, `item_id`, `quantity`) values (:user_id, :item_id, :quantity)");
      $insert_result = $insert_statement->execute(['user_id' => $user_id, 'item_id' => $item_id, 'quantity' => $item_quantity]);
      return $insert_result ? true : false;
    }

    return true;
	}

  public function remvoveFromCart($user_id, $item_id) {
    $user_id = (int)$user_id;
    $item_id = (int)$item_id;

    if($this->presentInCart($user_id, $item_id)) {
      $delete_statement = $this->db->prepare("delete from cart where user_id = :user_id and item_id = :item_id");
      $delete_result = $delete_statement->execute(['user_id' => $user_id, 'item_id' => $item_id]);
      return $delete_result ? true : false;
    }

    return true;
  }

  /**
  * Checks if an item is already present in a user's cart
  */
  private function presentInCart($user_id, $item_id) {
    $user_id = (int)$user_id;
    $item_id = (int)$item_id;

    $statement = $this->db->prepare("select count(*) from cart where user_id = :user_id and item_id = :item_id");
    $result = $statement->execute(['user_id' => $user_id, 'item_id' => $item_id]);
    $exists = $result ? $statement->fetchColumn() : 0;

    return $exists;
  }
}
