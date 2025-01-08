<?php

namespace App\Repository;

use App\Entity\Item;
use App\Enum\ItemSortEnum;
use App\Enum\SortOrderEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    /** @return Item[] */
    public function search(string $query, ItemSortEnum $sortBy, SortOrderEnum $sortOrder): array
    {
        return $this
            ->createQueryBuilder('i')
            ->innerJoin('i.category', 'c')
            ->where('i.number LIKE :query')
            ->where('c.name LIKE :query')
            ->setParameter('query', "%$query%")
            ->orderBy("i.$sortBy->value", $sortOrder->value)
            ->getQuery()
            ->getResult();
    }
}
