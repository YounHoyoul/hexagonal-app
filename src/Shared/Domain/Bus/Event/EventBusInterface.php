<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Bus\Event;

interface EventBusInterface
{
    public function publish(AbstractDomainEvent ...$events): void;
}
