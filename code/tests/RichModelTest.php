<?php

declare(strict_types=1);

namespace App\Tests;

use App\Cart\Domain\CartItem\OrderItem;
use App\Cart\Domain\Exception\InvalidOrderStatusException;
use App\Cart\Domain\Order;
use PHPUnit\Framework\TestCase;

final class RichModelTest extends TestCase
{
    public function testRichModel() : void
    {
        $items = [
            new OrderItem(50, 1, 'Lorem ipsum'),
            new OrderItem(100, 5, 'Example product'),
            new OrderItem(200, 1, 'New product')
        ];

        $cart = new Order();
        foreach ($items as $item) {
            $cart->addItem($item);
        }

        self::assertInstanceOf(Order::class, $cart);
        self::assertEquals(750, $cart->getTotal());

        $cart->order();

        $this->expectException(InvalidOrderStatusException::class);
        $this->expectExceptionMessage('Order is in invalid status!');

        $cart->order();
    }
}
