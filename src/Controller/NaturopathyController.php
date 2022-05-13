<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NaturopathyController extends AbstractController
{
#[Route ("/la-naturopathie", name:"naturopathy")]
    public function naturopathy()
    {
    return $this->render('pages/naturopathy.html.twig');
    }
}