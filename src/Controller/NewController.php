<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\Job;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class NewController extends AbstractController
{
    #[Route('/new', name: 'app_new')]
    public function index(): Response
    {
        $name = $this->getUser()->getFullName();
        $mail = $this->getUser()->getEmail();
        $admin = false;
        if($this->getUser() != null)
            $admin = in_array('ROLE_ADMIN', $this->getUser()->getRoles());
        return $this->render('new/index.html.twig', [
            'name' => $name,
            'mail' => $mail,
            'var' => 'new',
            'admin' => $admin,


        ]);
    }
    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $job = new Job();
        $job->setName($request->getPayload()->get('name'))
            ->setPrice((float)$request->getPayload()->get('price'))
            ->setDescription($request->getPayload()->get('description'))
            ->setMaster($this->getUser())
            ->setState('active');
        if($request->getPayload()->get('req1') !== '')
            $job->addExperience(
                $entityManager->getRepository(Experience::class)->addExperience($request->getPayload()->get('req1'), $request->getPayload()->get('req1y'))
            );
        if($request->getPayload()->get('req2') !== '')
            $job->addExperience(
                $entityManager->getRepository(Experience::class)->addExperience($request->getPayload()->get('req2'), $request->getPayload()->get('req2y'))
            );
        $entityManager->persist($job);
        $entityManager->flush();
        return $this->redirectToRoute('app_home');
    }
}
