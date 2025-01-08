<?php

namespace App\Enum;

enum ItemSortEnum: string
{
    case ID = 'id';
    case Number = 'number';
    case Quantity = 'quantity';
    case Category = 'categories';
    case Size = 'size';
    case Price = 'price';
}