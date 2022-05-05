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
        $events = \array_merge([], \array_values($this->events));

        \usort($events, static fn (EventWithConverters $a, EventWithConverters $b) => \strcmp($a->name(), $b->name()));

        return $events;
    }

    public function hasEvents(): bool
    {
        return 0 !== \count($this->events);
    }
}
