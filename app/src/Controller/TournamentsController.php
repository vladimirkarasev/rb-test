<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Tournaments;
use App\Form\TournamentType;
use App\Repository\TeamRepository;
use App\Repository\TournamentsRepository;
use App\Tournament\Meeting\TournamentMeeting;
use App\Tournament\TournamentGrid;
use App\Tournament\TournamentMatchesDay;
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
    public function deleteAction(
        Request        $request,
        TournamentsRepository $tournamentsRepository,
        string $id
    ): Response
    {
        $tournament = $tournamentsRepository->find($id);

        if ($tournament) {
            $doctrineManager = $this->getDoctrine()->getManager();
            $doctrineManager->remove($tournament);
            $doctrineManager->flush();
            return $this->redirectToRoute('app_tournaments_list');
        }

        return $this->render('tournaments/not-found.html.twig');
    }

    /**
     * @Route("/create/", name="create")
     * @param Request $request
     * @return Response
     */
    public function createAction(
        Request        $request,
        TeamRepository $teamRepository
    ): Response
    {
        $tournamentsEntity = new Tournaments($teamRepository);
        $tournamentsForm = $this->createForm(TournamentType::class, $tournamentsEntity);
        $tournamentsForm->handleRequest($request);

        if ($tournamentsForm->isSubmitted() && $tournamentsForm->isValid()) {
            $doctrineManager = $this->getDoctrine()->getManager();
            $doctrineManager->persist($tournamentsEntity);
            $doctrineManager->flush();

            return $this->redirectToRoute('app_tournaments_view', [
                'slug' => $tournamentsEntity->getSlug(),
            ]);
        }

        return $this->render('tournaments/create.html.twig', [
            'tournaments_form' => $tournamentsForm->createView()
        ]);
    }

    /**
     * @Route("/{slug}/", name="view")
     * @return Response
     */
    public function viewAction(TournamentsRepository $repository, string $slug): Response
    {
        $tournament = $repository->findOneBy(['slug' => $slug]);

        return $this->render('tournaments/view.html.twig', [
            'tournament' => $tournament,
            'tournament_grid' => new TournamentGrid($tournament->getTeams())
        ]);
    }
}
