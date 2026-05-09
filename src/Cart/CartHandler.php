<?php
namespace App\Cart;

use App\Entity\Product;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CartHandler
{
    private CartInterface $cartStrategy;

    public function __construct(#[Autowire(service: SessionCart::class)] CartInterface $cartStrategy)
    {
        $this->cartStrategy = $cartStrategy;
    }

    public function add(Product $product): void
    {
        $this->cartStrategy->add($product);
    }

    public function remove(Product $product): void
    {
        $this->cartStrategy->remove($product);
    }

    public function getCart(): array
    {
        return $this->cartStrategy->getCart();
    }

    public function clear(): void
    {
        $this->cartStrategy->clear();
    }
}
