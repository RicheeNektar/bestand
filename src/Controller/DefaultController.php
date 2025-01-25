<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'index', methods: ['GET'])]
final class DefaultController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->redirectToRoute('items');
    }
}