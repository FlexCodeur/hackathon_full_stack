<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LegalNoticeController extends AbstractController
{
    #[Route ("/mentions-legales", name:"legal_notice")]
    public function legalNotice()
    {
        return $this->render('pages/legalNotice.html.twig');
    }
}
