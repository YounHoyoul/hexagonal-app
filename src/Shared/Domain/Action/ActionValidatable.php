<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Action;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use Src\Shared\Domain\Contracts\ValidationCheckContract;

trait ActionValidatable
{
    public function validate(...$args): bool
    {
        return $this->getValidationChecker()->pass(
            data: $this->getData(...$args),
            rules: $this->getRules(...$args)
        );
    }

    private function getValidationChecker(): ValidationCheckContract
    {
        $constructor = (new ReflectionClass(self::class))->getConstructor();
        foreach ($constructor->getParameters() as $param) {
            if ($param->getType()->getName() === ValidationCheckContract::class) {
                $name = $param->getName();

                return $this->$name;
            }
        }

        return throw new Exception('ValidationCheckContract is not initialised in constructor.');
    }

    private function getData(...$args): array
    {
        return $this->runMethod($args, 'value');
    }

    private function getRules(...$args): array
    {
        return $this->runMethod($args, 'rule');
    }

    private function runMethod(array $args, string $methodName): array
    {
        return array_merge(...array_map(fn ($param, $name) => [
            $name => (new ReflectionMethod($param, $methodName))->invoke($param),
        ], $args, array_keys($args)));
    }
}
