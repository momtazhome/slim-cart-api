<?php

// Routes

// add an item to the cart
// POST "/cart/{user_id}/add" and POST data as the item details
$app->post('/cart/{user_id}/add', 'CartController:addToCart');

// removing the item from the cart
// DELETE "/cart/{user_id}/remove" item id in the body
$app->post('/cart/{user_id}/remove', 'CartController:removeFromCart');

// updating the quantity of an item in the cart
// PUT "cart/{user_id}/update" item id and new quantity in the body
$app->post('/cart/{user_id}/update', 'CartController:updateCart');

// getting all the items in the cart
// GET "cart/{user_id}/get/items"
$app->get('/cart/{user_id}/get/items', 'CartController:getItems');

// getting user information - billing address from the cart
// GET "cart/{user_id}/get/user"
$app->get('/cart/{user_id}/get/user', 'CartController:getUser');
