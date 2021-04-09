<?php

declare(strict_types = 1);

namespace DDelima\DependencyInjection\Tests;

use DDelima\DependencyInjection\Tests\Fixtures\DataBase;
use DDelima\DependencyInjection\Tests\Fixtures\Router;
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

    $dataBase1 = $container->get(DataBase::class);
    $dataBase2 = $container->get(DataBase::class);

    static::assertInstanceOf(DataBase::class, $dataBase1);
    static::assertInstanceOf(DataBase::class, $dataBase2);
    static::assertEquals(spl_object_id($dataBase1), spl_object_id($dataBase2));
    static::assertInstanceOf(Router::class, $container->get(Router::class));
  }  
}