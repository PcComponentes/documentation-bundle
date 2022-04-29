<?php

namespace PcComponentes\DocumentationBundle\Service;

use PcComponentes\DocumentationBundle\EventWithConverters;
use PcComponentes\DocumentationBundle\Exception\UnavailableDefinition;
use Symfony\Component\Routing\RouterInterface;

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

    /**
     * @return array<EventWithConverters>
     */
    public function list(): array
    {
        return \array_values($this->events);
    }
}