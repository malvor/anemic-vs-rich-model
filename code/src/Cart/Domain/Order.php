<?php

declare(strict_types=1);

namespace App\Cart\Domain;

use App\Cart\Domain\CartItem\OrderItem;
use App\Cart\Domain\Exception\EmptyCartException;
use App\Cart\Domain\Exception\InvalidOrderStatusException;
use App\Cart\Domain\OrderStatus\OrderStatus;

final class Order
{
    private int $total = 0;
    /** @var OrderItem[] */
    private array $items = [];

    private OrderStatus $status;

    public function __construct()
    {
        $this->status = OrderStatus::CART;
    }

    public function addItem(OrderItem $orderItem) : void
    {
        $this->items[] = $orderItem;
        $this->recalculateCart();
    }

    public function order() : void
    {
        $this->assertStatus();

        if (\count($this->items) === 0) {
            throw new EmptyCartException('Your cart is empty!');
        }

        $this->status = OrderStatus::NEW;
    }

    public function getTotal() : int
    {
        return $this->total;
    }

    private function recalculateCart() : void
    {
        $this->total = 0;
        foreach ($this->items as $item) {
            $this->total += $item->getTotalPrice();
        }
    }

    private function assertStatus() : void
    {
        if ($this->status !== OrderStatus::CART) {
            throw new InvalidOrderStatusException('Order is in invalid status!');
        }
    }
}
