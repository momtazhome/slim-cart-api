<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Lib\UserModel;
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

// for authentication
$auth_middleware = function(Request $request, Response $response, $next) {
    $token = $request->getHeader('HTTP_X_TOKEN');
    if(!empty($token))
        $token = $token[0];
    $user = new UserModel($this->get('db'));
    $user->initWithToken($token);
    if(!$user->getDetails()) {
        return $response->withJson(['error' => 'Invalid Auth'], 403);
    }

    $response = $next($request, $response);

    return $response;
};
