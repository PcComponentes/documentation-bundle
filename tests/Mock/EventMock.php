<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Tests\Mock;

use PcComponentes\Ddd\Domain\Model\DomainEvent;

final class EventMock extends DomainEvent
{
    public CONST messageName = 'message_name';
    public CONST messageVersion = '1';

    protected function assertPayload(): void
    {

    }

    public static function messageName(): string
    {
        return self::messageName;
    }

    public static function messageVersion(): string
    {
        return self::messageVersion;
    }
}
