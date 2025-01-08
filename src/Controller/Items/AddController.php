<?php

namespace App\Controller\Items;

use App\Entity\Item;
use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/items/add', name: 'items.add', methods: ['GET','POST'])]
final class AddController extends AbstractController
{
    public function __construct(
        private readonly ItemRepository $itemRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $data = $request->request->all();

            $rows = count($data['number'] ?? []);
            $toDelete = count($data['delete'] ?? []);

            try {
                $this->em->beginTransaction();

                for ($i = 0; $i < $toDelete; $i++) {
                    if ($item = $this->itemRepository->findOneBy(['number' => $data['number'][$i]])) {
                        $this->em->remove($item);
                    }
                }

                for ($i = 0; $i < $rows; $i++) {
                    $item = $this->itemRepository->findOneBy(['number' => $data['number'][$i]]);

                    if ($item) {
                        $item->quantity += (int) $data['quantity'][$i];
                    } else {
                        $this->em->persist(
                            new Item(
                                number: $data['number'][$i],
                                image: $data['image'][$i],
                                quantity: (int) $data['quantity'][$i],
                                category: $this->categoryRepository->find($data['category'][$i]),
                                size: $data['size'][$i],
                                price: (float) $data['price'][$i],
                            )
                        );
                    }
                }

                $this->em->commit();
                $this->em->flush();

                return $this->redirectToRoute('items.list');
            } catch (\Throwable $e) {
                $this->em->rollback();
            }
        }

        return $this->render(
            'items/add.html.twig',
            [
                'categories' => $this->categoryRepository->findAll(),
                'data' => $this->itemRepository->findAll(),
                'e' => $e ?? null,
            ],
        );
    }
}