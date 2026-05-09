<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', priority: 1)]
    public function index(\App\Repository\ProductRepository $productRepository): Response
    {
        // on prend tous les produits pour l accueil
        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }
}
