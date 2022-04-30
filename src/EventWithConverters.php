<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle;

final class EventWithConverters implements \JsonSerializable
{
    private string $name;
    private string $className;
    private array $converters = [];

    private function __construct(string $name, string $className)
    {
        $this->name = $name;
        $this->className = $className;
    }

    public static function from(string $name, string $className): self
    {
        return new EventWithConverters($name, $className);
    }

    public function addConverter(string $converter): void
    {
        if (true === \in_array($converter, $this->converters, true)) {
            return;
        }

        $this->converters[] = $converter;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function className(): string
    {
        return $this->className;
    }

    public function converters(): array
    {
        return $this->converters;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'className' => $this->className,
            'converters' => $this->converters,
        ];
    }
}
