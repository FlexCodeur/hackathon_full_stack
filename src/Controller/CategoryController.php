<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Category1Type;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
//    #[Route('/', name: 'app_category_index', methods: ['GET'])]
//    public function index(EntityManagerInterface $entityManager): Response
//    {
//        $categories = $entityManager
//            ->getRepository(Category::class)
//            ->findAll();
//
//        return $this->render('category/index.html.twig', [
//            'categories' => $categories,
//        ]);
//    }


    #[Route('/{slug}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category, CategoryRepository
    $categoryRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'categories' => $categoryRepository->findAll(),
            'articles' => $articleRepository->findAll()
        ]);
    }
}
