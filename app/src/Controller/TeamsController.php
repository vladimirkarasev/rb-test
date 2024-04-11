<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teams", name="app_teams_")
 */
class TeamsController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/list.html.twig', [
            'teams' => $teamRepository->findAll()
        ]);
    }

    /**
     * @Route("/create/", name="create")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $teamEntity = new Team();
        $teamForm = $this->createForm(TeamType::class, $teamEntity);
        $teamForm->handleRequest($request);

        if ($teamForm->isSubmitted() && $teamForm->isValid()) {
            $doctrineManager = $this->getDoctrine()->getManager();
            $doctrineManager->persist($teamEntity);
            $doctrineManager->flush();
            return $this->redirectToRoute('app_teams_list');
        }

        return $this->render('team/create.html.twig', [
            'team_form' => $teamForm->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}/", name="delete")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request, TeamRepository $teamRepository, $id): Response
    {
        $team = $teamRepository->find($id);

        if ($team) {
            $doctrineManager = $this->getDoctrine()->getManager();
            $doctrineManager->remove($team);
            $doctrineManager->flush();
            return $this->redirectToRoute('app_teams_list');
        }

        return $this->render('team/not-found.html.twig');
    }
}
