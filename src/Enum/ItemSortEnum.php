<?php

namespace App\Enum;

enum ItemSortEnum: string
{
    case ID = 'i.id';
    case Quantity = 'i.quantity';
    case Category = 'c.name';
    case Size = 's.name';
    case Price = 'i.price';
}