<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\DependencyInjection\Compiler;

use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\DocumentationBundle\Service\ConverterListing;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MessageHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(ConverterListing::class)) {
            return;
        }

        $converterListingDefition = $container->findDefinition(ConverterListing::class);

        $taggedServices = $container->findTaggedServiceIds('messenger.message_handler');

        foreach ($taggedServices as $id => $tags) {
            $class = $container->getDefinition($id)->getClass();
            $parameters = (new \ReflectionMethod($class, '__invoke'))->getParameters();

            if (\count($parameters) !== 1) {
                continue;
            }

            $parameter = new \ReflectionClass($parameters[0]->getType()->getName());
            if (false === $parameter->isSubclassOf(DomainEvent::class)) {
                continue;
            }

            $converterListingDefition->addMethodCall('add', [
                ($parameter->getName())::messageName(),
                $parameter->getName(),
                $class,
            ]);
        }
    }
}