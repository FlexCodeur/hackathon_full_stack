<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Media;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="build/assets/images/nicolas-guidoux-naturopathe-iridologue-logo.png" style="width: 100px"> Administration')
            ->disableDarkMode();
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('build/assets/css/app.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Aller sur le site', 'fa fa-undo', "home");
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::subMenu('Catégorie', 'fa-solid fa-code-fork')
                ->setSubItems([
                    MenuItem::linkToCrud('Catégories', 'fas fa-list',
                        Category::class),
                    MenuItem::linkToCrud('Ajouter une catégorie', 'fas fa-plus',
                        Category::class)->setAction(Crud::PAGE_NEW)
                ]);
            }

        if ($this->isGranted('ROLE_EDITOR')) {
            yield MenuItem::subMenu('Blog', 'fas fa-newspaper')->setSubItems([
                MenuItem::linkToCrud('Articles', 'fas fa-list',
                    Article::class),
                MenuItem::linkToCrud('Ajouter un article', 'fas fa-plus',
                    Article::class)->setAction(Crud::PAGE_NEW)
            ]);

            yield MenuItem::subMenu('Média', 'fa-solid fa-image')->setSubItems([
                MenuItem::linkToCrud('Médiathèque', 'fa-solid fa-images',
                    Media::class),
                MenuItem::linkToCrud('Ajouter un média', 'fas fa-plus',
                    Media::class)->setAction(Crud::PAGE_NEW)
            ]);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::subMenu('Utilisateurs', 'fas fa-user')
                ->setSubItems([
                    MenuItem::linkToCrud('Liste des utilisateurs', 'fas fa-user-friends',
                        User::class),
                    MenuItem::linkToCrud('Ajouter un utilisateur', 'fas fa-plus',
                        User::class)->setAction(Crud::PAGE_NEW)
                ]);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::subMenu('Commentaires', 'fas fa-comment')
                ->setSubItems([
                    MenuItem::linkToCrud('Liste des commentaires', 'fa-solid fa-comments',
                        Comment::class)
                ]);
        }
    }
}
