<?php

declare(strict_types=1);


namespace App\Cart\Domain\OrderStatus;

enum OrderStatus : string
{
    case NEW = 'new';
    case CART = 'cart';
}
