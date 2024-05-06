<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\User;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    public function index(): Response
    {
        $jobs = $this->getUser()->getjob();
        $name = $this->getUser()->getFullName();
        $mail = $this->getUser()->getEmail();
        return $this->render('history/index.html.twig', [
            'name' => $name,
            'mail' => $mail,
            'var' => 'history',
            'admin' => in_array('ROLE_ADMIN', $this->getUser()->getRoles()),
            'jobs' => $jobs
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, EntityManagerInterface $entityManager) : Response
    {
        $job = $entityManager->getRepository(Job::class)->find($id);
        if($job!=null && ($this->getUser()->getId() == $job->getMaster()->getId() || in_array('ROLE_ADMIN', $this->getUser()->getRoles()))) {
            $entityManager->remove($job);
            $entityManager->flush();
        }
        return $this->forward('App\Controller\HomeController::index');
    }
    #[Route('/applicants/{id}', name: 'applicants')]
    public function show($id, JobRepository $jobRepository): Response
    {
        $job = $jobRepository->find($id);
        $name = $this->getUser()->getFullName();
        $mail = $this->getUser()->getEmail();
        if($job!=null && ($this->getUser()->getId() == $job->getMaster()->getId() || in_array('ROLE_ADMIN', $this->getUser()->getRoles()))){
            return $this->render('history/applicant.html.twig', [
                'job' => $job,
                'admin' => in_array('ROLE_ADMIN', $this->getUser()->getRoles()),
                'var' => '',
                'name' => $name,
                'mail' => $mail
            ]);
        }else{
            return $this->forward("App\Controller\HomeController::index");
        }
    }
    #[Route('/accept/{jid}/{uid}', name: 'accept')]
    public function accept($jid, $uid, EntityManagerInterface $entityManager): Response
    {
        $job = $entityManager->getRepository(Job::class)->find($jid);
        $user = $entityManager->getRepository(User::class)->find($uid);
        if($job!=null && ($this->getUser()->getId() == $job->getMaster()->getId() || in_array('ROLE_ADMIN', $this->getUser()->getRoles())) && $uid!=null){
            $job->setState('inactive')->setEmployee($user)->removeAllApplicants();
            $entityManager->flush();
        }
        return $this->forward('App\Controller\HistoryController::index');
    }
}
