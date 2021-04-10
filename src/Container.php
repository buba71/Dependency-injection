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
   * @var Definition[]
   */
  private array $definitions = [];

  

  /**
   * @var array
   */
  private array $instances = [];

  
  /**
   * @var array
   */
  private array $aliases = [];

  /**
   * get
   *
   * @param  string $id
   * @return object
   */
  public function get(string $id): object
  {
    if (!$this->has($id)) {
      $instance = $this->resolve($id);
      if (!$this->getDefinition($id)->isShared()) {
        return $instance;
      }
      $this->instances[$id] = $instance;
      
    }
    return $this->instances[$id];
  }

  /**
   * @param string $id
   * 
   * @return object
   */
  private function resolve(string $id): object
  {
    $reflectionClass = new \ReflectionClass($id);

      if ($reflectionClass->isInterface()) {
        $id = $this->aliases[$id];
        return $this->resolve($id);
      }

      $this->getDefinition($id);

      $constructor = $reflectionClass->getConstructor();      
      
      if (null === $constructor) {        
        return $reflectionClass->newInstance();
      } 
      $parameters = $constructor->getParameters();

      foreach ($parameters as $parameter) {
        $instance = $this->get($parameter->getClass()->getName());
        $instancesOfParameters[] = $instance;
      }

      return $reflectionClass->newInstanceArgs($instancesOfParameters);
    
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

  
  /**
   * @param string $id
   * @param string $class
   * 
   * @return self
   */
  public function addAlias(string $id, string $class)
  {
    $this->aliases[$id] = $class;
    return $this;
  }

  /**
   * @param string $id
   * 
   * @return self
   */
  public function registerDef(string $id): self
  {
    $reflectionClass = new \ReflectionClass($id);

    if ($reflectionClass->isInterface()) {
      $this->registerDef($this->aliases[$id]);
      $this->definitions[$id] = &$this->definitions[$this->aliases[$id]];
      return $this;
    }

    $dependencies = [];
    if (null !== $reflectionClass->getConstructor()) {
      foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
        $definition = $this->getDefinition($parameter->getClass()->getName());

        $dependencies[] = $definition;
      }

    }
    
    $classSelfAliases = array_filter($this->aliases, fn(string $alias) => $id === $alias);

    $definition = new Definition($id, true, $classSelfAliases, $dependencies);
    
    $this->definitions[$id] = $definition;    

    return $this;
  }

  /**
   * @var string $id
   * @return Definition
   */
  public function getDefinition($id): Definition
  {
    if(!isset($this->definitions[$id])) {
      $this->registerDef($id);    
    }

    return $this->definitions[$id];
  }

}