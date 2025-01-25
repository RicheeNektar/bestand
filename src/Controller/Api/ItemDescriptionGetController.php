<?php

namespace App\Controller\Api;

use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ItemDescriptionGetController extends AbstractController
{
    #[Route(path: '/api/item/{id<\d+>}/description', name: 'api.item.description', methods: ['GET'])]
    public function __invoke(Item $item): Response
    {
        return new Response($item->description);
    }
}