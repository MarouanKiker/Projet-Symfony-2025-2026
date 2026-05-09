<?php
namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product_details', priority: 1)]
    public function details(#[MapEntity] Product $product): Response
    {
        if (!$product) {
            throw $this->createNotFoundException('Produit introuvable');
        }

        return $this->render('product/details.html.twig', [
            'product' => $product,
        ]);
    }
}
