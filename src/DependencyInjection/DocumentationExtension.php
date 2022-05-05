<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\DependencyInjection;

use PcComponentes\DocumentationBundle\Service\Generator\AsyncApiGenerator;
use PcComponentes\DocumentationBundle\Service\Generator\OpenApiGenerator;
use PcComponentes\DocumentationBundle\Service\LinkListing;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DocumentationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config'),
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $openApiDefinition = $container->getDefinition(OpenApiGenerator::class);
        $openApiDefinition->setArgument('$definitionPath', $config['openapi']);
        $openApiDefinition->setArgument('$options', $config['swagger_options']);

        $asyncApiDefinition = $container->getDefinition(AsyncApiGenerator::class);
        $asyncApiDefinition->setArgument('$definitionPath', $config['asyncapi']);
        $asyncApiDefinition->setArgument('$options', $config['asyncapi_options']);

        $asyncApiDefinition = $container->getDefinition(LinkListing::class);
        $asyncApiDefinition->addMethodCall('set', [$config['links']]);
    }
}
