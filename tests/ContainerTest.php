<?php

declare(strict_types = 1);

namespace DDelima\DependencyInjection\Tests;

use DDelima\DependencyInjection\Tests\Fixtures\DataBase;
use DDelima\DependencyInjection\Tests\Fixtures\Router;
use DDelima\DependencyInjection\Tests\Fixtures\RouterInterface;
use DDelima\DependencyInjection\Tests\Fixtures\Foo;
use DDelima\DependencyInjection\Container;
use PHPUnit\Framework\TestCase;

/**
 * Class ContainerTest
 */
final class ContainerTest extends TestCase
{
  public function test()
  {
    $container = new Container();
    $container->addAlias(RouterInterface::class, Router::class);

    $container->getDefinition(Foo::class)->setShared(false);


    $dataBase1 = $container->get(DataBase::class);
    $dataBase2 = $container->get(DataBase::class);
    
    static::assertInstanceOf(DataBase::class, $dataBase1);
    static::assertInstanceOf(DataBase::class, $dataBase2);
    static::assertEquals(spl_object_id($dataBase1), spl_object_id($dataBase2));
    static::assertInstanceOf(Router::class, $container->get(RouterInterface::class));

    $foo1 = $container->get(Foo::class);
    $foo2 = $container->get(Foo::class);
  
    static::assertNotEquals(spl_object_id($foo1), spl_object_id($foo2));
    
  }  
}