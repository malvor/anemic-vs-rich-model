<?php

declare(strict_types=1);

namespace App\Tests;

use App\Anemic\Entity\Order;
use App\Anemic\Entity\OrderItem;
use App\Anemic\OrderService;
use PHPUnit\Framework\TestCase;

final class AnemicTest extends TestCase
{
    public function testAnemicModel() : void
    {
        $item1 = new OrderItem();
        $item1->setName('Lorem ipsum');
        $item1->setQuantity(1);
        $item1->setPrice(50);

        $item2 = new OrderItem();
        $item2->setName('Example product');
        $item2->setQuantity(5);
        $item2->setPrice(100);

        $item3 = new OrderItem();
        $item3->setName('New product');
        $item3->setQuantity(1);
        $item3->setPrice(200);

        $items = [
            $item1,
            $item2,
            $item3
        ];

        $cart = new Order();
        $orderService = new OrderService();
        foreach ($items as $item) {
            $orderService->addToOrder($cart, $item);
        }
        $orderService->calculateTotal($cart);

        self::assertInstanceOf(Order::class, $cart);
        self::assertEquals(750, $cart->getTotal());

        $orderService->order($cart);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Order is in invalid status!');

        $orderService->order($cart);
    }

    public function testEncapsulation() : void
    {
        $item1 = new OrderItem();
        $item1->setName('Lorem ipsum');
        $item1->setQuantity(1);
        $item1->setPrice(50);

        $item2 = new OrderItem();
        $item2->setName('Example product');
        $item2->setQuantity(5);
        $item2->setPrice(100);

        $item3 = new OrderItem();
        $item3->setName('New product');
        $item3->setQuantity(1);
        $item3->setPrice(200);

        $items = [
            $item1,
            $item2,
            $item3
        ];

        $cart = new Order();
        $orderService = new OrderService();
        foreach ($items as $item) {
            $orderService->addToOrder($cart, $item);
        }

        $cart->setTotal(500);
        $cart->setStatus(Order::STATUS_NEW);

        self::assertNotEquals(750, $cart->getTotal());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Order is in invalid status!');

        $orderService->order($cart);
    }
}
