<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, EntityManagerInterface $manager, MailerInterface $mailer ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType:: class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            // Email
            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('tmariama84@gmail.com')
            ->subject($contact->getSujet())
            ->htmlTemplate('emails/contact.html.twig')

            // pas variables (name => value) to the template

            ->context([
             'contact' => $contact 
            ]);
           

            $mailer->send($email);

            $manager->persist($contact);
            $manager->flush(); 


            $this->addFlash(
                'success',
                'your request has been modified successfully !'
            );

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
