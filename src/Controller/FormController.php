<?php

namespace App\Controller;

use App\Entity\ContactForm;
use App\Entity\ContactMail;
use App\Form\ContactFormType;
use App\Repository\ContactFormRepository;
use App\Repository\ContactMailRepository;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/contact', name: 'app_form', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactFormRepository $contactFormRepository, MailerInterface $mailerInterface, ContactMailRepository $contactMailRepository): Response
    {
        $contactForm = new ContactForm();
        $form = $this->createForm(ContactFormType::class, $contactForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormRepository->save($contactForm, true);

            // $contacts = $contactMailRepository->findAll();
            // foreach ($contacts as $contact) {
            //     $email = (new Email())
            //     ->from('anonymous.nope565@gmail.com')
            //     ->to($contact->getEmail())
            //     ->subject('Nouvelle demande de contact')
            //     ->text('Une nouvelle demande vient d\'arriver !');

            //     $mailerInterface->send($email);
            // }

            $this->addFlash('success', 'Votre message nous a bien été transféré !');
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('public/form.html.twig', [
            'contact_form' => $contactForm,
            'form' => $form,
        ]);
    }
}
