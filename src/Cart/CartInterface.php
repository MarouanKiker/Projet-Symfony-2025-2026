<?php
namespace App\Cart;

use App\Entity\Product;

interface CartInterface
{
    public function add(Product $product): void;
    public function remove(Product $product): void;
    public function getCart(): array;
    public function clear(): void;
}
