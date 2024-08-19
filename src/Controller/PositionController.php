<?php

namespace App\Controller;

use App\Entity\Position;
use App\Form\PositionType;
use App\Repository\PositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/position')]
class PositionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private PositionRepository $positionRepository
    ) {
    }

    #[Route('/')]
    public function index(
        Request $request,
        PaginatorInterface $paginator
    ): Response
    {
        $pagination = $paginator->paginate(
            $this->positionRepository->createQueryBuilder('p'),
            $request->query->getInt('page', 1),
            $request->query->getInt('size', 5)
        );

        return $this->render('position/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/details/{id}')]
    public function details(
        Request $request, 
        Position $position,
        Security $security,
    ): Response
    {
        $parameters['position'] = $position;

        if ($security->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(PositionType::class, $position);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($position);
                $this->em->flush();

                return $this->redirectToRoute('app_position_index');
            }

            $parameters['editForm'] = $form;
        }

        return $this->render('position/details.html.twig', $parameters);
    }

    #[Route('/create')]
    #[IsGranted('ROLE_ADMIN')]
    public function create(
        Request $request
    ): Response
    {
        $position = new Position();
        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($position);
            $this->em->flush();

            return $this->redirectToRoute('app_position_index');
        }

        return $this->render('position/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/api/positions')]
    #[IsGranted('ROLE_ADMIN')]
    public function getPositions(Request $request): JsonResponse
    {
        $name = $request->query->get('name', null); 

        if (!$name || empty(trim($name))) {
            return new JsonResponse(null);
        }

        $positions = $this->positionRepository->searchByName($name);

        $data = [];
        foreach ($positions as $position) {
            $data[] = [
                'id' => $position->getId(),
                'name' => $position->getName()
            ];
        }

        return new JsonResponse($data);
    }
}
