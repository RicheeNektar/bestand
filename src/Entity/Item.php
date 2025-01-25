<?php

namespace App\Entity;

use App\Repository\ItemRepository;
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

        #[ORM\Column(length: 0xFF)]
        public ?string $name = null,

        #[ORM\Column(length: 0xFF)]
        public ?string $link = '',

        #[ORM\Column(length: 0xFFFF)]
        public ?string $description = null,

        #[
            ORM\ManyToOne(targetEntity: Category::class, cascade: ['all'], inversedBy: 'items'),
            ORM\JoinColumn(nullable: false),
        ]
        public ?Category $category = null,

        #[
            ORM\ManyToOne(targetEntity: Size::class, cascade: ['all'], inversedBy: 'items'),
            ORM\JoinColumn(nullable: false),
        ]
        public ?Size $size = null,

        #[
            ORM\ManyToOne(targetEntity: Retailer::class, cascade: ['all'], inversedBy: 'items'),
            ORM\JoinColumn(nullable: false),
        ]
        public ?Retailer $retailer = null,

        #[ORM\Column]
        public float $price = 0,

        #[ORM\Column]
        public int $quantity = 0,

        #[
            ORM\ManyToOne(targetEntity: Image::class, cascade: ['all'], inversedBy: 'items'),
            ORM\JoinColumn(nullable: false),
        ]
        public ?Image $image = null,
    ) {
    }
}
