<?php

/**
 * Système de Gestion de Tickets - Gestion des Tickets
 * Développé par Thierry Goutier
 * Framework Symfony 7.3
 */

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/ticket')]
#[IsGranted('ROLE_STAFF')]
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository, StatusRepository $statusRepository): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $ticketRepository->findBy([], ['openingDate' => 'DESC']),
            'statuses' => $statusRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket, StatusRepository $statusRepository): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
            'statuses' => $statusRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketType::class, $ticket, [
            'is_admin' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le ticket a été modifié avec succès !');
            return $this->redirectToRoute('app_ticket_index');
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update-status', name: 'app_ticket_update_status', methods: ['POST'])]
    public function updateStatus(
        Request $request,
        Ticket $ticket,
        EntityManagerInterface $entityManager,
        StatusRepository $statusRepository
    ): Response {
        $statusId = $request->request->get('status');
        $status = $statusRepository->find($statusId);

        if ($status) {
            $ticket->setStatus($status);
            
            // Si le statut est "Fermé", définir la date de clôture
            if ($status->getName() === 'Fermé') {
                $ticket->setClosingDate(new \DateTime());
            } else {
                $ticket->setClosingDate(null);
            }
            
            $entityManager->flush();
            $this->addFlash('success', 'Le statut du ticket a été mis à jour !');
        }

        return $this->redirectToRoute('app_ticket_show', ['id' => $ticket->getId()]);
    }
}
