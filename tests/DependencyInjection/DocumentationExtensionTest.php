<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Tests\DependencyInjection;

use PcComponentes\DocumentationBundle\DependencyInjection\DocumentationExtension;
use PcComponentes\DocumentationBundle\Service\Generator\AsyncApiGenerator;
use PcComponentes\DocumentationBundle\Service\Generator\OpenApiGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class DocumentationExtensionTest extends TestCase
{
    private array $configs = [
        "documentation" => [
            "openapi" => "docs/openapi.yml",
            "asyncapi" => "docs/asyncapi.yml",
            "swagger_options" => [
                "deepLinking" => true,
                "displayOperationId" => true,
                "displayRequestDuration" => true,
            ],
            "asyncapi_options" => [
                "schemaFetchOptions" => "{\"method\":\"GET\",\"mode\":\"cors\"}",
                "config" => "{\"show\":{\"sidebar\":true},\"sidebar\":{\"showOperations\":\"byDefault\"}}",
            ]
        ]
    ];

    /** @test */
    public function given_valid_configuration_for_openapi_then_ok()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            OpenApiGenerator::class => new Definition(OpenApiGenerator::class),
        ]);

        $extension = new DocumentationExtension();
        $extension->load($this->configs, $containerBuilder);

        $definition = $containerBuilder->getDefinition(OpenApiGenerator::class);
        $this->assertInstanceOf(Reference::class, $definition->getArgument(0));
        $this->assertEquals('router', $definition->getArgument(0)->__toString());
        $this->assertEquals('%kernel.project_dir%', $definition->getArgument(1));
        $this->assertEquals('docs/openapi.yml', $definition->getArgument('$definitionPath'));
        $this->assertEquals([
            "deepLinking" => true,
            "displayOperationId" => true,
            "displayRequestDuration" => true,
        ], $definition->getArgument('$options'));
    }

    /** @test */
    public function given_valid_configuration_for_asyncapi_then_ok()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            AsyncApiGenerator::class => new Definition(AsyncApiGenerator::class),
        ]);

        $extension = new DocumentationExtension();
        $extension->load($this->configs, $containerBuilder);

        $definition = $containerBuilder->getDefinition(AsyncApiGenerator::class);

        $this->assertInstanceOf(Reference::class, $definition->getArgument(0));
        $this->assertEquals('router', $definition->getArgument(0)->__toString());
        $this->assertEquals('%kernel.project_dir%', $definition->getArgument(1));
        $this->assertEquals('docs/asyncapi.yml', $definition->getArgument('$definitionPath'));
        $this->assertEquals([
            "schemaFetchOptions" => "{\"method\":\"GET\",\"mode\":\"cors\"}",
            "config" => "{\"show\":{\"sidebar\":true},\"sidebar\":{\"showOperations\":\"byDefault\"}}",
        ], $definition->getArgument('$options'));
    }
}
