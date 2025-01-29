<?php

namespace App\Entity;

use App\Repository\RetailerRepository;
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
}
