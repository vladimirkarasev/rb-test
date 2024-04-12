<?php

namespace App\Controller;

use App\Repository\TournamentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(TournamentsRepository $repository): Response
    {
        return $this->render('home.html.twig', [
            'tournaments' => $repository->findAll(),
        ]);
    }
}
