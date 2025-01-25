<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/image/{id<\d+>}', name: 'images.get', methods: [Request::METHOD_GET])]
final class ImageController extends AbstractController
{
    public function __construct(
        private readonly ImageRepository $imageRepository,
    ) {
    }

    public function __invoke(int $id): Response
    {
        return new Response(base64_decode($this->imageRepository->find($id)?->data));
    }
}