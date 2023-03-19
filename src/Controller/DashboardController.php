<?php

namespace App\Controller;

use App\Entity\ContactForm;
use App\Entity\EventType;
use App\Form\EventTypeType;
use App\Repository\ContactFormRepository;
use App\Repository\EventTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/b-y!M&e/dashboard/b-y!B&o', name: 'app_dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ContactFormRepository $contactFormRepository): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'demandesAttentes' => $contactFormRepository->count(['status' => 0]),
            'demandesMensuelles' => $contactFormRepository->findLastMonthCount(),
            'demandesTraitees' => $contactFormRepository->count(['status' => 1]) / $contactFormRepository->count([]) * 100,
            'demandesTotales' => $contactFormRepository->count([]),
            'forms' => $contactFormRepository->findLastMonth(['status' => 0]),
        ]);
    }

    /*
    Demandes
    */

    #[Route('/demandes', name: 'form_list')]
    public function formList(ContactFormRepository $contactFormRepository): Response
    {
        return $this->render('dashboard/form/index.html.twig', [
            'forms' => $contactFormRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/demandes/{id}', name: 'form_show', methods: ['GET'])]
    public function formShow(ContactForm $contactForm): Response
    {
        return $this->render('dashboard/form/show.html.twig', [
            'form' => $contactForm,
        ]);
    }

    #[Route('/demandes/remove/{id}', name: 'form_delete', methods: ['POST'])]
    public function deleteForm(Request $request, ContactForm $contactForm, ContactFormRepository $contactFormRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactForm->getId(), $request->request->get('_token'))) {
            $contactFormRepository->remove($contactForm, true);
        }

        return $this->redirectToRoute('app_dashboard_form_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/demandes/{id}/status/{status}', name: 'form_status', methods: ['GET'])]
    public function formChangeStatus(ContactForm $contactForm, int $status, ContactFormRepository $contactFormRepository): Response
    {
        $contactForm->setStatus($status);
        $contactFormRepository->save($contactForm, true);

        return $this->redirectToRoute('app_dashboard_form_show', [
            'id' => $contactForm->getId(),
        ], Response::HTTP_SEE_OTHER);
    }

    /*
    Types d'événements
    */

    #[Route('/types-evenements', name: 'type_list')]
    public function typeList(EventTypeRepository $eventTypeRepository): Response
    {
        return $this->render('dashboard/event_type/index.html.twig', [
            'types' => $eventTypeRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/types-evenements/nouveau', name: 'type_new', methods: ['GET', 'POST'])]
    public function newType(Request $request, EventTypeRepository $eventTypeRepository): Response
    {
        $eventType = new EventType();
        $form = $this->createForm(EventTypeType::class, $eventType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventType->setPosition($eventTypeRepository->count([]) + 1);
            $eventTypeRepository->save($eventType, true);

            return $this->redirectToRoute('app_dashboard_type_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/event_type/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/types-evenements/{id}', name: 'type_edit', methods: ['GET', 'POST'])]
    public function editType(Request $request, EventType $eventType, EventTypeRepository $eventTypeRepository): Response
    {
        $form = $this->createForm(EventTypeType::class, $eventType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventTypeRepository->save($eventType, true);

            return $this->redirectToRoute('app_dashboard_type_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/event_type/edit.html.twig', [
            'eventType' => $eventType,
            'form' => $form,
        ]);
    }

    #[Route('/types-evenements/remove/{id}', name: 'type_delete', methods: ['POST'])]
    public function deleteType(Request $request, EventType $eventType, EventTypeRepository $eventTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventType->getId(), $request->request->get('_token'))) {
            $eventTypeRepository->remove($eventType, true);
        }

        return $this->redirectToRoute('app_dashboard_type_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/types-evenements/{id}/move/{direction}', name: 'type_move', methods: ['GET'])]
    public function moveType(EventType $eventType, string $direction, EventTypeRepository $eventTypeRepository): Response
    {
        $eventTypeRepository->move($eventType, $direction);

        return $this->redirectToRoute('app_dashboard_type_list', [], Response::HTTP_SEE_OTHER);
    }
}
