<?php

namespace App\Entity;

use App\Repository\RetailerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetailerRepository::class)]
class Retailer
{
    public function __construct(
        #[
            ORM\Id,
            ORM\GeneratedValue,
            ORM\Column,
        ]
        public ?int $id = null,

        #[ORM\Column(length: 0xFF)]
        public string $name = '',
    ) {
    }

    #[
        ORM\OneToMany(
            targetEntity: Item::class,
            mappedBy: 'retailer',
            orphanRemoval: true,
        )
    ]
    public Collection $items;
}
