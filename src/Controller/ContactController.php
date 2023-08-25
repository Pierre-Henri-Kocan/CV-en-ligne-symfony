<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();

            $name = $contact->getName();
            $to = $contact->getEmail();
            $subject = 'Accusé de réception : ' . $contact->getSubject();
            $message = 'Merci ' . $name . ' pour votre message.' . PHP_EOL . PHP_EOL . 'Je reviens vers vous dans les meilleurs délais concernant votre demande : ' . PHP_EOL . PHP_EOL . $contact->getMessage();
            $headers = 'From: contact@pierre-henri-kocan.com' . "\r\n" . 'Bcc: ph.kocan@icloud.com';

            mail($to, mb_encode_mimeheader($subject), $message, $headers);

            // $email = (new TemplatedEmail())
            // ->from('ph.kocan@gmail.com')
            // ->to($contact->getEmail())
            // ->subject($contact->getSubject())

            // ->htmlTemplate('emails/receipt.html.twig')

            // ->context([
            //     'contact' => $contact,
            // ]);

            // $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
