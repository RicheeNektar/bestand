<?php

namespace App\Controller\Items;

use App\Enum\ItemSortEnum;
use App\Enum\SortOrderEnum;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/items', name: 'items', methods: ['GET', 'POST'])]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly ItemRepository $itemRepository, private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $query = $request->query->getAlnum('query');

        $orderBy = ItemSortEnum::tryFrom($request->query->get('orderBy')) ?? ItemSortEnum::ID;
        $orderByDir = SortOrderEnum::tryFrom($request->query->get('orderByDir')) ?? SortOrderEnum::Ascending;

        $items = $this->itemRepository->search($query, $orderBy, $orderByDir);

        if (empty($items)) {
            return $this->redirectToRoute('items.manage');
        }

        if ($request->isMethod(Request::METHOD_POST)) {
            foreach ($request->request->all('quantity') as $id => $quantity) {
                if ($item = $this->itemRepository->find($id)) {
                    $item->quantity = $item->quantity + $quantity;
                }
            }
            $this->entityManager->flush();
        }

        return $this->render(
            'items/index.html.twig',
            [
                'query' => $query,
                'orderBy' => $orderBy,
                'orderByDir' => $orderByDir,
                'items' => $items,
            ]
        );
    }
}