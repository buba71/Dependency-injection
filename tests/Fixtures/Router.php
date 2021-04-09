<?php

declare(strict_types = 1);

namespace DDelima\DependencyInjection\Tests\Fixtures;

/**
 * Class Router
 */
final class Router implements RouterInterface
{
  public function __construct(Foo $foo) 
  {
  }

  public function call()
  {
    
  }

}