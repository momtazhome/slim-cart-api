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

  public function modifyCart($user_id, $item_id, $item_quantity) {
    $user_id = (int)$user_id;
    $item_id = (int)$item_id;
    $item_quantity = (int)$item_quantity;

    if($this->presentInCart($user_id, $item_id)) {
      $update_statement = $this->db->prepare("update cart set quantity = :quantity where user_id = :user_id and item_id = :item_id");
      $update_result = $update_statement->execute(['quantity' => $item_quantity, 'user_id' => $user_id, 'item_id' => $item_id]);
      return $update_result ? true : false;
    }

    return true;
  }

  public function getItems($user_id, $items, $offset = null) {
    $user_id = (int)$user_id;
    $items = (int)$items;

    $statement = $this->db->prepare("select item_id, quantity from cart where user_id = :user_id limit :items");
    $statement->bindValue(':items', $items, PDO::PARAM_INT);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $result = $statement->execute();

    $items = [];
    while($row = $statement->fetch()) {
      $item_id = $row['item_id'];
      $item = new ItemModel($this->db);
      $item->init($item_id);
      $items[] = ['item' => $item->getDetails(), 'quantity' => $row['quantity']];
    }

    return $items ;
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
