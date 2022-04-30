<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Service;

use PcComponentes\DocumentationBundle\EventWithConverters;

class ConverterListing
{
    protected array $events = [];

    public function add(string $event, string $className, string $converter): void
    {
        if (false === \array_key_exists($event, $this->events)) {
            $this->events[$event] = EventWithConverters::from($event, $className);
        }
        
        $this->events[$event]->addConverter($converter);
    }

    /** @return array<EventWithConverters> */
    public function list(): array
    {
        return \array_values($this->events);
    }

    public function hasEvents(): bool
    {
        return 0 !== \count($this->events);
    }
}
