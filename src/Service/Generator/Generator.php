<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Service\Generator;

use PcComponentes\DocumentationBundle\Exception\UnavailableDefinition;
use Symfony\Component\Routing\RouterInterface;

abstract class Generator
{
    protected RouterInterface $router;
    protected string $kernelDir;
    protected ?string $definitionPath;
    protected array $options;

    public function __construct(RouterInterface $router, string $kernelDir, ?string $definitionPath, array $options)
    {
        $this->router = $router;
        $this->kernelDir = $kernelDir;
        $this->definitionPath = $definitionPath;
        $this->options = $options;
    }

    public function render(): string
    {
        $this->assertDefinitionExists();

        return $this->template();
    }

    public function definition(): string
    {
        $this->assertDefinitionExists();

        return \file_get_contents($this->path());
    }

    public function options(): array
    {
        return $this->options;
    }

    public function isReady(): bool
    {
        try {
            $this->assertDefinitionExists();
        } catch (UnavailableDefinition $exception) {
            return false;
        }

        return true;
    }

    protected function definitionRoute(): string
    {
        return '';
    }

    protected function template(): string
    {
        return '';
    }

    protected function config(): array
    {
        return [];
    }

    private function assertDefinitionExists(): void
    {
        if (null === $this->definitionPath) {
            throw new UnavailableDefinition('Definition was not set');
        }

        $path = $this->path();

        if (false === \file_exists($path)) {
            throw new UnavailableDefinition(\sprintf('Definition file %s could not be found', $path));
        }
    }

    private function path(): string
    {
        return \rtrim($this->kernelDir, '/') . '/' . ltrim($this->definitionPath);
    }
}
