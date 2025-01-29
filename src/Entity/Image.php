<?php

namespace App\Entity;

use App\Repository\RetailerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetailerRepository::class)]
class Image
{
    public function __construct(
        #[
            ORM\Id,
            ORM\GeneratedValue,
            ORM\Column,
        ]
        public ?int $id = null,

        #[ORM\Column(length: 0xFF)]
        public ?string $type = null,

        #[ORM\Column(length: 0xFFFFFF)]
        public string $data = '',

        #[ORM\Column(length: 0xFF)]
        public string $hash = '',
    ) {
    }
}
