<?php

declare(strict_types=1);

namespace Src\BoundedContext\User\Domain\Events;

use Src\Shared\Domain\Bus\Event\AbstractDomainEvent;

final class UserWasCreated extends AbstractDomainEvent
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($email, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): AbstractDomainEvent {
        return new self($aggregateId, $body['name'], $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'board.was_created';
    }

    public function toPrimitives(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
        ];
    }
}
