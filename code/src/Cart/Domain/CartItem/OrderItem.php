<?php

declare(strict_types=1);

namespace App\Cart\Domain\CartItem;

use App\Cart\Domain\CartItem\Exception\InvalidPriceNumberException;
use App\Cart\Domain\CartItem\Exception\InvalidQuantityNumberException;

final class OrderItem
{
    public function __construct(
        private int $price,
        private int $quantity,
        private string $name
    ) {
        if ($quantity < 1) {
            throw new InvalidQuantityNumberException('Quantity must be 1 or greater!');
        }

        if ($price <= 0) {
            throw new InvalidPriceNumberException('Price has to be greater than 0!');
        }
    }

    public function getTotalPrice() : int
    {
        return $this->quantity * $this->price;
    }
}
