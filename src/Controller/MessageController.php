<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController
{
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
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
        return $this->render('message/index.html.twig', [
            'var' => 'message',
            'admin' => $admin,
            'name' => $name,
            'mail' => $mail
        ]);
    }
    #[Route('/email', name: 'app_email')]
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {
//        $email = (new Email())
//            ->from($request->getPayload()->get('email'))
//            ->to('tempaltemp31@gmail.com')
//            ->subject('Time for Symfony Mailer!')
//            ->text('Sending emails is fun again!');
//        $mailer->send($email);
        return $this->render("message/thankyou.html.twig");
    }
}
