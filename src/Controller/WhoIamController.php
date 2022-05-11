<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WhoIamController extends AbstractController
{
#[Route ("/qui-suis-je", name:'who_iam')]
    public function whoIam ()
    {
       return $this->render('pages/whoIam.html.twig');
    }
}