<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
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
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TeamsController.php',
        ]);
    }

    /**
     * @Route("/create/", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
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
}
