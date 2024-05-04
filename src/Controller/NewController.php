<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewController extends AbstractController
{
    #[Route('/new', name: 'app_new')]
    public function index(): Response
    {
        return $this->render('new/index.html.twig', [
            'name' => 'jsp',
            'mail' => "idk",
            'home' => '',
            'history' => '',
            'message' => '',
            'new' => 'active'
        ]);
    }
}
