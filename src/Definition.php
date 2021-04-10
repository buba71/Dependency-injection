<?php

declare(strict_types = 1);

namespace DDelima\DependencyInjection;

final class Definition
{
  /**
   * @var string
   */
  private string $id;

  /**
   * @var Definition[]
   */
  private array $dependencies = [];

  /**
   * @var bool
   */
  private bool $shared = true;

  
  /**
   * @var array|null
   */
  private array $aliases = [];

  
  /**
   * @param string $id
   * @param bool $shared
   * @param array $alias
   * @param array $dependencies
   * 
   * @return [tvoid
   */
  public function __construct(string $id, bool $shared = true, array $aliases = [], array $dependencies = [])
  {
    $this->id     = $id;
    $this->shared = $shared;
    $this->aliases  = $aliases;
    $this->dependencies = $dependencies;
  }

  
  
  /**
   * @param bool $shared
   * 
   * @return self
   */
  public function setShared(bool $shared): self
  {
    $this->shared = $shared;
    return $this;
  }

  /**
   * @return bool
   */
  public function isShared(): bool
  {
    return $this->shared;
  }

}