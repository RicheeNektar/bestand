<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/categories', name: 'categories.manage', methods: ['GET', 'POST'])]
final class CategoryController extends AbstractController
{
    public function __construct(
        private readonly CategoryRepository     $categoryRepository,
        private readonly EntityManagerInterface $entityManager, private readonly ItemRepository $itemRepository,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            if (
                ($id = $request->request->getInt('delete'))
                && $category = $this->categoryRepository->find($id)
            ) {
                $this->entityManager->remove($category);
                $this->entityManager->flush();

            } elseif (
                $request->request->getBoolean('add')
                && $name = $request->request->getAlnum('name')
            ) {
                $this->entityManager->persist(new Category(name: $name));
                $this->entityManager->flush();
            }
        }

        return $this->render(
            'categories.html.twig',
            [
                'categories' => array_map(
                    fn ($category) => [
                        'referenced' => null !== $this->itemRepository->findOneBy(['category' => $category]),
                        'id' => $category->id,
                        'name' => $category->name,
                    ],
                    $this->categoryRepository->findAll()
                ),
            ]
        );
    }
}