<?php
require_once(BASE_PATH . 'dal/dal.php');
function addProductToCart($product)
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();

    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $found = false;
    for ($i = 0; $i < count($cart); $i++) {
        if ($cart[$i]['product']['id'] === $product['id']) {
            $cart[$i]['quantity'] += 1;
            $found = true;
        }
    }
    if (!$found) {
        array_push($cart, ['product' => $product, 'quantity' => 1]);
    }
    $_SESSION['cart'] = $cart;
}

function minusProductToCart($product)
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();

    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    for ($i = 0; $i < count($cart); $i++) {
        if ($cart[$i]['product']['id'] === $product['id'] && $cart[$i]['quantity'] != 1) {
            $cart[$i]['quantity'] -= 1;
        }
    }
    $_SESSION['cart'] = $cart;
}

function removeProduct($product)
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();

    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    for ($i = 0; $i < count($cart); $i++) {
        if ($cart[$i]['product']['id'] === $product['id']) {
            array_splice($cart, $i, 1);
        }
    }
    $_SESSION['cart'] = $cart;
}

function getSubTotal()
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();

    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $subtotal = 0;
    for ($i = 0; $i < count($cart); $i++) {
        $price = $cart[$i]['product']['price'] - ($cart[$i]['product']['price'] * $cart[$i]['product']['discount']);
        $subtotal += $price * $cart[$i]['quantity'];
    }
    return $subtotal;
}

function getShipping()
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();

    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $shipping = 0;
    for ($i = 0; $i < count($cart); $i++) {
        $shipping += $cart[$i]['quantity'];
    }
    $shipping *= 2;
    return $shipping;
}

function getTotal()
{
    return getShipping() + getSubTotal();
}

function getCart()
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();

    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    return $cart;
}