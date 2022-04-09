<?php

declare(strict_types=1);

namespace Lemon\Tests\Kernel;

use Lemon\Kernel\Container;
use Lemon\Kernel\Exceptions\ContainerException;
use Lemon\Kernel\Exceptions\NotFoundException;
use Lemon\Tests\Kernel\Resources\Units\Bar;
use Lemon\Tests\Kernel\Resources\Units\Foo;
use PHPUnit\Framework\TestCase;

class ContainerTests extends TestCase
{
    public function testAddService()
    {
        $container = new Container();

        $container->add(Foo::class);
        $this->assertSame([Foo::class], $container->services());
        $container->add(Bar::class);
        $this->assertSame([Foo::class, Bar::class], $container->services());

        $this->expectException(ContainerException::class);
        $container->add(Foo::class);
        $this->expectException(NotFoundException::class);
        $container->add('Klobna');
    }

    public function testGetService()
    {
        $container = new Container();
        $container->add(Foo::class);
        $foo = $container->get(Foo::class);
        $this->assertInstanceOf(Foo::class, $foo);
        $this->assertSame($foo, $container->get(Foo::class));

        $container->add(Bar::class);
        $this->assertInstanceOf(Bar::class, $container->get(Bar::class));

        $container = new Container();
        $this->expectException(NotFoundException::class);
        $container->get(Bar::class);
    }

    public function testHasService()
    {
        $container = new Container();
        $container->add(Foo::class);
        $this->assertTrue($container->has(Foo::class));
        $this->assertFalse($container->has('klobna'));
    }

    public function testAlias()
    {
        $container = new Container();
        $container->add(Foo::class);
        $container->alias('klobna', Foo::class);
        $this->assertSame($container->get(Foo::class), $container->get('klobna'));
        $this->expectException(NotFoundException::class);
        $container->get('parek');
        $container->alias('rizek', Bar::class);
    }

}
