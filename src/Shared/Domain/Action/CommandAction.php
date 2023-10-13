<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Action;

use Exception;
use ReflectionClass;

abstract class CommandAction implements CommandActionInterface
{
    public function __invoke(...$args)
    {
        $class = new ReflectionClass($this);
        if ($class->hasMethod('validate')) {
            $class->getMethod('validate')->invoke($this, ...$args);
        }
        if ($class->hasMethod('handle')) {
            $class->getMethod('handle')->invoke($this, ...$args);
        }else {
            throw new Exception("Action doesn't implement 'handle' method");
        }
    }
}
