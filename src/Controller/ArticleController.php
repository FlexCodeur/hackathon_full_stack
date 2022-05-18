<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentType;
use App\Model\TimeInterface;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]

class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/{slug}', name: 'app_article_show', methods: ['GET', 'POST'])]
    public function show($slug,
                         ArticleRepository $articleRepository,
                         CategoryRepository $categoryRepository,
                         Request $request,
                         EntityManagerInterface $entityManager
    ): Response
    {

        $article = $articleRepository->findOneBy([
            'slug' => $slug
        ]);
        if(!$article) {
            return $this->redirectToRoute('app_article_index');
        }
        $user = $this->getUser();
        $comment = new Comment();

        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
//        $comment->setContent();


        if($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setArticle($article);
            $comment->setUser($user);
            $comment->setCreatedAt(new \DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', "Votre commentaire a bien été publié.");
            return $this->redirectToRoute('app_article_show', [
                'slug' => $slug
            ]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'categories' => $categoryRepository->findAll(),
            'commentForm' => $commentForm->createView()
        ]);
    }
}
