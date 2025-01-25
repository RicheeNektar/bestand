<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use App\Repository\RetailerRepository;
use App\Repository\SizeRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/manage', name: 'manage', methods: ['GET', 'POST'])]
final class ManageController extends AbstractController
{
    public function __construct(
        private readonly CategoryRepository     $categoryRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ItemRepository         $itemRepository,
        private readonly SizeRepository         $sizeRepository,
        private readonly RetailerRepository     $retailerRepository,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            foreach ([$this->retailerRepository, $this->categoryRepository, $this->sizeRepository] as $repo) {
                if (
                    preg_match(
                        '#\\\(\w+)$#i',
                        strtolower($repo->getClassName()),
                        $matches
                    )
                    && ($id = $request->request->getInt($matches[1])) > 0
                    && ($entity = $repo->find($id))
                ) {
                    $this->entityManager->remove($entity);
                    $this->entityManager->flush();
                }
            }
        }

        return $this->render(
            'manage.html.twig',
            [
                'categories' => $this->findAll($this->categoryRepository, 'category'),
                'retailers'  => $this->findAll($this->retailerRepository, 'retailer'),
                'sizes' => $this->findAll($this->sizeRepository, 'size'),
            ]
        );
    }

    private function findAll(ServiceEntityRepositoryInterface $repository, string $param): array
    {
        return array_map(
            fn ($entry) => [
                'referenced' => null !== $this->itemRepository->findOneBy([$param => $entry]),
                'id' => $entry->id,
                'name' => $entry->name,
            ],
            $repository->findAll()
        );
    }
}