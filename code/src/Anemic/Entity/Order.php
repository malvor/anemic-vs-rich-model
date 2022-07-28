<?php

declare(strict_types=1);

namespace App\Anemic\Entity;

final class Order
{
    public const
        STATUS_CART = 'cart',
        STATUS_NEW = 'new'
    ;

    private int $total = 0;
    private array $items = [];
    private string $status = self::STATUS_CART;

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /** @return OrderItem[] */
    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
