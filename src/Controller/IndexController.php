<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }

    #[Route('/form', name: 'app_form')]
    public function form(): Response
    {
        return $this->render('form.html.twig', []);
    }
}
