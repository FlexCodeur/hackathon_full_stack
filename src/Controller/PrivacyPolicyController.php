<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PrivacyPolicyController extends AbstractController
{
    #[Route ("/politique-de-confidentialité", name:"privacy_policy")]
    public function privacyPolicy()
    {
        return $this->render('pages/PrivacyPolicy.html.twig');
    }
}
