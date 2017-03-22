<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Routes

$app->get('/test', function(Request $request, Response $response, $args) {
	$res = $this->db->query("select * from users");
	// $res = $st->execute();
	var_dump($res->fetch()); exit;
});

// add an item to the cart
// POST "/cart/{user_id}/add" and POST data as the item details
$app->post('/cart/{user_id}/add', function(Request $request, Response $response, $args) {

});

// removing the item from the cart
// DELETE "/cart/{user_id}/remove" item id in the body
$app->delete('/cart/{user_id}/remove', function(Request $request, Response $response, $args) {

});

// updating the quantity of an item in the cart
// PUT "cart/{user_id}/update" item id and new quantity in the body
$app->put('/cart/{user_id}/update', function(Request $request, Response $response, $args) {

});

// getting all the items in the cart
// GET "cart/{user_id}/get/items"
$app->get('/cart/{user_id}/get/items', function(Request $request, Response $response, $args) {

});

// getting user information - billing address from the cart
// GET "cart/{user_id}/get/user"
$app->get('/cart/{user_id}/get/user', function(Request $request, Response $response, $args) {

	$user_id = (int)$args['user_id'];
    $user = new UserModel($this->db);
    $user->init($user_id);

    $user_details = $user->getUserById();
		$response = $response->withJson($user_details);
		return $response;
});
