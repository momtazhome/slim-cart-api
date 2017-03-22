<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface as ContainerInterface;

class CartController{

    private $db = null;

    public function __construct(ContainerInterface $container) {
      $this->db = $container->get('db');
    }

    public function getUser(Request $request, Response $response, $args) {
    	$user_id = (int)$args['user_id'];
    	if(empty($user_id))
    		return $response->withJson(['error' => 'Invalid request'], 400);

      $user = new UserModel($this->db);
      $user->init($user_id);

      $user_details = $user->getDetails();
    	$response = $response->withJson($user_details);
    	return $response;
    }

    public function getItems(Request $request, Response $response, $args) {
        $user_id = (int)$args['user_id'];
        if(empty($user_id))
            return $response->withJson(['error' => 'Invalid request'], 400);

        $cart = new CartModel($this->db);
        $items = $cart->getItems($user_id, 10);

        return $response->withJson(['items' => $items]);
    }

    public function updateCart(Request $request, Response $response, $args) {
        $user_id = (int)$args['user_id'];
        if(empty($user_id))
            return $response->withJson(['error' => 'Invalid request'], 400);

        $request_body = $request->getParsedBody();
        $item_id = isset($request_body['item_id']) ? (int)$request_body['item_id'] : null;
        $item_quanity = !empty($request_body['quantity']) ? (int)$request_body['quantity'] : null;
        $item = new ItemModel($this->db);
        $item->init($item_id);
        if(empty($item->getDetails()) || empty($item_quanity))
            return $response->withJson(['error' => 'Invalid request'], 400);

        $cart = new CartModel($this->db);
        $status = $cart->modifyCart($user_id, $item_id, $item_quanity);

        return $status ? $response->withJson(['success' => true]) : $response->withJson(['error' => "something went wrong"], 500);
    }

    public function removeFromCart(Request $request, Response $response, $args) {
        $user_id = (int)$args['user_id'];
        if(empty($user_id))
            return $response->withJson(['error' => 'Invalid request'], 400);

        $request_body = $request->getParsedBody();
        $item_id = isset($request_body['item_id']) ? $request_body['item_id'] : null;
        $item = new ItemModel($this->db);
        $item->init($item_id);
        if(empty($item->getDetails()))
            return $response->withJson(['error' => 'Invalid request'], 400);

        $cart = new CartModel($this->db);
        $status = $cart->remvoveFromCart($user_id, $item_id);

        return $status ? $response->withJson(['success' => true]) : $response->withJson(['error' => "something went wrong"], 500);
    }

    public function addToCart(Request $request, Response $response, $args) {
        $user_id = (int)$args['user_id'];
        if(empty($user_id))
            return $response->withJson(['error' => 'Invalid request'], 400);

        $request_body = $request->getParsedBody();
        $item_id = isset($request_body['item_id']) ? $request_body['item_id'] : null;
        $item_quanity = isset($request_body['quantity']) ? (int)$request_body['quantity'] : 1;
        $item = new ItemModel($this->db);
        $item->init($item_id);
        if(empty($item->getDetails()))
            return $response->withJson(['error' => 'Invalid request'], 400);

        $cart = new CartModel($this->db);
        $status = $cart->addToCart($user_id, $item_id, $item_quanity);

        return $status ? $response->withJson(['success' => true]) : $response->withJson(['error' => "something went wrong"], 500);
    }
}
