<?php
namespace App\Controller;

use App\Entity\Product;
use App\Cart\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class CartController extends AbstractController
{
    private CartHandler $cartHandler;

    public function __construct(CartHandler $cartHandler)
    {
        $this->cartHandler = $cartHandler;
    }

    // affiche le recap du panier
    public function index(): Response
    {
        $cart = $this->cartHandler->getCart();
        return $this->render('cart/index.html.twig', [
            'cart' => $cart
        ]);
    }

    // pour ajouter un produit, on recup la qte depuis le form
    #[Route('/cart/add/{id}', name: 'app_cart_add', priority: 1, methods: ['POST'])]
    public function add(#[MapEntity] Product $product, Request $request): Response
    {
        $quantity = $request->request->getInt('quantity', 1);
        $this->cartHandler->add($product, $quantity);
        $this->addFlash('success', 'Produit ajouté au panier avec succès !');
        
        return $this->redirectToRoute('app_cart_index');
    }
    
    // pour virer un produit du panier
    #[Route('/cart/remove/{id}', name: 'app_cart_remove', priority: 1, methods: ['GET', 'POST'])]
    public function remove(#[MapEntity] Product $product): Response
    {
        $this->cartHandler->remove($product);
        $this->addFlash('success', 'Produit retiré du panier.');
        
        return $this->redirectToRoute('app_cart_index');
    }
}
