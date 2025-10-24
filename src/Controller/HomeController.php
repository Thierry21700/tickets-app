<?php

/**
 * Système de Gestion de Tickets
 * Développé par Thierry Goutier
 * Framework Symfony 7.3
 */

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\CategoryRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository,
        StatusRepository $statusRepository
    ): Response {
        $ticket = new Ticket();
        
        // Récupérer le statut "Nouveau" par défaut
        $newStatus = $statusRepository->findOneBy(['name' => 'Nouveau']);
        if ($newStatus) {
            $ticket->setStatus($newStatus);
        }

        $form = $this->createForm(TicketType::class, $ticket, [
            'is_admin' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Votre ticket a été créé avec succès !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form,
        ]);
    }
}
