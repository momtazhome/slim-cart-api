<?php

// Routes for v1 version

$app->group('/v1', function() use ($app) {

    // add an item to the cart
    // POST "/cart/{user_id}/add" and POST data as the item details
    $app->post('/cart/{user_id}/add', 'App\Controller\CartController:addToCart');

        // removing the item from the cart
    // DELETE "/cart/{user_id}/remove" item id in the body
    $app->post('/cart/{user_id}/remove', 'App\Controller\CartController:removeFromCart');

    // updating the quantity of an item in the cart
    // PUT "cart/{user_id}/update" item id and new quantity in the body
    $app->post('/cart/{user_id}/update', 'App\Controller\CartController:updateCart');

    // getting all the items in the cart
    // GET "cart/{user_id}/get/items"
    $app->get('/cart/{user_id}/get/items', 'App\Controller\CartController:getItems');

    // getting user information - billing address from the cart
    // GET "cart/{user_id}/get/user"
    $app->get('/cart/{user_id}/get/user', 'App\Controller\CartController:getUser');


});