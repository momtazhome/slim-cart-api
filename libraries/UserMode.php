<?php


class UserModel implements Model {

	protected $user_id = null;

	protected $user_details = null;

	public function init($user_id) {
		$this->user_id = $user_id;
	}

}