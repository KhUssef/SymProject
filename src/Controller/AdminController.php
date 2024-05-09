<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $name = $this->getUser()->getFullName();
        $mail = $this->getUser()->getEmail();
        $users = $entityManager->getRepository(User::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'var' =>'admin',
            'users'=> $users,
            'admin' => true,
            'name' => $name,
            'mail' => $mail,
        ]);
    }
    #[Route('/user/{id}', name: 'app_admin_user')]
    public function user($id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setRoles(['ROLE_ADMIN']);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }
    #[Route('/delete/{id}', name: 'app_admin_user_delete')]
    public function userDelete($id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }
}
