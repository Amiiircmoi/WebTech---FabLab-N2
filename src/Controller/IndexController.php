<?php

namespace App\Controller;

use App\Repository\ContactFormRepository;
use App\Repository\EventTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EventTypeRepository $eventTypeRepository): Response
    {
        return $this->render('public/index.html.twig', [
            'eventTypes' => $eventTypeRepository->findBy([], ['position' => 'ASC']),
        ]);
    }
}
