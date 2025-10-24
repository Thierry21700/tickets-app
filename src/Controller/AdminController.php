<?php

/**
 * Système de Gestion de Tickets - Administration
 * Développé par Thierry Goutier
 * Framework Symfony 7.3
 */

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Status;
use App\Entity\Responsible;
use App\Form\CategoryType;
use App\Form\StatusType;
use App\Form\ResponsibleType;
use App\Repository\CategoryRepository;
use App\Repository\StatusRepository;
use App\Repository\ResponsibleRepository;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(TicketRepository $ticketRepository, StatusRepository $statusRepository): Response
    {
        // Récupérer les statistiques des tickets
        $totalTickets = count($ticketRepository->findAll());
        
        // Compter les tickets par statut
        $nouveauxCount = count($ticketRepository->findByStatus($statusRepository->findOneBy(['name' => 'Nouveau'])));
        $ouvertsCount = count($ticketRepository->findByStatus($statusRepository->findOneBy(['name' => 'Ouvert'])));
        $resolusCount = count($ticketRepository->findByStatus($statusRepository->findOneBy(['name' => 'Résolu'])));
        $fermesCount = count($ticketRepository->findByStatus($statusRepository->findOneBy(['name' => 'Fermé'])));
        
        return $this->render('admin/index.html.twig', [
            'totalTickets' => $totalTickets,
            'nouveauxCount' => $nouveauxCount,
            'ouvertsCount' => $ouvertsCount,
            'resolusCount' => $resolusCount,
            'fermesCount' => $fermesCount,
        ]);
    }

    // Gestion des catégories
    #[Route('/category', name: 'app_admin_category_index', methods: ['GET'])]
    public function categoryIndex(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/new', name: 'app_admin_category_new', methods: ['GET', 'POST'])]
    public function categoryNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été créée avec succès !');
            return $this->redirectToRoute('app_admin_category_index');
        }

        return $this->render('admin/category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/category/{id}/edit', name: 'app_admin_category_edit', methods: ['GET', 'POST'])]
    public function categoryEdit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été modifiée avec succès !');
            return $this->redirectToRoute('app_admin_category_index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/category/{id}', name: 'app_admin_category_delete', methods: ['POST'])]
    public function categoryDelete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
            $this->addFlash('success', 'La catégorie a été supprimée avec succès !');
        }

        return $this->redirectToRoute('app_admin_category_index');
    }

    // Gestion des statuts
    #[Route('/status', name: 'app_admin_status_index', methods: ['GET'])]
    public function statusIndex(StatusRepository $statusRepository): Response
    {
        return $this->render('admin/status/index.html.twig', [
            'statuses' => $statusRepository->findAll(),
        ]);
    }

    #[Route('/status/new', name: 'app_admin_status_new', methods: ['GET', 'POST'])]
    public function statusNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($status);
            $entityManager->flush();

            $this->addFlash('success', 'Le statut a été créé avec succès !');
            return $this->redirectToRoute('app_admin_status_index');
        }

        return $this->render('admin/status/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/status/{id}/edit', name: 'app_admin_status_edit', methods: ['GET', 'POST'])]
    public function statusEdit(Request $request, Status $status, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le statut a été modifié avec succès !');
            return $this->redirectToRoute('app_admin_status_index');
        }

        return $this->render('admin/status/edit.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    #[Route('/status/{id}', name: 'app_admin_status_delete', methods: ['POST'])]
    public function statusDelete(Request $request, Status $status, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$status->getId(), $request->request->get('_token'))) {
            $entityManager->remove($status);
            $entityManager->flush();
            $this->addFlash('success', 'Le statut a été supprimé avec succès !');
        }

        return $this->redirectToRoute('app_admin_status_index');
    }

    // Gestion des responsables
    #[Route('/responsible', name: 'app_admin_responsible_index', methods: ['GET'])]
    public function responsibleIndex(ResponsibleRepository $responsibleRepository): Response
    {
        return $this->render('admin/responsible/index.html.twig', [
            'responsibles' => $responsibleRepository->findAll(),
        ]);
    }

    #[Route('/responsible/new', name: 'app_admin_responsible_new', methods: ['GET', 'POST'])]
    public function responsibleNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $responsible = new Responsible();
        $form = $this->createForm(ResponsibleType::class, $responsible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($responsible);
            $entityManager->flush();

            $this->addFlash('success', 'Le responsable a été créé avec succès !');
            return $this->redirectToRoute('app_admin_responsible_index');
        }

        return $this->render('admin/responsible/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/responsible/{id}/edit', name: 'app_admin_responsible_edit', methods: ['GET', 'POST'])]
    public function responsibleEdit(Request $request, Responsible $responsible, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResponsibleType::class, $responsible);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le responsable a été modifié avec succès !');
            return $this->redirectToRoute('app_admin_responsible_index');
        }

        return $this->render('admin/responsible/edit.html.twig', [
            'responsible' => $responsible,
            'form' => $form,
        ]);
    }

    #[Route('/responsible/{id}', name: 'app_admin_responsible_delete', methods: ['POST'])]
    public function responsibleDelete(Request $request, Responsible $responsible, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$responsible->getId(), $request->request->get('_token'))) {
            $entityManager->remove($responsible);
            $entityManager->flush();
            $this->addFlash('success', 'Le responsable a été supprimé avec succès !');
        }

        return $this->redirectToRoute('app_admin_responsible_index');
    }
}
