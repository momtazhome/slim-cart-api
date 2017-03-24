<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface as ContainerInterface;
use App\Lib\UserModel;
use App\Lib\ItemModel;
use App\Lib\CartModel;

class CartController{

    private $db = null;
    const PAGE_LIMIT = 10;

    public function __construct(ContainerInterface $container) {
      $this->db = $container->get('db');
    }

    /**
     * Gives the user details of the cart owner
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
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

    /**
     * Gets all the items in the cart,
     *      GET param "offset" the timestamp. Gives all items added before this.
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     */
    public function getItems(Request $request, Response $response, $args) {
        $user_id = (int)$args['user_id'];
        if(empty($user_id))
            return $response->withJson(['error' => 'Invalid request'], 400);

        $query_params = $request->getQueryParams();
        $offset = !empty($query_params['offset']) ? $query_params['offset'] : null;

        $cart = new CartModel($this->db);
        $items = $cart->getItems($user_id, self::PAGE_LIMIT, $offset);

        return $response->withJson(['items' => $items]);
    }

    /**
     * For updating the quantity of an existing item in the cart
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     */
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
        list($status, $error) = $cart->modifyCart($user_id, $item_id, $item_quanity);

        return $status ? $response->withJson(['success' => true]) : $response->withJson(['error' => $error ?: "something went wrong"], 500);
    }

    /**
     * Removing an already exiting item from the cart
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     */
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
        list($status, $error) = $cart->remvoveFromCart($user_id, $item_id);

        return $status ? $response->withJson(['success' => true]) : $response->withJson(['error' => $error ?: "something went wrong"], 500);
    }

    /**
     * Adding an item in the cart
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     */
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
        list($status, $error) = $cart->addToCart($user_id, $item_id, $item_quanity);

        return $status ? $response->withJson(['success' => true]) : $response->withJson(['error' => $error ?: "something went wrong"], 500);
    }
}
