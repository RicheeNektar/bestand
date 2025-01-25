<?php

namespace App\Controller\Api;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/item/{item<\d+>}/description', name: 'api.item.description.save', methods: ['POST'])]
final class ItemDescriptionSaveController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Item $item, Request $request): Response
    {
        $item->description = $request->get('description');
        $this->entityManager->persist($item);
        $this->entityManager->flush();
        return $this->json([]);
    }
}