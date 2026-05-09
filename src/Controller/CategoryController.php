<?php
namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_category_browse', priority: 1)]
    public function browse(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/browse.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_products', priority: 1)]
    public function products(#[MapEntity] Category $category): Response
    {
        // on recup les produits de la categorie grace a doctrine
        return $this->render('category/products.html.twig', [
            'category' => $category,
            'products' => $category->getProducts()
        ]);
    }
}
