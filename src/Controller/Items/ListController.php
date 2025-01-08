<?php

namespace App\Controller\Items;

use App\Enum\ItemSortEnum;
use App\Enum\SortOrderEnum;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/items', name: 'items.list', methods: ['GET'])]
final class ListController extends AbstractController
{
    public function __construct(
        private readonly ItemRepository $itemRepository,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $query = $request->query->getAlnum('query');

        $orderBy = ItemSortEnum::tryFrom($request->query->get('orderBy')) ?? ItemSortEnum::Number;
        $orderByDir = SortOrderEnum::tryFrom($request->query->get('orderByDir')) ?? SortOrderEnum::Ascending;

        $items = $this->itemRepository->search($query, $orderBy, $orderByDir);

        return $this->render(
            'items/list.html.twig',
            [
                'query' => $query,
                'orderBy' => $orderBy,
                'orderByDir' => $orderByDir,
                'items' => $items,
            ]
        );
    }
}