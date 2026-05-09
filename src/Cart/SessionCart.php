<?php
namespace App\Cart;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionCart implements CartInterface
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        
        $id = $product->getId();
        if (!empty($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }

        $session->set('cart', $cart);
    }

    public function remove(Product $product): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        
        $id = $product->getId();
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);
    }

    public function getCart(): array
    {
        $session = $this->requestStack->getSession();
        return $session->get('cart', []);
    }

    public function clear(): void
    {
        $session = $this->requestStack->getSession();
        $session->remove('cart');
    }
}
