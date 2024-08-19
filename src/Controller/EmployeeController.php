<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/employee')]
class EmployeeController extends AbstractController
{
    #[Route('/')]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        EmployeeRepository $employeeRepository
    ): Response
    {
        $pagination = $paginator->paginate(
            $employeeRepository->allWithPositionsQueryBuilder(),
            $request->query->getInt('page', 1), 
            $request->query->getInt('size', 5)
        );

        return $this->render('employee/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/details/{id}')]
    public function details(
        Request $request,
        Employee $employee,
        EntityManagerInterface $em,
        Security $security
    ): Response
    {
        $parameters['employee'] = $employee;

        if ($security->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(EmployeeType::class, $employee);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $em->persist($employee);
                $em->flush();

                return $this->redirectToRoute('app_employee_index');
            }

            $parameters['editForm'] = $form;
        }

        return $this->render('employee/details.html.twig', $parameters);
    }
}
