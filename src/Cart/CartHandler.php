<?php
namespace App\Cart;

use App\Entity\Product;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CartHandler
{
    private CartInterface $cartStrategy;

    private \App\Repository\ProductRepository $productRepository;

    public function __construct(
        #[Autowire(service: SessionCart::class)] CartInterface $cartStrategy,
        \App\Repository\ProductRepository $productRepository
    ) {
        $this->cartStrategy = $cartStrategy;
        $this->productRepository = $productRepository;
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $this->cartStrategy->add($product, $quantity);
    }

    public function remove(Product $product): void
    {
        $this->cartStrategy->remove($product);
    }

    // on recupere tout ce qu il y a dans le panier
    public function getCart(): array
    {
        $rawCart = $this->cartStrategy->getCart();
        $items = [];
        $total = 0;

        // on boucle pour hydrater les produits et calculer le prix total
        foreach ($rawCart as $id => $quantity) {
            $product = $this->productRepository->find($id);
            if ($product) {
                $itemTotal = $product->getPrice() * $quantity;
                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'total' => $itemTotal
                ];
                $total += $itemTotal;
            }
        }

        return [
            'items' => $items,
            'total' => $total
        ];
    }

    public function clear(): void
    {
        $this->cartStrategy->clear();
    }
}
