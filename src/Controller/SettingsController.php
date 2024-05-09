<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\User;
use App\Repository\ExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
    public function index(ExperienceRepository $experienceRepository): Response
    {
        $name = $this->getUser()->getFullName();
        $mail = $this->getUser()->getEmail();
        $admin = false;
        if($this->getUser() != null)
            $admin = in_array('ROLE_ADMIN', $this->getUser()->getRoles());
        return $this->render('settings/index.html.twig', [
            'name' => $name,
            'mail' => $mail,
            'var' => 'settings',
            'admin' => $admin,
            'experience' => $this->getUser()->getExperience(),
            'exps'=> $experienceRepository->findexps()
        ]);
    }
    #[Route('/update', name: 'app_settings_update')]
    public function update(Request $request,  UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $user = $entityManager->getRepository(User::class)->find($user->getId());
        $user->setFullName($request->getPayload()->get('name'))
            ->setEmail($request->getPayload()->get('mail'));
        if($request->getPayload()->get('npwd')!==''){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $request->getPayload()->get('password')
                )
            );
        }
        for($i = 0; $i<4; $i++) {
            if($request->getPayload()->get("req$i")!==''){
                if(sizeof($user->getExperience())>=$i){
                    $user->removeExperience(
                        $user->getExperience()[$i]
                    );
                }
                $user->addExperience(
                    $entityManager->getRepository(Experience::class)->addExperience($request->getPayload()->get("req$i"), $request->getPayload()->get("req${i}y"))
                );
            }
        }
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_home');
    }
}
