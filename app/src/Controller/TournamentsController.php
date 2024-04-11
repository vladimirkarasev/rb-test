<?php

namespace App\Controller;

use App\Repository\TournamentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tournaments", name="app_tournaments_")
 */
class TournamentsController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function indexAction(TournamentsRepository $repository): Response
    {
        return $this->render('tournaments/list.html.twig', [
            'tournaments' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/delete/{id}/", name="delete")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        return $this->render('tournaments/create.html.twig');
    }

    /**
     * @Route("/create/", name="create")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        return $this->render('tournaments/create.html.twig');
    }
}
