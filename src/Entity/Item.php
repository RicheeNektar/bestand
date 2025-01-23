<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    public function __construct(
        #[
            ORM\Id,
            ORM\GeneratedValue,
            ORM\Column,
        ]
        public ?int $id = null,

        #[ORM\Column(length: 256)]
        public ?string $name = null,

        #[ORM\Column(length: 2 ** 24)]
        public ?string $description = null,

        #[ORM\Column(length: 256)]
        public ?string $number = null,

        #[
            ORM\ManyToOne,
            ORM\JoinColumn(nullable: false),
        ]
        public ?Category $category = null,

        #[ORM\Column(length: 32)]
        public ?string $size = null,

        #[ORM\Column(length: 256)]
        public ?string $retailer = null,

        #[ORM\Column]
        public float $price = 0,

        #[ORM\Column]
        public int $quantity = 0,

        #[ORM\Column(length: 2 ** 24)]
        public string $image = '',

        #[ORM\Column(length: 256)]
        public ?string $imageType = null,
    ) {
    }
}
