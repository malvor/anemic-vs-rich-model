<?php

declare(strict_types=1);

namespace App\Anemic;

use App\Anemic\Entity\Order;
use App\Anemic\Entity\OrderItem;

final class OrderService
{
    public function calculateTotal(Order $order) : void
    {
        $total = 0;
        $items = $order->getItems();

        foreach ($items as $item) {
            $quantity = $item->getQuantity();
            $price = $item->getPrice();
            $itemTotal = $quantity * $price;

            $total += $itemTotal;
        }

        $order->setTotal($total);
    }

    public function addToOrder(Order $order, OrderItem $orderItem) : void
    {
        $items = $order->getItems();
        $items[] = $orderItem;

        $order->setItems($items);
    }

    public function order(Order $order) : bool
    {
        $orderStatus = $order->getStatus();
        if ($orderStatus !== Order::STATUS_CART) {
            throw new \InvalidArgumentException('Order is in invalid status!');
        }

        if (\count($order->getItems()) === 0) {
            throw new \InvalidArgumentException('Your cart is empty!');
        }

        $order->setStatus(Order::STATUS_NEW);

        return true;
    }
}
