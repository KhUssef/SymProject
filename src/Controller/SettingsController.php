<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
    public function index(): Response
    {
        if($this->getUser() == null){
            $name = 'Guest';
            $mail = '';
        }else{
            $name = $this->getUser()->getFullName();
            $mail = $this->getUser()->getEmail();
        }
        return $this->render('settings/index.html.twig', [
            'name' => $name,
            'mail' => $mail,
            'var' => 'settings'
        ]);
    }
}
