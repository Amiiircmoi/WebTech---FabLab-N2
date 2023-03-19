<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/b-y!M&e/dashboard/b-y!B&o', name: 'app_dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', []);
    }

    #[Route('/demandes', name: 'form_list')]
    public function formList(): Response
    {
        return $this->render('dashboard/form_list.html.twig', []);
    }
}
