<?php

declare(strict_types = 1);

namespace DDelima\DependencyInjection;

use Psr\Container\ContainerInterface;

/**
 * Class Container
 */
final class Container implements ContainerInterface
{  

  /**
   * @var array
   */
  private array $instances = [];

   
  /**
   * get
   *
   * @param  string $id
   * @return object
   */
  public function get(string $id): object
  {
    if (!$this->has($id)) {
      $reflectionClass = new \ReflectionClass($id);
      $constructor = $reflectionClass->getConstructor();
      
      if (null === $constructor) {
        $this->instances[$id] = $reflectionClass->newInstance();
      } else {
        $parameters = $constructor->getParameters();

        foreach ($parameters as $parameter) {
          $instance = $this->get($parameter->getClass()->getName());
          $instancesOfParameters[] = $instance;
        }

        $this->instances[$id] = $reflectionClass->newInstanceArgs($instancesOfParameters);
      }
      
    }
    return $this->instances[$id];
  }
  
  /**
   * has
   *
   * @param  string $id
   * @return bool
   */
  public function has(string $id): bool
  {
    return isset($this->instances[$id]);
  }

}