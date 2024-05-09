<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\User;
use App\Repository\ExperienceRepository;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function index(Request $request,JobRepository $jobRepository, EntityManagerInterface $entityManager, ExperienceRepository $experienceRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $k = $request->query->all();
        $k = array_slice($k, 1, count($k)-1);
        if($k == null and $this->getUser() != null){
            $k = $this->getUser()->getExperienceArray();
            $jobs = $jobRepository->findAll();
        }else if($k != null){
            $jobs = $jobRepository->findByFilters($k, $entityManager->getRepository('App\Entity\Experience'));
        }else{
            $jobs = $jobRepository->findAll();
        }
        if($this->getUser() == null){
            $name = 'Guest';
            $mail = '';
        }else{
            $name = $this->getUser()->getFullName();
            $mail = $this->getUser()->getEmail();
        }
        $admin = false;
        if($this->getUser() != null)
            $admin = in_array('ROLE_ADMIN', $this->getUser()->getRoles());
        return $this->render('home/index.html.twig', [
            'name' => $name,
            'mail' => $mail,
            'var' => 'home',
            'jobs' => $jobs,
            'exps' => $experienceRepository->findexps(),
            'filters' => $k,
            'admin' => $admin
        ]);
    }
    #[Route('/', name: 'default')]
    public function default(JobRepository $jobRepository): Response
    {
        return $this->redirect('/home');
    }
    #[Route('/details/{id?0}', name: 'app_details')]
    public function details(JobRepository $jobRepository, $id): Response
    {
        $name = $this->getUser()->getFullName();
        $mail = $this->getUser()->getEmail();
        $job = $jobRepository->find($id);
        if($job==null){
            $this->forward('App\Controller\HomeController::index');
        }
        $admin = false;
        if($this->getUser() != null)
            $admin = in_array('ROLE_ADMIN', $this->getUser()->getRoles());
        return $this->render('home/details.html.twig', [
            'job' => $jobRepository->find($id),
            'name' => $name,
            'mail' => $mail,
            'admin' => $admin,
            'id' => $this->getUser()->getId(),
            'var' =>''
        ]);
    }
    #[Route('/apply/{id}', name: 'apply')]
    public function apply($id, EntityManagerInterface $entityManager) : Response
    {
        $job = $entityManager->getRepository(Job::class)->find($id);
        $user1 = $this->getUser();
        $user = $entityManager->getRepository(User::class)->find($user1->getId());
        if($job!=null && $user->getId()!= $job->getMaster()->getId()) {
            $job->addApplicant($user);
            $entityManager->flush();
        }
        return $this->forward('App\Controller\HomeController::index');
    }

    #[Route("/pdf/{id}", name: "generate_pdf")]
    public function generatePdf(JobRepository $jobRepository, $id): Response
    {
        // Create a new Dompdf instance
        $dompdf = new Dompdf();
        $job = $jobRepository->find($id);

        // Render the HTML content into PDF
        $html = $this->renderView('home/details-pdf.html.twig', [
            // Pass any necessary data to your template
            'job' => $jobRepository->find($id),
        ]);
        $dompdf->loadHtml($html);

        // (Optional) Set the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Output the generated PDF to browser
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }

}
