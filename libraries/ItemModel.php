<?php

class ItemModel extends Model {

	protected $item_id = null;
	protected $item_details = null;

	public function init($item_id) {
		$this->item_id = $item_id;
	}

  public function getDetails() {
    if(!$this->item_details) {
      $item_id = (int)$this->item_id;
      $statement = $this->db->prepare("select * from items where id = :item_id");
      $result = $statement->execute(['item_id' => $item_id]);
      $item_details = $result ? $statement->fetch() : [];

      $this->item_details = $item_details;
    }

    return $this->item_details;
  }

}
