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
        #[ORM\Column(length: 32)]
        public ?string $number = null,
        #[ORM\Column(length: 512)]
        public string $image = '',
        #[ORM\Column]
        public int $quantity = 0,
        #[
            ORM\ManyToOne,
            ORM\JoinColumn(nullable: false),
        ]
        public ?Category $category = null,
        #[ORM\Column(length: 32)]
        public ?string $size = null,
        #[ORM\Column]
        public float $price = 0,
    ) {
    }

    public function equals(Item $other): bool
    {
        return $this->number === $other->number
            && $this->category?->id === $other->category?->id
            && $this->size === $other->size
            && $this->price === $other->price;
    }
}
